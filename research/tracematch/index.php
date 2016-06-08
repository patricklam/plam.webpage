<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
 <link rel="stylesheet" href="/ui/style.css" type="text/css" />
 <title>Static Analysis of Tracematches</title>
</head>

<body>

<?php include('../../top.php') ?>
<?php include('../../menu.php') ?>

<div id="main">

<h1>Static Analysis of Tracematches</h2>

<p>Tracematches enable the specification of program properties 
that relate the states of multiple objects. They are especially useful
for specifying library usage constraints: for instance, 
</p>

<ul>
<li> an <code>Iterator</code>'s <code>next</code> method should not be
called twice without any intervening call to <code>hasNext</code>; </li>
<li> an <code>Iterator</code>'s methods may not be called if the underlying
<code>Collection</code> has been modified after <code>Iterator</code>
creation; and</li>
<li> in the <a href="http://weka.sourceforge.net">Weka</a> mechine
learning toolkit, a <code>Filter</code>'s <code>setInputFormat</code>
method must be the last call before applying the <code>Filter</code>.
</li>
</ul>

<p>We believe that tracematches are useful for checking many safety
properties of Java programs, since many Java programs are structured
as a collection of libraries with some driver code.</p>

<h2>Structure of Tracematches</h2>

<p>Developers specify tracematches using an extension to <a href="http://eclipse.org/aspectj">AspectJ</a>. We can understand tracematches by representing them with finite automata, like the one below:</p>
<p style="text-align:center"><img src="tm-automaton.jpg" alt="hasNext automaton"></p>

<p>A tracematch declaration contains (1) tracematch variables; (2) event
declarations; (3) a regular expression over the declared events; and (4) 
code to execute if the program's execution matches the regular expression.
We can write the above tracematch as follows:</p>

<pre>
tracematch(Iterator i) {
    sym hasNext before: call(* java.util.Iterator+.hasNext()) && target(i);
    sym next before: call(* java.util.Iterator+.next()) && target(i);

    next next {
        /* handle error */
    }
</pre>

<h2>Research Goal</h2>

<p>The goal of our research on tracematches is to statically analyze
tracematches and determine when they cannot trigger. For tracematches
that describe software safety properties, if we can statically verify
that a tracematch never triggers, then we have statically verified the
desired safety property.</p>

<p>With <a href="http://bodden.de">Eric Bodden</a>
and <a href="http://www.sable.mcgill.ca/~hendren">Laurie Hendren</a>, I have therefore
worked on the static analysis of tracematches.</p>

<ul>
<li>Eric Bodden, Laurie Hendren, and Ondrej Lhotak. ECOOP 2007: <a href="http://www.bodden.de/pubs/bhl07astaged.pdf">A staged static program analysis to improve the performance of runtime monitoring.</a> [<a href="http://www.bodden.de/research/publications/#ECOOPStaged">bib</a>] (I didn't write this paper, but I've included it as it provides context for the following papers.)</li>
<li>Eric Bodden, Laurie Hendren, Patrick Lam, Ondrej Lhotak, Nomair A. Naeem. RV 2007: <a href="/papers/07.rv.crv.ps">Collaborative runtime verification with tracematches</a> [<a href="/papers/07.rv.crv.pdf">pdf</a>, <a href="/papers/07.rv.crv.bib">bib</a>]. (Extended version under review for Journal of Logic and Computation.) </li>
<li>Eric Bodden, Patrick Lam and Laurie Hendren. In proceedings of FSE 2008: Finding Programming Errors Earlier by Evaluating Runtime Monitors Ahead-of-Time.</li>
<li>Eric Bodden, Patrick Lam and Laurie Hendren. In proceedings of Visions of Computer Science 2008, British Computer Society: Object Representatives: a uniform abstraction for pointer information.</li>
</ul>

<?php include('../../bottom.php') ?>

</body>
</html>
