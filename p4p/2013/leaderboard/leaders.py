from urlgrabber import urlopen
import csv

def index(req):
    rv = """<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECE 459: Programming for Performance</title>
<script type="text/javascript" src="/ui/alternate_rows.js"></script>
<link rel="stylesheet" type="text/css" href="alternating-rows.css" />
<style type="text/css">
  td {vertical-align:top}
</style>
<style type="text/css" media="screen">
@import url("http://www.uwaterloo.ca/css/UWblank.css");
</style>
<!-- TemplateBeginIf cond="collage" -->
<!-- <style type="text/css" media="screen">
@import url("http://www.uwaterloo.ca/css/UWhome.css");
</style>-->
<!-- TemplateEndIf --><!-- TemplateBeginIf cond="rightnavmenu==false" -->
<style type="text/css" media="screen">
@import url("http://www.uwaterloo.ca/css/UW2col.css");
</style>
<!-- TemplateEndIf --><!-- TemplateBeginIf cond="rightnavmenu" -->
<!-- <style type="text/css" media="screen">
@import url("http://www.uwaterloo.ca/css/UW3col.css");
</style> -->
<!-- TemplateEndIf -->
<!-- conditional comment added for IE 6 printing, IE 5.5 will not print this page very well -->
<!--[if IE 6]>
<style type="text/css" media="print">
@import url("http://www.uwaterloo.ca/css/UWprint.css");
</style>
<![endif]-->
<!-- this print will work in W3 Standard compliant browsers -->
<style type="text/css">
@import url("http://www.uwaterloo.ca/css/UWprint.css") print;

</style>
<style type="text/css" media="screen">
@import url("/css/ece.css");
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Language" content="en-us" />
<!-- fill in below according to your site -->
<meta name="description" content="Programming for Performance" />
<meta name="keywords" content="programming parallelization" />
<meta name="author" content="Patrick Lam" />
<meta name="author" content="Design - Jesse Rodgers (jrodgers@admmail.uwaterloo.ca)" />
<meta name="version" content="XHTML Version 1.0p1"  />
<!-- optional regions -->
<!-- TemplateParam name="submenu" type="text" value="0" -->
<!-- TemplateParam name="collage" type="boolean" value="false" -->
<!-- TemplateParam name="rightnavmenu" type="boolean" value="false" -->

</head>
<body>
<!-- header -->
<div id="header">
	<div id="clfbar">
		<div id="uwlogo">
			<a href="http://www.uwaterloo.ca">
            <img src="http://www.uwaterloo.ca/images/template/uwlogo.gif" alt="Link to the University of Waterloo home page" width="105" height="70" border="0" /> </a>
		</div>
		<div id="searchbox">

		<!-- form script is located on info, there are options though. Information is at http://web.uwaterloo.ca/clftemplate/search.html -->
         	<form action="http://info.uwaterloo.ca/clfscripts/uwsearch.php" method="post" name="search" target="_blank" id="search" title="search" dir="ltr" lang="en">
    			Search 
				<input type="radio" name="site" value="ece.uwaterloo.ca" checked="checked"/>
				in ECE
				<input type="radio" name="site" value="uwaterloo.ca"/>
    			all of UW
    			<input name="searchterm" type="text" id="searchterm" class="google" accesskey="s" tabindex="2" size="20" />  
				<input name="submit" type="submit" id="submit" class="google" tabindex="3" value="Search" />
  			</form>
        </div>

		<div id="wordmark"> 
		<h1><a href="index.html">
		<!-- replace title image with your own DO NOT FORGET ALT TAG!!! -->
		<img src="/files/clear.gif" alt="Department of Electrical and Computer Engineering" width="400" height="30" border="0" />
		</a></h1>
	  </div>
	</div>
</div>
<span class="none"><a href="#content">Skip to the content of the web site.</a></span>

<!-- primary nav, add or delete links as you desire --> 
<div id="primarynavarea"> 
  <ul id="primarynav"> 
  <li><a href="/p4p/"><b>Home</b></a></li>
  <li><a href="/p4p/leaderboard/leaders.py">A3 Leaderboard</a></li>
  <li><a href="/p4p/notes/">Lecture notes</a></li>
  <li><a href="/p4p/exams.shtml">Exam information</a></li>
  <li><a href="/p4p/files/assignment-01.pdf">Assignment 1 (PDF)</a></li>
  <li><a href="/p4p/files/assignment-02.pdf">Assignment 2 (PDF)</a></li>
  <li><a href="/p4p/files/assignment-03.pdf">Assignment 3 (PDF)</a></li>
  <li><a href="/p4p/files/assignment-04.pdf">Assignment 4 (PDF)</a></li>
<!--
  <li><a href="/p4p/a4notes.shtml">Assignment 4 notes</a></li>-->
<!-- TemplateEndIf --> 	  
  </ul>
</div>

<!-- content -->
<a name="content" id="content"></a>
<!-- TemplateBeginIf cond="collage == false" -->
<div id="contentbar"> <!-- this causes the warning about p tags on saving the template, just ignore -->
<!-- TemplateBeginEditable name="collage == false" -->
<h2> ECE459: Programming for Performance, W13 </h2> 
<!-- TemplateEndEditable -->
</div>
<!-- TemplateEndIf -->
													<!-- DO NOT FORGET ALT TAG!!!! -->
<!-- TemplateBeginIf cond="collage" -->

<!-- <div id="collage"> <img src="images/Collage3.jpg" alt=" " /> </div> -->
<!-- TemplateEndIf -->

<div id="primarycontarea">
  <div id="primarycontent">
    <!-- InstanceBeginEditable name="primarycontent" -->
    <table>
"""
    lb = urlopen("http://ece459-1.uwaterloo.ca/leaders.csv")
    reader = csv.reader(lb)
    parity = 0
    for row in reader:
        parity = 1-parity
        s = ""
        if (parity == 1):
            s = s + "background:#ddd"
        rv = rv + "<tr style='"+s+"'><td style='padding-right:1em'>"+row[0]+"</td><td style='text-align:right'>"+row[1]+"</td></tr>"

    lb.close()
    rv = rv + """</table>
</div>
</div>
<!-- footer -->
<div id="footer">	
	<div id="departmentaddress">
	 <a href="http://campaign.uwaterloo.ca"><img src="http://www.uwaterloo.ca/images/template/littlecampaignlogo.gif" alt="Campaign Waterloo" class="campaignlogo" /></a>
	 <p>

	    Patrick Lam <br />
Department of Electrical and Computer Engineering<br />
University of Waterloo<br />
200 University Avenue West<br />
Waterloo, Ontario, Canada N2L 3G1<br />
519 888 4567 ext. 36433 <br />
<br />
<a href="mailto:p.lam[at]ece.uwaterloo.ca">contact us</a> | <a href="mailto:p.lam[at]ece.uwaterloo.ca">give us feedback</a> | <a href="http://www.uwaterloo.ca">University of Waterloo Home Page </a><br />

	  </p>
  </div>
</div>
</body>

<!-- InstanceEnd --></html>
"""
    return rv

