<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
 <link rel="stylesheet" href="/ui/style.css" type="text/css">
 <title>Patrick Lam: Software</title>
</head>

<body>

<?php
 include('../top.php');
 include('../menu.php');
?>

<div id="main">
<h2>Hacking</h2> 

<p>I enjoy contributing to free software projects. Unfortunately,
I somehow haven't had time to contribute anything recently. However,
here are some of the projects that I've contributed to in the past.</p>

<ul>
<li><a href="http://www.sable.mcgill.ca/soot">Soot</a>, a compiler framework
for Java bytecode. I implemented the Grimp intermediate representation, which
contains aggregated expressions (rather than the simple three-address code
of Jimple). I also did general Soot hacking.</li>
<li><a href="http://abiword.org">AbiWord</a>, a free word processor. I contributed a number
of bug fixes and the initial version of endnotes to AbiWord.</li>
<li><a href="http://fontconfig.org">fontconfig</a>, a font selection
and configuration library for the X Window System. I
implemented <code>mmap</code>-able caching for font information.</li>
<li>I developed a (GPL) <a
href="software/monaviewer-1.0.tar.gz">formula viewer</a> for <a
href="http://www.brics.dk/mona">MONA</a> input files.  It uses SableCC
3.0's ability to display ASTs using Swing.</li>
<li>I've written an <a
href="http://www.ocaml.org">o'caml</a> backend for <a
href="http://www.sablecc.org">SableCC 3</a>, available in <a
href="ocaml-sablecc3-diffs">diff form</a> from Indrek Mandre's svn tree,
at
<code>svn://svn.sablecc.org/developers/indrek/sandbox/sablecc-indrek/</code>.</li>
</ul>


<?php include('../bottom.php') ?>
