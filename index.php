<?php include('config.php'); ?>

<!DOCTYPE html>
<html>

  <?php include("head.php"); ?>

  <body>

    <?php include("navbar.php"); ?>

    <div class="little-container">
      <div class="table-responsive">
        <div class="col-md-6">
      
        <table id="dataTables-dept" class="table table-striped table-bordered" style="width:100%">
          <thead class="thead-bg">
            <tr align='center'>
              <th width="">Department</th>
              <th width="">Staff No.</th>
          </thead>
          <tbody>

            <?php
              $sql= "SELECT st_id, staffdept, count(staffdept) as totaldept from staff where staffstatus in ('P', 'C') group by staffdept";
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_assoc($result)) {
              ?>

              <tr>
                <td>
                  <span class='text'><?php echo $row['staffdept'];  ?></span>
                </td>

                <td>
                  <?php
                    $sql2="SELECT max(YEAR(date_from)) as year FROM `staffleave`";
                    $result2 = mysqli_query($conn, $sql2);
                      
                      while($row2 = mysqli_fetch_assoc($result2)) {
                        $year = $row2['year']; 
                  ?>
                  <span class='text'><a href="list_dept.php?staffdept=<?php echo $row['staffdept'] ?>&year=<?php echo $year ?>  "><?php echo $row['totaldept']; ?></a></span>
                  <?php } ?>
                </td>
              </tr>

              <?php } ?>

          </tbody>
        </table>
      </div>

            <div class="col-md-6">
        
        <table id="dataTables-job" class="table table-striped table-bordered" style="width:100%">
          <thead class="thead-bg">
            <tr align='center'>
              <th width="">Position</th>
              <th width="">Staff No.</th>
          </thead>
          <tbody>

            <?php
              $sql= "SELECT st_id, staffpos, count(staffpos) as totalpos from staff where staffstatus in ('P', 'C')  group by staffpos";

             

              $result = mysqli_query($conn, $sql);
              
              while($row = mysqli_fetch_assoc($result)) {

              ?>

              <tr>
                <td>
                  <span class='text'><?php echo $row['staffpos'];  ?></span>
                </td>

                <td>
                  <?php
                    $sql2="SELECT max(YEAR(date_from)) as year FROM `staffleave`";
                    $result2 = mysqli_query($conn, $sql2);
                      
                      while($row2 = mysqli_fetch_assoc($result2)) {
                        $year = $row2['year']; 
                  ?>
                  <span class='text'><a href="list_job.php?staffpos=<?php echo $row['staffpos'] ?>&year=<?php echo $year ?> "><?php echo $row['totalpos']; ?></a></span>
                <?php } ?>
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
