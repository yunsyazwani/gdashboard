<?php

include('config.php');

	if(isset($_POST['submiteva'])){

		$staffid=$_POST['staffid'];
		$evamark=$_POST['evamark'];
		$evaremarks = $_POST['evaremarks'];
		

		$sql="INSERT INTO evaluation 
			(staffid, evamark, evaremarks,evadate)
			VALUES
			('$staffid', '$evamark', '$evaremarks', NOW()) ";
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn)); 

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	} 
?>

