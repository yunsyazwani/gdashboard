<?php 

header('Content-Type: application/json');

include('config.php');

$staffid = $_GET['staffid'];
$getYear = $_GET['getYear'];
//query to get data from the table
$sql = sprintf("SELECT m.monthname, IFNULL(SUM(sl.leave_day), 0) AS sumleave
FROM monthleave m
LEFT JOIN (
    SELECT date_from, leave_day 
    FROM staffleave 
    WHERE staffid = '$staffid'
    AND YEAR(date_from) = '$getYear'
    ) sl
ON MONTHNAME(sl.date_from) = m.monthname
GROUP BY m.monthname
ORDER BY m.monthno");

$result = mysqli_query($conn, $sql);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$conn->close();

//now print the data
print json_encode($data);