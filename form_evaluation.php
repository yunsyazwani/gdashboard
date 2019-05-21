<?php
  $sql= "SELECT staffid, staffname, staff_jdate, staffpos, staffdept, staffstatus
  FROM staff";

  if(isset($_GET['staffdept'])){
    $sql = $sql."  WHERE staffdept= '$staffdept' AND staffstatus in ('P', 'C')";
  }

  if(isset($_GET['staffpos'])){
    $sql = $sql."  WHERE staffpos= '$staffpos' AND staffstatus in ('P', 'C')";
  }

  $result = mysqli_query($conn, $sql);
                      
  while($row = mysqli_fetch_assoc($result)) {
?>

<!-- Modal -->
<form action="add_evaluation.php" method="POST" enctype="multipart/form-data">
  <div class="modal fade" id="modalFormEva-<?php echo $row['staffid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Evaluation Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div class="modal-body">

          <div class="col-md-4">
            <div class="form-group">
              <label>Marks</label>
              <div class="input-group">
                <span class="input-group-btn">
              <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="evamark">
                  <span class="glyphicon glyphicon-minus"></span>
                </button>
                </span>
                <input type="text" name="evamark" class="form-control input-number" value="5" min="1" max="10" style="height: 34px;">
                <span class="input-group-btn">
              <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="evamark">
                  <span class="glyphicon glyphicon-plus"></span>
                </button>
                </span>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>Remarks</label>
              <textarea rows="4" cols="50" class="form-control" id="" name="evaremarks" style="width: 100%;"> </textarea>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <input type="text" name="staffid" value="<?php echo  $row['staffid']; ?>" hidden>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input name="submiteva" type="submit" class="btn btn-primary" value="Save changes">
        </div>
      </div>
    </div>
  </div>
</form>
<!--modal-->
<?php } ?>