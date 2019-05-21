<?php include('config.php'); 

  $staffid = $_GET['staffid'];

  $sql = "SELECT staffname FROM staff WHERE staffid = '$staffid' ";
  $result = mysqli_query($conn, $sql);
            
  while($row = mysqli_fetch_assoc($result)) {
    $staffname = $row['staffname'];
  }

  if(isset($_GET['year']) && $_GET['year'] !== ""){
    $getYear = $_GET['year'];
  } else {
    $getYear = null;
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
      
          <table id="dataTables-dept" class="table table-bordered " style="width:100%;" >
            <thead class="thead-bg" style="background-color:#d2d7dc;">
             
              <th width="3%"></th> 
                <th width="">Month</th>  
                <th width="">Total Leave</th>
                <th width="">AL</th>
                <th width="">MC</th>
                <th width="">MCL</th>
                <th width="">HOS</th>
                <th width="">MAR</th>
                <th width="">MAT</th>
                <th width="">PAT</th>
                <th width="">UL</th>
                
            </thead>
            <tbody>
            <?php 
                $sql= "SELECT s.staffid, MONTHNAME(sl.date_from) AS monthname, MONTH(sl.date_from) AS month, SUM(sl.leave_day) AS sumleave
                FROM staff s
                LEFT JOIN staffleave sl
                ON s.staffid = sl.staffid  
                WHERE s.staffid= '$staffid'";

                if(isset($getYear)){
                  $sql = $sql." AND YEAR(date_from) = '$getYear'";
                }

                $sql = $sql." GROUP BY MONTH(sl.date_from)";

                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) { 
                  $monthname = $row['monthname']; 
                  $sumleave = $row['sumleave'];
                  $month = $row['month'];
                  ?>

                <tr style="background-color:#f9f1f1">
                  <td class="details-control" data-toggle="collapse" id="monthname_<?php echo $monthname ?>" data-month="month<?php echo $monthname ?>_"></td>
                  <td>
                    <span class='text'><?php echo $monthname ?></span>
                  </td>
                  <td>
                    <span class='text'><?php echo $row['sumleave'] ?></span>
                  </td>

                  <?php 

                $staffid = $row['staffid'];

                $nestsql = "SELECT sl.leave_id, SUM(leave_day) AS leaveday 
                FROM `staffleave` sl 
                WHERE staffid = '$staffid'
                AND MONTHNAME(sl.date_from) = '$monthname'";
                if(isset($getYear)){
                  $nestsql = $nestsql." AND YEAR(date_from) = '$getYear'";
                }
                
                $lastnestsql = $nestsql." GROUP BY staffid, leave_id";
                $nestedresult = mysqli_query($conn, $lastnestsql);

                $arr = [];
                while($nestedrow = mysqli_fetch_assoc($nestedresult)) {
                  $arr[] = $nestedrow['leave_id'];//semua row result simpan dalam 1 array bernama arrrr
                }

                // check dalam array arrr tu wujud tak jenis AL, kalau ada...
                if(in_array("AL", $arr)){
                  //ambik dari database dan echo jumlah AL sahaja
                  $newsql = $nestsql." AND leave_id = 'AL' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';//kalo tak wujud AL dalam arrr tu, kita echo td kosong, untuk column AL pada datatable
                }

                if(in_array("MC", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MC' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MCL", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MCL' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("HOS", $arr)){
                  $newsql = $nestsql." AND leave_id = 'HOS' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MAR", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MAR' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MAT", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MAT' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("PAT", $arr)){
                  $newsql = $nestsql." AND leave_id = 'PAT' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("UL", $arr)){
                  $newsql = $nestsql." AND leave_id = 'UL' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }
                

               ?>
                </tr>

                <?php 
                $sql2= "SELECT week(dt.date_from) AS diffweek, SUM(dt.leave_day) AS totalperweek
                      FROM(
                          SELECT week(date_from), date_from, leave_day 
                          FROM staffleave 
                          WHERE staffid='$staffid' 
                          AND MONTH(date_from) = '$month'
                          AND YEAR(date_from) = '$getYear'
                      ) dt
                      GROUP BY diffweek";

                $result2 = mysqli_query($conn, $sql2);
                $increment = 1;
                while($row2 = mysqli_fetch_assoc($result2)) { 
                  $diffweek = $row2['diffweek']; 
                  $totalperweek = $row2['totalperweek']; 

                  // if($diffweek == 0){
                  //   $diffweek = 1;
                  // }
                  // ?>                  
                  
                <tr  class="collapse in" id="month<?php echo $monthname."_".$increment ?>" >
                  <td></td>
                  <td>
                      <div >Week <?php echo $diffweek ?></div>
                  </td>
                  <td>
                      <div ><?php echo $totalperweek ?></div>
                  </td>


                    <?php 

                $staffid = $row['staffid'];

                $nestsql = "SELECT week(dt.date_from) AS diffweek, COUNT(dt.date_from) AS totalperweek,  SUM(dt.leave_day) as byleaveid, dt.leave_id
                FROM(
                    SELECT date_from, leave_id,leave_day
                    FROM staffleave 
                    WHERE staffid='$staffid' 
                    AND MONTH(date_from) = '$month'
                    AND YEAR(date_from) = '$getYear'
                ) dt";
                
                $nestedresult = mysqli_query($conn, $lastnestsql);

                $arr = [];
                while($nestedrow = mysqli_fetch_assoc($nestedresult)) {
                  $arr[] = $nestedrow['leave_id'];//semua row result simpan dalam 1 array bernama arrrr
                }

                // check dalam array arrr tu wujud tak jenis AL, kalau ada...
                if(in_array("AL", $arr)){
                  //ambik dari database dan echo jumlah AL sahaja
                  $newsql = $nestsql." WHERE leave_id = 'AL' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';

                } else {
                  echo '<td></td>';//kalo tak wujud AL dalam arrr tu, kita echo td kosong, untuk column AL pada datatable
                }

                if(in_array("MC", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'MC' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MCL", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'MCL' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("HOS", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'HOS' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MAR", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'MAR' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MAT", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'MAT' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';
                } else {
                  echo '<td></td>';
                }

                if(in_array("PAT", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'PAT' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';
                } else {
                  echo '<td></td>';
                }

                if(in_array("UL", $arr)){
                  $newsql = $nestsql." WHERE leave_id = 'UL' AND (week(dt.date_from)) = '$diffweek' GROUP BY diffweek, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  //echo '<td class="text-center"><span class="text">'.$count['leaveday'].'</span></td>';
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'&monthname='.$row['monthname'].'&week='.$count['diffweek'].'"><span class="text">'.$count['byleaveid'].'</span></a></td>';
                } else {
                  echo '<td></td>';
                }
                

               ?>           
              </tr>

                <?php $increment++; } 

                }?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-md-8 col-md-offset-2" style="padding: 25px 0px;"> 
        <p class="text-center">Graph of Leave Taken Per Month</p>           
      
        <input type="hidden" value="<?php echo $getYear; ?>" name="getyear" id="getYear">
        <input type="hidden" value="<?php echo $staffid; ?>" name="staffid" id="staffid">
        <input type="hidden" value="<?php echo $month; ?>" name="month" id="month">
        <canvas id="mycanvas"></canvas>
      </div>
      
    </div><!--little container-->
  </body>
<?php include("footer.php"); ?>

<script type="text/javascript">
  $('#yearSelect').change(function(){
    window.location.replace('list_leave.php?staffid=<?php echo $staffid; ?>&year='+$(this).val());

  })
</script>
<script>
  $(function() {
    $('[id^="monthname_"]').click(function() {
      var id = $(this).data("month");
      $('[id^='+id+']').toggleClass("in");
    });
  });
  
  </script>
</html>
