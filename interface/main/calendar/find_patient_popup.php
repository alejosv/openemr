<?
 // Copyright (C) 2005 Rod Roark <rod@sunsetsystems.com>
 //
 // This program is free software; you can redistribute it and/or
 // modify it under the terms of the GNU General Public License
 // as published by the Free Software Foundation; either version 2
 // of the License, or (at your option) any later version.

 include_once("../../globals.php");
 include_once("$srcdir/patient.inc");

 $info_msg = "";

 // If we are searching, search.
 //
 if ($_REQUEST['searchby'] && $_REQUEST['searchparm']) {
  $searchby = $_REQUEST['searchby'];
  $searchparm = $_REQUEST['searchparm'];

  if ($searchby == "Last") {
   $result = getPatientLnames("$searchparm","*");
  } elseif ($searchby == "ID") {
   $result = getPatientId("$searchparm","*");
  } elseif ($searchby == "DOB") {
   $result = getPatientDOB("$searchparm","*");
  } elseif ($searchby == "SSN") {
   $result = getPatientSSN("$searchparm","*");
  }
 }
?>
<html>
<head>
<title>Patient Finder</title>
<link rel=stylesheet href='<? echo $css_header ?>' type='text/css'>

<style>
td { font-size:10pt; }
</style>

<script language="JavaScript">

 function selpid(pid, lname, fname) {
  if (opener.closed || ! opener.setpatient)
   alert('The destination form was closed; I cannot act on your selection.');
  else
   opener.setpatient(pid, lname, fname);
  window.close();
  return false;
 }

</script>

</head>

<body <?echo $top_bg_line;?>>
<?
?>
<form method='post' name='theform' action='find_patient_popup.php?'>
<center>

<table border='0' cellpadding='5' cellspacing='0'>

 <tr>
  <td height="1">
  </td>
 </tr>

 <tr bgcolor='#ddddff'>
  <td>
   <b>
   Search by:
   <select name='searchby'>
    <option value="Last">Name</option>
    <option value="ID"<? if ($searchby == 'ID') echo ' selected' ?>>ID</option>
    <option value="SSN"<? if ($searchby == 'SSN') echo ' selected' ?>>SSN</option>
    <option value="DOB"<? if ($searchby == 'DOB') echo ' selected' ?>>DOB</option>
   </select>
   for:
   <input type='text' name='searchparm' size='12' value='<? echo $_REQUEST['searchparm']; ?>'
    title='If name, any part of lastname or lastname,firstname'>
   &nbsp;
   <input type='submit' value='Search'>
   <!-- &nbsp; <input type='button' value='Close' onclick='window.close()' /> -->
   </b>
  </td>
 </tr>

 <tr>
  <td height="1">
  </td>
 </tr>

</table>

<? if (isset($result)) { ?>

<table border='0'>
 <tr>
  <td><b>Name</b></td>
  <td><b>SS</b></td>
  <td><b>DOB</b></td>
  <td><b>ID</b></td>
 </tr>
<?
  foreach ($result as $iter) {
   $iterpid   = $iter['pid'];
   $iterlname = addslashes($iter['lname']);
   $iterfname = addslashes($iter['fname']);
   $anchor = "<a href='' " .
    "onclick='return selpid($iterpid, \"$iterlname\", \"$iterfname\")'>";
   echo " <tr>";
   echo "  <td>$anchor$iterlname, $iterfname</a></td>\n";
   echo "  <td>$anchor" . $iter['ss'] . "</a></td>\n";
   echo "  <td>$anchor" . $iter['DOB'] . "</a></td>\n";
   echo "  <td>$anchor" . $iter['pubpid'] . "</a></td>\n";
   echo " </tr>";
  }
?>
</table>

<? } ?>

</center>
</form>
</body>
</html>
