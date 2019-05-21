<?php include('config.php'); 
$staffid = $_GET['id'];

$sql = "SELECT staffname FROM staff WHERE staffid = '$staffid' ";
$result = mysqli_query($conn, $sql);
          
while($row = mysqli_fetch_assoc($result)) {
  $staffname = $row['staffname'];
}
?>

<!DOCTYPE html>
<html>

  <?php include("head.php"); ?>

  <body>

    <?php include("navbar.php"); ?>

    <div class="little-container">
      <div class="col-md-8">
      <p>STAFF NAME: <span><?php echo $staffname;  ?></span></p>
      </div>
      <div class="table-responsive">
        <div class="col-md-12">
      
        <table id="dataTables-dept" class="table table-striped table-bordered" style="width:100%">
          <thead class="thead-bg">
            <tr align='center'>
              <th width="">Date From</th>
              <th width="">Date To</th>
              <th width="">Leave Day</th>
              <th width="">Leave No</th>
              <th width="">Remark</th>
          </thead>
          <tbody>

            <?php
               
                $leaveId = $_GET['type'];

                $sql= "SELECT date_from, date_to, leave_id, leave_day, leave_no, remark FROM `staffleave` WHERE `staffid` = '$staffid' AND leave_id = '$leaveId'";

                if(isset($_GET['year'])){
                $year = $_GET['year'];
                $sql = $sql." AND YEAR(date_from) = '$year'";
              }

              if(isset($_GET['monthname'])){
                $monthname = $_GET['monthname'];
                $sql = $sql." AND MONTHNAME(date_from) = '$monthname'";
              }

              if(isset($_GET['week'])){
                $diffweek = $_GET['week'];
                $sql = $sql." AND  (week(date_from))  = '$diffweek'";
              }
              
                $result = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_assoc($result)) {

                ?>

              <tr>
                <td>
                  <span class='text'><?php echo $row['date_from'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['date_to'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['leave_day'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['leave_no'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['remark'];  ?></span>
                </td>
              </tr>

              <?php } ?>

          </tbody>
        </table>
      </div>

    </div>
    </div><!--little container-->
  </body>
<?php include("footer.php"); ?>
</html>
