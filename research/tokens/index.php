<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
 <link rel="stylesheet" href="/ui/style.css" type="text/css" />
 <title>Token Annotation System</title>
</head>

<body>

<!-- thanks Drew McLellan, support transparent PNG for email -->
<!--[if lte IE 6]>
	<script type="text/javascript" src="/ui/supersleight-min.js"></script>
<![endif]-->

<?php include('../../top.php') ?>
<?php include('../../menu.php') ?>

<div id="main">

<h1>Tokens: Embedding Design Information in Java source</h2>

<p>The <a
 href="/papers/ecoop03.tokens.ps">token annotation</a> system
 allows developers to embed design information directly into a
 program's source code, so that it can be automatically extracted from
 the source code.  The key conceptual problem is that the code and
 design of a system operate at different levels of abstraction: the
 code specifies one particular solution to a problem in great detail,
 and is tuned for efficiency, while the design constrains the space of
 possible solutions, and is tuned for human understanding. </p>

<img style="margin-left:auto; margin-right:auto; display:block; text-align:center" src="ProdCons.ii.png" alt="Indirect Interaction Diagram: Producer-Consumer Example">

<p>Consider the above indirect interaction diagram from a Producer-Consumer
system. Circles represent subsystems while lines represent communication
between the subsystems. We can see that the <code>PCI</code> subsystem 
communicates with the <code>PCS</code> subsystem by using objects labelled
with <code>EP</code> and <code>EC</code> tokens. Our software automatically
generates these diagrams from annotated Java source code.</p>

<?php include('../../bottom.php') ?>

</body>
</html>
