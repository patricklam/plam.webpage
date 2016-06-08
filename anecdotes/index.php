<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
 <link rel="stylesheet" href="/ui/style.css" type="text/css">
 <title>Patrick Lam</title>
</head>

<body>

<?php
 // from http://www.phpbuilder.com/columns/sanitize_inc_php.txt
 // by: Gavin Zuchlinski, Jamie Pratt, Hokkaido
 // paranoid sanitization -- only let the alphanumeric set through
 function sanitize_paranoid_string($string, $min='', $max='')
 {
   $string = preg_replace("/[^a-zA-Z0-9\-]/", "", $string);
   $len = strlen($string);
   if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
     return FALSE;
   return $string;
 }

 include('../top.php');
 include('../menu.php');
?>

<div id="main">
<?php
// TODO create a cache of the html files.
  if (isset($_GET["list"])) {
      $files = glob('*.html');
      echo "<ul>\n";
      foreach ($files as $fn) {
        $ff = explode('.', $fn); $f = $ff[0];
        echo "<li><a href='/anecdotes/?fetch=$f'>$f</a></li>\n";
      }
      echo "</ul>\n";
  }
  else {
    $arg = sanitize_paranoid_string($_GET["fetch"]);
    if ($arg == '') {
      echo '<h1>Random Anecdote</h1>';
      $files = glob('*.html');
      $rf = array_rand($files);
      $fname = $files[$rf];
      $arg = substr($fname, 0, strrpos($fname, '.'));
    }
    include ($arg.'.html');
    echo '<p><a href="/anecdotes/?fetch='.$arg.'">Link to this page</a>.</p>';
  }
?>

<?php include('../bottom.php'); ?>
