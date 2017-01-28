<!DOCTYPE html>
<html lang="en">

<head>
 <meta http-equiv="content-type" content="text/html;charset=utf-8">
 <meta name="verify-v1" content="uWOD3hwnkhqEtxfofLKoWL1CnqK8DE4T7+kDt10MhEw=">
 <link rel="stylesheet" href="/ui/style.css" type="text/css">
 <title>Patrick Lam: STQAM A1Q1 auto-marking</title>
 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

 <!-- Optional theme -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

 <!-- Latest compiled and minified JavaScript -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>

  <div class="container-fluid">
  <?php
     if (!isset($_POST["submit"])) {
     ?>
  <h1> A1Q1 automarker submission </h1>
  <form method="post" enctype="multipart/form-data">
    Select your FormattedCommandAliasTest.java file:
    <input type="file" name="fcat" id="fcat">
    <button type="submit" value="Upload" name="submit" class="btn btn-default">Submit</button>
  </form>
  <?php
     } else {
     ?>   <h1> A1Q1 automarker results </h1> <?php
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
  </div>

</body>
</html>
