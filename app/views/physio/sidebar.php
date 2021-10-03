<div class="row" style="padding:1px">
    <ul class="list-group text-dark" style="width:100%">
        <?php foreach ($data['dailylist'] as $data) : ?>
            <button type="button" class="btn btn-secondary dailylistbtn" data-toggle="modal" data-target="#editmodal" style="width:98%; margin-top:2px;">
            <div hidden>
                <p id='patient_id'><?php echo $data->id; ?></p>
                <p id='name'><?php echo $data->username; ?></p>
                <p id='mnumber'><?php echo $data->mnumber; ?></p>
                <p id='email'><?php echo $data->email; ?></p>
                <p id='address'><?php echo $data->address; ?></p>
                <p id='next'>cccccccccccccccc</p>
            </div>
                <div class="row" style="border:red">
                    <div class="col-md-2"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i></div>
                    <div class="col-md-10 px-1" >
                    <div class="pr-1 border-secondary rounded" style="text-overflow: ellipsis; text-align: right; background:#595959; padding-right:0px"><?php echo $data->username; ?>
                        <div style="text-align: right; line-height: 1.5; font-size:11px"><?php echo $data->time_slot; ?></div></div>
                    </div>
                </div>
            </button>
        <?php endforeach; ?>
    </ul>
</div>
<!-- PATIENT PROFILE CARD -->
<div class="modal fade profile" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="width:40%;">
            <div class="modal-content" style="background-color:powderblue;">
                <div class="container">
                    <div class="row z-depth-3" style="margin-top:0;">
                        <div class="col-md-5 bg-info rounded-left">
                            <div class="card-block text-center text-white"><br>
                                <div class="container" style="height:90px;">
                                    <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>
                                </div>
                                <div class="profile-info">
                                    <p class='name m-0'></p>
                                    <p class='mnumber m-0'></p>
                                    <p class='email m-0'></p>
                                    <p class='address m-0'></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 bg-white rounded-right m-0 p-0">
                            <h5 class="mt-3 text-dark"><i class="fa fa-hospital-o" aria-hidden="true"></i> LRH-Physiotheraphy Unit</h5>
                            <hr class="bg-primary">
                            <div class="row" style="width:100%; margin:0px">
                                <div class="col-md-6" style="text-overflow: ellipsis;">
                                    <center>
                                        <p class="font-weight-bold text-dark" style="font-size:15px; margin:0; text-overflow: ellipsis;">Physiotheraphist</p>
                                        <p class="text-dark"><?php echo $_SESSION['profile']['fname']." ".$_SESSION['profile']['lname'] ?></p>
                                        <!-- <input class="" type="text" name="lname" id="lname" style="width:100%; font-size:13px"> -->
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <p class="font-weight-bold text-dark" style="font-size:15px; margin:0">Next Appoinment</p>
                                        <input class="" type="text" name="lname" value="23 April 2020" style="width:100%; font-size:13px">
                                    </center>
                                </div>
                            </div>
                            <hr class="bg-primary">
                            <form method="POST">
                                <div class="row p-0 m-0" style='width:100%'>
                                    <input type="hidden" name="id" id="p_id">
                                    <div class="col-sm-3">
                                        <center>
                                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#addrecord"><i class="fa fa-list-alt fa-3x" style="color: #0E92EF;" aria-hidden="true"></i></button>
                                            <p class="font-weight-bold text-secondary"></p>
                                        </center>
                                    </div>
                                    <div class="col-sm-3 p-0">
                                        <center><a href="#!"><i class="fa fa-file-text-o fa-3x" style="color: #0E92EF;" aria-hidden="true"></i></a>
                                            <p class="font-weight-bold text-secondary" style="font-size-adjust: 0.58;">Form</p>
                                        </center>
                                    </div>
                                    <div class="col-sm-3 p-0">
                                        <center><a href="#!"><i class="fa fa-folder-open-o fa-3x" style="color: #0E92EF;" aria-hidden="true"></i></a>
                                            <p class="font-weight-bold text-secondary">Daily Reports</p>
                                        </center>
                                    </div>
                                    <div class="col-sm-3 p-0 m-0">
                                        <center>
                                            <button class="btn btn-link" type="submit" formaction="<?php echo URLROOT; ?>/physio/giveappoinment"><i class='fa fa-calendar-plus-o fa-3x' style="color: #0E92EF;" aria-hidden='true'></i></button>
                                            <p class="font-weight-bold text-secondary">Add/Change Appoinment</p>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- AddDailyRecord -->
<div class="modal fade" id="addrecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title re" id="exampleModalLongTitle">Add Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <form>
                        <div class="invalid-feedback d-block record"></div>
                        <textarea class="form-control" id='record' rows="17" placeholder="text . . ."></textarea>
                        </form>
                    </div>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary addrecord">Add</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('.dailylistbtn').on('click', function() {
            var p_id = $(this).find("#patient_id").text();
            var name = $(this).find("#name").text();
            var mnumber = $(this).find("#mnumber").text();
            var email = $(this).find("#email").text();
            var address = $(this).find("#address").text();
            var next = $(this).find("#next").text();
            var modal = $('#editmodal');
            modal.find('.name').text(name);
            modal.find('.mnumber').text('mobile number: ' + mnumber);
            modal.find('.email').text('email: ' + email);
            modal.find('.address').text('address: ' + address);
            modal.find('.next').text(next);
            // document.write(patient_id);
            $('#p_id').val(p_id);
            $('#editmodal').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.addrecord').click(function(e) {
            e.preventDefault();
            var record = $('#record').val();
            var patient_id = p_id.value;
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/physio/addrecord",
                dataType: 'json',
                data: {
                    "record": record,
                    "patient_id": patient_id,
                },
                cache:false,
                success: function(data) {
                    if (data == 1) {
                        location.reload();
                    } else if (data == '') {
                        modal.find('.error').text("Some Error Occured");
                    } else {
                        var record = data.record_err;
                        var modal = $('#addrecord');
                        modal.find('.record').text(record);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorFunction();
                }
            });
        });
    });
</script>