<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
 <link rel="stylesheet" href="/ui/style.css" type="text/css" />
 <title>Hob Project Homepage</title>
</head>

<body>

<!-- thanks Drew McLellan, support transparent PNG for email -->
<!--[if lte IE 6]>
	<script type="text/javascript" src="/ui/supersleight-min.js"></script>
<![endif]-->

<?php include('../../top.php') ?>
<?php include('../../menu.php') ?>

<div id="main">
<h1>The Hob System</h1>

<h2 style="text-align:center">"I verify, therefore I am consistent!"</h2>

<blockquote cite="http://dictionary.reference.com/search?q=hob"><p>hob. 1. The block in the center of a wheel, from which the spokes radiate, and through which the axle passes; -- called also hub or hob.</p>

<p style="text-align:right"> Webster's Revised Unabridged Dictionary, &copy; 1996, 1998 MICRA, Inc.</p>
</blockquote>

<p style="padding-top:1em; text-align:center"><img src="our-approach-white.png" alt="Diagram Highlighting Our Approach" /></p>

<p>The goal of the <b>Hob</b> project is to verify sophisticated properties of
programs that manipulate complex, heterogenous data structures.</p>

<h2>Dissertation</h2>

<p>The final version of my PhD thesis as submitted to MIT:</p>

<ul>

<li>Patrick Lam.  <a href="/papers/plam-thesis.ps">The Hob System for
Verifying Software Design Properties.</a> PhD thesis, Massachusetts
Institute of Technology.  February 2007. [<a href="/papers/plam-thesis.pdf">pdf</a>,
<a href="/papers/plam-thesis.bib">bib</a>] [<a href="/papers/plam-defense.pdf">defense slides pdf</a>]</li>

</ul>

<p>My <a href="/publications">other publications</a> also contain
information on Hob; the TSE 2006 paper is a short overview of the
whole system. You may also be interested in
the <a href="http://lara.epfl.ch/dokuwiki/doku.php?id=jahob_system">Jahob</a>
system, which explores a different point in the design space (more
powerful but less intuitive specifications).</p>

<h2>Overview</h2>
<p> With my PhD advisor
 <a href="http://cag.lcs.mit.edu/%7Erinard">Martin Rinard</a> and
 colleagues <a href="http://lara.epfl.ch/~kuncak">Viktor
 Kuncak</a>, <a href="http://www.mit.edu/~kkz">Karen Zee</a>, and
 <a href="http://www.mpi-sb.mpg.de/~wies/">Thomas Wies</a>, I have developed the Hob system for verifying software
design properties.  The Hob system
 enables developers to apply sophisticated static analysis
 techniques&mdash;even those that have traditionally been difficult to
 apply due to scalability issues&mdash;by structuring the verification
 task.  The key idea is that, by using set interfaces to specify
 preconditions and postconditions for procedures, our analysis system
 can soundly apply analyses on a per-procedure basis: any individual
 analysis only needs to scale up to the size of a procedure, not the
 size of the program as a whole.  Furthermore, set interfaces also
 enable developers to state and verify properties which span multiple
 modules, since all modules describe the program state using a shared
 abstraction language. </p>

<p>We have implemented our system and deployed three <a href="plugins.php">pluggable analyses</a>
into it: a flag analysis for modules in which abstract set membership
is determined by a flag field in each object, a plugin for modules
that encapsulate linked data structures such as lists and trees, and
an array plugin in which abstract set membership is determined by
membership in an array. Our experimental results indicate that our
approach makes it possible to effectively combine multiple analyses to
verify properties that involve objects shared by multiple modules,
with each analysis analyzing only those modules for which it is
appropriate.</p>

<p>We have successfully verified a <a href="examples.php">number of benchmark programs</a> with Hob.
One benchmark is an implementation of a web server in the Hob
language.  This benchmark contains 1200 lines of implementation
(including a doubly-linked list) and 400 lines of specification.  We
also have analyzed the popular minesweeper game, which contains 900
lines of implementation and 300 lines of specification.  For the
minesweeper benchmark, we used the unscalable PALE plugin and theorem proving
plugins to verify 150 lines of code (the largest example distributed
with the PALE tool contains 120 lines of code), and the scalable field
analysis to verify the other 750 lines.</p>

<h2><a name="implementation">Implementation</a></h2>

<p>Our implementation provides an infrastructure with several general
components that perform tasks required by all analyses. The
implementation language component can parse and type-check
implementation sections.  It produces an abstract syntax tree and
methods that allow analyses to conveniently access this
representation.  Similarly, the specification component can parse and
type check specification sections and provides access to the resulting
abstract syntax tree. Large parts of abstraction sections are
expressed in a language that is specific to each analysis.  The
abstraction section component parses those parts of the abstraction
section syntax that are common to all analyses and uses uninterpreted
strings to pass along the analysis-specific parts. Finally, the
implementation provides a driver that processes the program and
invokes the appropriate analysis for each module that it encounters.
Our implementation consists of approximately 10,000 lines of O'Caml
code, to which the flag plugin contributes 2000 lines, the PALE plugin
another 700 lines, and the array analysis plugin 1000 lines.</p>


<?php include('../../bottom.php') ?>

</body>
</html>
