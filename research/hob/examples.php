<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
 <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
 <link rel="stylesheet" href="/ui/style.css" type="text/css" />
 <title>Hob Plugins</title>
</head>

<body>

<!-- thanks Drew McLellan, support transparent PNG for email -->
<!--[if lte IE 6]>
	<script type="text/javascript" src="/ui/supersleight-min.js"></script>
<![endif]-->

<?php include('../../top.php') ?>
<?php include('../../menu.php') ?>
<div id="main">     
<h2>Example Applications</h2>

<p>We implemented our system and, to obtain experience using it, coded up
several benchmark programs, using our system during the development of
the programs.</p>

<p>Our system verifies 1) the consistency of individual data structures
encapsulated in instantiable modules, 2) that the rest of the program
uses each module correctly, and 3) important properties that involve
data structures encapsulated in different modules.  The following
examples illustrate how our approach enables the verification of
properties that span multiple modules.  </p>

<h3><a name="water">Water</a></h3>

<p>We have ported the 
<a href="http://patricklam.ca/svn/repos-code/trunk/benchmarks/water">Water 
program</a> from the <a
href="http://citeseer.ist.psu.edu/berry88perfect.html"> Perfect
Club</a> benchmark, which uses a predictor/corrector method to
evaluate forces and potentials in a system of water molecules in the
liquid state. The central loop of the computation performs a time step
simulation.  Each step predicts the state of the simulation, uses the
predicted state to compute the forces acting on each molecule, uses
the computed forces to correct the prediction and obtain a new
simulation state, and uses the new simulation state to compute the
potential and kinetic energy of the system.</p>

<p>We use abstract sets to model the conceptual typestates
of the data structures as the computation processes them.
The predictor computation requires the object
storing the simulation state to start in the corrected
set. It then moves this object from the corrected set
to the predicted set. The force computation moves the
force object from the invalid set to the valid set;
the corrector computation requires the object storing the
simulation state to start in the predicted set, then moves
it to the corrected set. It requires the object representing
the forces to start in the valid set, then moves it into the
invalid set (conceptually, the correction invalidates the 
computed forces). The energy computations require the 
object storing the simulation state to be in the 
corrected state.  We include a typical specification, that of the
inter-molecule forces computation:</p>

<pre>
  proc INTERF(m:MoleculeData; f:ForceData) returns cf : ForceData
    requires (m in Predicted) &amp; (f in InterfUncomputed) &amp;
    modifies InterfUncomputed, InterfComputed
    ensures (cf' = f) &amp;
            (InterfUncomputed' = InterfUncomputed - cf') &amp;
            (InterfComputed' = InterfComputed + cf');
</pre>

<p>We found that our system enabled us to easily express the conceptual
state that each object in the data structure needed to
be in for the computation to operate correctly. The
flag analysis was able to verify that the program 
staged the computation correctly.</p>

<h3>Minesweeper</h3>

<p>Our 
<a href="http://patricklam.ca/svn/repos-code/trunk/benchmarks/minesweeper">
minesweeper implementation</a> has several modules, as shown below: a game board
module (which represents the game state), a controller module (which
responds to user input), a view module (which produces the game's
output), an exposed cell module (which stores the exposed cells in an
array), and an unexposed cell module (which stores the unexposed cells
in an instantiated linked list).  There are 750 non-blank lines of
implementation code in the 6 implementation sections of minesweeper,
and 236 non-blank lines in its specification and abstraction sections.</p>

<div id="structure" class="diagram" style="text-align:center">
<p><img src="minesweeper-modules.png" alt="Modules in Minesweeper"/></p>
</div>

<p>Our minesweeper implementation uses the standard
model-view-controller (MVC) <a
href="http://en.wikipedia.org/wiki/Design_pattern_%28computer_science%29">design
pattern</a>.  The <code>board</code> module (which stores an array of
<code>Cell</code> objects) implements the model part of the MVC
pattern. Each <code>Cell</code> object may be mined, exposed or
marked.  The <code>board</code> module represents this state
information by contributing <code>isMined</code>,
<code>isExposed</code> and <code>isMarked</code> flags to
<code>Cell</code> objects.  At an abstract level, the sets
<code>MarkedCells</code>, <code>MinedCells</code>,
<code>ExposedCells</code>, <code>UnexposedCells</code>, and
<code>U</code> (for Universe) represent sets of cells with various
properties; the <code>U</code> set contains all cells known to the
board.  The board also uses a flag <code>gameOver</code>, which it
sets to <code>true</code> when the game ends.</p>

<div id="shot" class="diagram">
<p style="text-align:center">
<img src="minesweeper.png" alt="Minesweeper Screenshot"/></p>
</div>

<h3>Minesweeper Inter-Module Properties</h3>
<p>Our system verifies that our implementation has the 
<a name="inter-properties">following
properties</a> (among others):</p>

<ul>
<li> Unless the game is over, the set of mined cells is disjoint from
  the set of exposed cells.</li>
<li> The sets of exposed and unexposed cells are disjoint.</li>
<li> The set of unexposed cells maintained in the
  <code>board</code> module is identical to the set of unexposed
  cells maintained in the <code>UnexposedList</code> list.</li>
<li> The set of exposed cells maintained in the
  <code>board</code> module is identical to the set of exposed
  cells maintained in the <code>ExposedSet</code>
  array.</li>
<li> At the end of the game, all cells are revealed; <em>i.e.</em>  the
  set of unexposed cells is empty.</li>
</ul>

<h2><a name="intra-properties">Stack Data Structure</a></h2>

<p>For our stack example, we maintain an abstract set <code>S</code>
representing the content of the stack, and verify that stack
insertions actually insert the given object into the stack 
(<code>S' = S + e</code>), and that removal actually 
removes an object from the stack,
if possible: <code>card(S) = 0 | (exists e:Entry. (S' = S - e) &amp;
card(e) =1)</code>).</p>

<p>Our PALE plugin checks that objects that belong to a set have
consistent values for navigational fields (e.g. <code>next</code>,
<code>prev</code>), and that objects that do not belong to the set
have those fields set to <code>null</code>.  Initially, our
implementation for <code>removeFirst</code> was:</p>

<pre>
     proc removeFirst() returns e:Entry {
         Entry res = root;
         if (root != null) root = root.next;
         pragma "removed res";
         return res;
     }
</pre>

<p>where the <code>pragma</code> statement indicates to the analysis that it is
verifying a set removal.  However, the analysis reports an error while verifying this implementation.
Careful inspection of this code, however,
reveals that the removed object, <code>res</code>, will still have a
reference to an object in the stack after removal; this is potentially
problematic, as it may lead to non-list structures
being present in the heap.  Our plugin therefore requires us to add
<code> res.next = null</code> to this procedure, so that all
objects subsequently passed to this module will have <code>next</code>
set to <code>null</code>.</p>

<h2>Process Scheduler</h2>

<p>Our process scheduler benchmark maintains a list of running processes and a
priority queue of suspended processes. There are three modules in our
process scheduler implementation: the {\tt RunningList} module (which
maintains the list of running processes), the {\tt SuspendedQueue}
module (which maintains the queue of suspended processes), and the
{\tt Scheduler} module (which implements the specification for the
scheduler).  The running list and suspended queue are verified using
the PALE plugin, whereas the scheduler itself is verified with the
flag plugin.  Both the data structures and the core scheduler know
whether a process is running or suspended: the core scheduler uses
flags to indicate set membership, whereas the data structures use heap
reachability to track membership. One of the global invariants ensures
that the sets in the scheduler and in the data structures coincide.
Our analysis also verifies that the set of running processes is always
disjoint from the set of suspended processes:</p>

<pre>
    invariant (Running = RunningList.InList) &amp;
              (Suspended = SuspendedQueue.InQueue) &amp;
              disjoint (Running, Suspended);
</pre>
<?php include('../../bottom.php') ?>

</div>

</body>
</html>
