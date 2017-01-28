<!DOCTYPE html>
<html>

<head>
 <meta http-equiv="content-type" content="text/html;charset=utf-8">
 <meta name="verify-v1" content="uWOD3hwnkhqEtxfofLKoWL1CnqK8DE4T7+kDt10MhEw=">
 <link rel="stylesheet" href="/ui/style.css" type="text/css">
 <title>Patrick Lam: STQAM A1Q1 auto-marking</title>
</head>

<body>

  <?php
     if (!isset($_POST["submit"])) {
  ?>
  <form method="post" enctype="multipart/form-data">
    Select your FormattedCommandAliasTest.java file:
    <input type="file" name="fcat" id="fcat">
    <input type="submit" value="Upload" name="submit">
  </form>
  <?php
     } else {
     $pmd = '/home/plam/jail/pmd-bin-5.5.2';
       exec("$pmd/bin/run.sh pmd -f text -R $pmd/a1q1-automarker.xml -d " . $_FILES["fcat"]["tmp_name"], $output, $rv);
       echo 'Output: <pre>';
       foreach($output as $line) {
         echo $line . "\n";
       }
       echo '</pre>';
       echo "<p>Return code (0 is good): $rv</p>";
     }
  ?>

</body>
</html>
