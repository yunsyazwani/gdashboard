<?php include('config.php'); 
$staffid = $_GET['staffid'];

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

      <div class="col-md-4">
        <div class=" pull-right">
          <div class="form-group">
            <label for="sel1">Year:</label>
            <select class="form-control" id="yearSelect">
              
              <?php
              $sql = "SELECT YEAR(date_from) as year FROM `staffleave` GROUP BY YEAR(date_from) ORDER BY YEAR(date_from) DESC";
              $result = mysqli_query($conn, $sql);
                        
              while($row = mysqli_fetch_assoc($result)) {
                $year = $row['year'];

              ?>
              <option value='<?php echo $year; ?>' <?php echo (isset($getYear) && $getYear == $year)? 'selected': '' ; ?> ><?php echo $year; ?></option>
            <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <div class="col-md-12">
      
        <table id="dataTables-dept" class="table table-bordered" style="width:100%">
          <thead class="thead-bg" style="background-color:#d2d7dc;">
              <th></th>
              <th width="">Month</th>   
              <th width="">Marks</th>
              <th width="">Remarks</th>
              <th width="">Date Evaluate</th>
          </thead>
          <tbody>

            <?php
               
                 $sql= "SELECT MONTHNAME(eva.evadate) as monthname, ROUND(AVG(eva.evamark),1) AS markmonth FROM 
                 (SELECT evadate, evamark from evaluation WHERE staffid = '$staffid') eva";

                if(isset($_GET['year'])){
                $getYear = $_GET['year'];
                $sql = $sql." WHERE YEAR(evadate) = '$getYear'";
                }
            
                 $sql = $sql."GROUP BY MONTHNAME(evadate) ORDER BY MONTH(evadate) ASC";
                $result = mysqli_query($conn, $sql);
               
                
                while($row = mysqli_fetch_assoc($result)) {
                    $monthname = $row['monthname'];
                ?>

              <tr  style="background-color:#f9f1f1">
              <td class="details-control" data-toggle="collapse" id="monthname_<?php echo $monthname ?>" data-month="month<?php echo $monthname ?>_"></td>
                 
                <td>
                  <span class='text'><?php echo $row['monthname'];  ?></span>
                </td>         
                <td>
                  <span class='text'><?php echo $row['markmonth'];  ?></span>
                </td>
                <td>
                  <span class='text'></span>
                </td>
                <td>
                  <span class='text'></span>
                </td>
              </tr>     

              <?php 
               $sql2= "SELECT WEEK(evadate) AS week, evamark, evadate, evaremarks FROM evaluation WHERE staffid = '$staffid' AND YEAR(evadate) = '$getYear' AND MONTHNAME(evadate) = '$monthname' ORDER BY WEEK(evadate) ASC";

               $result2 = mysqli_query($conn, $sql2);
               $increment = 1;
               while($row2 = mysqli_fetch_assoc($result2)) {           
              
               ?>
              <tr  class="collapse in" id="month<?php echo $monthname."_".$increment ?>" >
                  <td></td>
                  <td>
                  <span class='text'>Week <?php echo $row2['week'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row2['evamark'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row2['evaremarks'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row2['evadate'];  ?></span>
                </td>
                </tr>

              <?php $increment++; }
              } ?>

          </tbody>
        </table>
      </div>

    </div>
    </div><!--little container-->
  </body>
<?php include("footer.php"); ?>
<script>
  $(function() {
    $('[id^="monthname_"]').click(function() {
      var id = $(this).data("month");
      $('[id^='+id+']').toggleClass("in");
    });
  });
  
  </script>
</html>
