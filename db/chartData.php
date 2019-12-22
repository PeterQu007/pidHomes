<?php

if (isset($_GET["Neighborhood_ID"]))
{
  $Neighborhood_ID = $_GET["Neighborhood_ID"];
  // echo $title;
  // echo " is your tab title";
  //print_r($Neighborhood_ID);
}
else
{
  $Neighborhood_ID = 'F51';
  //echo "<p>no Neighborhood_ID supplied</p>";
}


$mysqli = new mysqli("localhost", "root", "root", "local");
// include "dbConn.php";

$return_arr = array();

$strSql = "SELECT `Date`, HPI FROM pid_market WHERE Neighborhood_ID='" . $Neighborhood_ID . "' AND Date >= '2017-01-01'";
$mysqli->real_query($strSql);
$res = $mysqli->use_result();

while ($row = $res->fetch_assoc()) {
  $xdate = $row['Date'];
  //echo $xdate;
  $xvalue = $row['HPI'];
  //echo $xvalue;
  $return_arr[]=array(
    'x' => $xdate,
    'y' => (int)$xvalue
  );
}

//var_dump($return_arr);
//print_r($return_arr);
echo json_encode($return_arr);
