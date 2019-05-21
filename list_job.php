<?php include('config.php'); 

  $staffpos = $_GET['staffpos'];

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
        <p>Position: <span><?php echo $staffpos;  ?></span></p>
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
      
          <table id="dataTables-dept" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-bg">
              <tr align='center'>
                <th width="">Staff ID</th>
                <th width="">Staff Name</th>
                <th width="">Join Date</th>                
                <th width=""><span title="C = Confirmed, P = Probation">Status</span></th>
                <th width="">Department</th>
                <th width=""><span title="Anual Leave">AL</span></th>
                <th width=""><span title="Medical Leave">MC</span></th>
                <th width=""><span title="Medical Child Leave">MCL</span></th>
                <th width=""><span title="Hospitalization Leave">HOS</span></th>
                <th width=""><span title="Marriage leave">MAR</span></th>
                <th width=""><span title="Maternity Leave">MAT</span></th>
                <th width=""><span title="Paternity Leave">PAT</span></th>
                <th width=""><span title="Unpaid Leave">UL</span></th>
                <th width="">Total Leave Taken</th>
                <th width="">Total Evaluation Mark</th>
                <th width=""></th>
                
            </thead>
            <tbody>
            <?php 
            $sql= "SELECT staffid, staffname, staff_jdate, staffdept, staffstatus
            FROM staff  
            WHERE staffpos= '$staffpos'
            AND staffstatus in ('P', 'C')";

            $sql = $sql." GROUP BY staffid";

            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) { ?>

              <tr>
                <td>
                  <span class='text'><?php echo $row['staffid'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['staffname'];  ?></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['staff_jdate'];  ?></span>
                </td>
                <td class="text-center">
                  <span class='text'><?php echo $row['staffstatus'];  ?></span>
                </td>
                <td>
                  <span class='text'><a href="list_job.php?staffdept=<?php echo $row['staffdept'] ?>&year=<?php echo $getYear ?>  "><?php echo $row['staffdept'];  ?></a></span>
                </td>
                

                <?php  

                $staffid = $row['staffid'];

                $nestsql = "SELECT sl.leave_id, SUM(leave_day) AS leaveday 
                FROM `staffleave` sl 
                WHERE staffid = '$staffid'";
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
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';//kalo tak wujud AL dalam arrr tu, kita echo td kosong, untuk column AL pada datatable
                }

                if(in_array("MC", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MC' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MCL", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MCL' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("HOS", $arr)){
                  $newsql = $nestsql." AND leave_id = 'HOS' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MAR", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MAR' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("MAT", $arr)){
                  $newsql = $nestsql." AND leave_id = 'MAT' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("PAT", $arr)){
                  $newsql = $nestsql." AND leave_id = 'PAT' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

                if(in_array("UL", $arr)){
                  $newsql = $nestsql." AND leave_id = 'UL' GROUP BY staffid, leave_id";
                  $newresult = mysqli_query($conn, $newsql);
                  $count = mysqli_fetch_assoc($newresult);
                  echo '<td class="text-center"><a href="type_leave.php?id='.$row['staffid'].'&type='.$count['leave_id'].'&year='.$getYear.'"><span class="text">'.$count['leaveday'].'</span></a></td>';

                } else {
                  echo '<td></td>';
                }

               ?>
                <td class="text-center">
                  <span class='text'>
                    <?php if(isset($getYear)){
                        $sql2= "SELECT sum(sl.leave_day) AS dayleave 
                        FROM staffleave sl 
                        LEFT JOIN staff s ON s.staffid = sl.staffid 
                        WHERE s.staffid= '$staffid'
                        AND YEAR(date_from) = '$getYear'";
                        $result2 = mysqli_query($conn, $sql2);

                        while($row2 = mysqli_fetch_assoc($result2)) { ?>
                          <a href="list_leave.php?staffid=<?php echo $row['staffid'] ?>&year=<?php echo $getYear ?> " >
                            <?php echo $row2['dayleave']; ?>
                          </a> 
                      <?php } 
                    }?>
                  </span>
                </td>

                <td class='text-center'>
                  <span class='text'><a>
                  <?php if(isset($getYear)){
                        $sql2= "SELECT ROUND(AVG(evamark),1) AS summark 
                        FROM evaluation 
                        WHERE staffid= '$staffid'
                        AND YEAR(evadate) = '$getYear'";
                        $result2 = mysqli_query($conn, $sql2);

                        while($row2 = mysqli_fetch_assoc($result2)) { ?>
                          <a href="list_evaluation.php?staffid=<?php echo $row['staffid'] ?>&year=<?php echo $getYear ?> " >
                            <?php echo $row2['summark']; ?>
                          </a> 
                      <?php } 
                    }?>
                  </a></span>
                </td>
                <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormEva-<?php echo $row['staffid']; ?>" style= "padding: 2px 7px;">
                <i class="fas fa-plus"></i>
                    </button>
                </td>
                
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php include("form_evaluation.php"); ?>
    </div><!--little container-->
   
  </body>
<?php include("footer.php"); ?>

<script type="text/javascript">
  $('#yearSelect').change(function(){
    window.location.replace('list_post.php?staffpos=<?php echo $staffpos; ?>&year='+$(this).val());

  })
</script>
</html>
