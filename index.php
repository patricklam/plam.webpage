<!DOCTYPE html>
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=utf-8">
 <meta name="verify-v1" content="uWOD3hwnkhqEtxfofLKoWL1CnqK8DE4T7+kDt10MhEw=">
 <link rel="stylesheet" href="/ui/style.css" type="text/css">
 <title>Patrick Lam</title>
</head>

<body>

<?php include('top.php') ?>
<?php include('menu.php') ?>

<div id="main">

<p>I'm looking for students. If you are interested in doing research with 
me at the University of Waterloo, please contact me and we can see if
we have mutual interests. Be sure to provide some evidence that you
know something about my research interests in your email!</p>

<!-- <p>I am particularly interested in supervising fourth-year <a href="http://ece.uwaterloo.ca/~ece499">ECE499</a> projects. If you are a current Waterloo ECE or SE third- or fourth-year student, and think you might be interested in my research areas, ECE499 or a co-op work term with me are good ways to find out if you want to do more research. </p>-->

<h2>Research</h2>

<p>Software development often involves manually encoding high-level
design information using low-level programming constructs. This can be
repetitive and error-prone. My research therefore aims to give
developers ways to automatically link high-level designs to low-level
implementations, through the use of programming language extensions,
particularly those amenable to static or dynamic program analysis.</p>

<h3>Current Projects</h3>

<ul>
<li> <a href="http://demsky.eecs.uci.edu/views">Views</a>: with <a href="http://demsky.eecs.uci.edu">Brian Demsky</a>, we developed a novel language extension enabling developers to declaratively specify fine-grained (sub-object-level) locking policies.</li>
<li> Transactional memory: another approach attempting to mitigate the difficulty of concurrent programming. With Gaurav Jain, I am investigating the use of novel interfaces for transactional memory. As with views, our interpretation of transactional memory bridges the gaps between the developer, the compiler and the runtime system. </li>
<li> Unread memory: A well-understood software safety property is that it must not read memory that has not previously been written to. <a href="http://www.eyolfson.com">Jon Eyolfson</a> and I are investigating the converse property: what are the properties of writes which never get read? We anticipate exploring related properties in future work.</li>
<li> Analysis and transformation of test cases: With Divam Jain, I am exploring the feasibility of static
and dynamic analysis approaches to help developers maintain test suites (in JUnit).</li>
</ul>

<h3>Past Research Accomplishments</h3>

<p>I've worked with collaborators to share language design and program
analysis techniques with the areas of security and embedded systems.
</p>

<ul>
<li> Role-based access control through proxy objects: with Mahesh Tripunitara and Jeff Zarnett. Developed an implementation of an RBAC system which used Java annotations and proxy objects to express the access control policy. Appeared in <a href="/papers/10.sacmat.rbac.pdf">SACMAT 2010</a>.
<li> Time-aware instrumentation for embedded systems: with Sebastian Fischmeister. Explored a technique for instrumenting embedded systems subject to a time bound, evaluating the reliability of the resulting instrumentation. Appeared in <a href="/papers/10.tii.instrumentation.pdf">Transactions on Industrial Informatics</a>.
<li> <a href="/research/tracematch/">Static analysis of tracematches</a>: with Eric Bodden and Laurie Hendren. Implemented a hybrid static/dynamic analysis for verifying that specified sequences of program events never occur in any execution. Appeared in <a href="/papers/12.toplas.tm.pdf">TOPLAS</a>.</li>
<li> <a href="/research/hob/">Hob</a>: As part of my <a href="/papers/plam-thesis.pdf">PhD thesis</a>, developed a set-based specification language and techniques for verifying that the implementation corresponds to the specification.</li>
<!-- <li> <a href="/research/tokens/">Tokens</a>: embedding design information into Java source code.</li>-->
<li> I was an early contributor to the
influential <a href="http://www.sable.mcgill.ca/soot">Soot</a> framework for static analysis of Java bytecode.
My main contribution these days is in the form of review articles, such as this <a href="/papers/11.cetus.soot.pdf">CETUS workshop</a> article.
</ul>

<p>You may also be interested in a <a href="/research/">more detailed research overview</a>.</p>

<h2>Current Students</h2>

<ul>
  <li>Qian Liang</li>
  <li>Ali Iman</li>
</ul>

<h2>Graduated Students</h2>

<ul>
<li><a href="https://eyolfson.ca">Jon Eyolfson</a></li>
<li>Jeff Zarnett (co-supervised with Mahesh Tripunitara)</li>
<li>Aakarsh Nair</li>
<li>Hang Chu</li>
<li>Gaurav Jain</li>
<li>Divam Jain (co-supervised with Reid Holmes)</li>
<li>Felix Fang</li>
<li>Wenzhu Man</li>
<li><a href="https://www.stephenli.ca">Stephen Li</a></li>
<li>Jun Zhao</li>
<li>Zeming Liu</li>
<li><a href="https://eyl.io">Jon Eyolfson</a></li>
</ul>

<h2>Publications</h2>

<!--
<ul>
  <li>Eric Bodden, Patrick Lam and Laurie Hendren. To appear in TOPLAS: Partially evaluating finite-state runtime monitors ahead of time [<a href="/papers/13.toplas.tm.bib">bib</a>]. Synthesizes our results from <a href="http://www.bodden.de/pubs/bodden10efficient.pdf">ICSE '10</a>, <a href="/papers/08.fse.rt-ahead.pdf">FSE '08</a> and <a href="http://www.bodden.de/pubs/bhl07astaged.pdf">ECOOP '07</a> and adds new formalisms.</li>
  <li>Jon Eyolfson, Lin Tan and Patrick Lam. MSR 2011: <a href="/papers/11.msr.time-of-day.pdf">Do Time of Day and Developer Experience Affect Commit Bugginess?</a> [<a href="/papers/11.msr.time-of-day.bib">bib</a>]. Journal version submitted to <i>Experimental Software Engineering</i>. </li>
  <li>Brian Demsky and Patrick Lam. To appear in TOSEM: <a href="/papers/11.tosem.views.pdf">Views: Synthesizing Fine-Grained Concurrency Control</a>. [<a href="http://demsky.eecs.uci.edu/views/">webpage</a>, <a href="/papers/12.tosem.views.bib">bib</a>]. Previously appeared at <a href="/papers/10.icse.views.pdf">ICSE 2010</a>. [<a href="/papers/10.icse.views.bib">bib</a>] </li>
</ul>-->

<p>Here is a <a href="publications/">full publications list</a>,
which includes posters and publications.</p>


<h2>Mailing Address and Phone</h2>
<dl>
<dt>Patrick Lam</dt>
<dd>Department of Electrical and Computer Engineering</dd>
<dd>University of Waterloo</dd>
<dd>200 University Avenue West</dd>
<dd>Waterloo, Ontario, Canada N2L 3G1</dd>
<dd>Office Phone: (519)888-4567 extension 38017</dd>
</dl>

<h2>Friends and Collaborators</h2>

<ul>
<li><a href="http://bodden.de">Eric Bodden</a> (<a href="http://www.sable.mcgill.ca/soap/">SOAP workshop</a>)</li>
<li><a href="http://www.ece.uwaterloo.ca/~sfischme">Sebastian Fischmeister</a></li>
<li><a href="http://www.colby.edu/personal/aghitza/">Alex Ghitza</a></li>
<li><a href="http://www.sable.mcgill.ca/~hendren">Laurie Hendren</a> (<a href="http://edgar.ecs.qc.ca/heroecs/">HeroECS robotics team</a>)</li>
<li><a href="http://lara.epfl.ch/~kuncak">Viktor Kuncak</a></li>
<li><a href="http://www.mit.edu/~kkz">Karen Zee</a></li>
<li><a href="http://www.christmastreemap.com">Dave Wentzlaff's Christmas Tree Maps</a> <a href="http://www.mightynumber.com">numbers search</a> <a href="http://bedandbreakfastexpert.com">bed and breakfast search</a></li>
</ul>

<h2>Random software</h2>

<p>I've developed a bunch of software, which can be found in various places on my research pages. However, on this page, I'm mirroring <i>Dust</i>,
which was developed by Raja Vall&eacute;e-Rai for the Quest for Java competition, and is in the public domain. It is not otherwise on the 
Internet, and I got it from the Wayback Machine.</p>

<ul>
<li><a href="files/DustV200.zip">Dust v2.0</a></li>
</ul>

<h2>Not me</h2>

<p>
Unfortunately, I'm <a href="http://www.fortunecity.com/lavender/tombstone/902/PLamphoto.htm">not the only person named Patrick Lam</a> (warning: I've heard that there's malware on that page; this <a href="files/otherPatrickLam1.jpg">JPG</a> or <a href="files/otherPatrickLam2.jpg">this other JPG</a> should be safe. Well, sort of.).
</p>
         
<?php include('bottom.php') ?>
