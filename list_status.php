<?php include('config.php'); ?>

<!DOCTYPE html>
<html>

  <?php include("head.php"); ?>

  <body>

    <?php include("navbar.php"); ?>

    <div class="little-container">
      <div class="table-responsive">
        <div class="col-md-12">
      
        <table id="dataTables-dept" class="table table-striped table-bordered" style="width:100%">
          <thead class="thead-bg">
            <tr align='center'>
              <th width="">Staff ID</th>
              <th width="">Staff Name</th>
              <th width="">Join Date</th>
              <th width="">Department</th>
              <th width="">Position</th>
              <th width="">Status</th>
          </thead>
          <tbody>

            <?php
                      $staffstatus = $_GET['staffstatus'];
                      $sql= "SELECT * from staff where staffstatus= '$staffstatus'";

                      $result = mysqli_query($conn, $sql);
                      
                      while($row = mysqli_fetch_assoc($result)) {

                      ?>
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
                <td>
                  <span class='text'><?php echo $row['staffdept'];  ?></span>
                </td>
                <td>
                  <span class='text'><a href="list_job.php?staffpos=<?php echo $row['staffpos'] ?> "><?php echo $row['staffpos'];  ?></a></span>
                </td>
                <td>
                  <span class='text'><?php echo $row['staffstatus'];  ?></span>
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
