<?php require APPROOT . '/views/inc/header1.php'; ?>
<div class="col-md-8 col-sm-10" style="padding:0px">
  <div class="card card-body bg-light m-3">
    <h4>Message List</h4>
    <form action="<?php echo URLROOT; ?>/admin/msglist" method="post">
      <div class="form-group row d-flex justify-content-end">
        <div class="col-sm-10">
          <div class="row">
            <label for="from" class="col-sm-2 d-flex justify-content-end align-items-center">From:</label>
            <div class="col-sm-3 form-group">
              <input type="date" name="from" class="form-control <?php echo (!empty($data['from_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['from']; ?>">
              <span class="invalid-feedback"><?php echo join("<br>", $data['from_err']); ?></span>
            </div>
            <label for="to" class="col-sm-1 d-flex justify-content-end align-items-center">To:</label>
            <div class="col-sm-3 form-group">
              <input type="date" name="to" class="form-control <?php echo (!empty($data['to_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['to']; ?>">
              <span class="invalid-feedback"><?php echo join("<br>", $data['to_err']); ?></span>
            </div>
            <div class="col-sm-2 form-group d-flex align-items-center">
              <input type="hidden" name='type' value='<?php echo $data['type'] ?>'>
              <input type="submit" value="Search" class="btn btn-success btn-block">
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- <p><?php print_r($data['list']); ?></p> -->
    <div class="table-responsive">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-md-12">
              <div class="search-box float-right">
                <div class="input-group">
                  <input type="text" id="search" class="form-control" placeholder="Search by Name">
                  <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div style="overflow-x:auto;">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="width: 15%;">Date</td>
                <td style="width: 20%;">Sender's Name</td>
                <td style="width: 20%;">subject</td>
                <td style="width: 40%;">Messege</td>
                <td style="width: 5%;"></td>
              </tr>
            </thead>
            <tbody>

              <?php for ($x = 0; $x < count($data['list']); $x += 2) : ?>
                <tr>
                  <td><?php echo $data['list'][$x]->date ?></td>
                  <td><?php echo $data['list'][$x]->patient ?></td>
                  <td><?php echo $data['list'][$x]->subject ?></td>
                  <td id='msg' style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $data['list'][$x]->message ?></td>
                  <td id='msg_id'><?php echo $data['list'][$x]->msg_id ?></td>
                  <td><button type="submit" class="viewmsg btn btn-link" data-toggle="modal" data-target="#vmsg"><i class="fa fa-ellipsis-h" aria-hidden="true" style="color: black;"></i></button></td>
                </tr>
                <?php if (isset($data['list'][$x + 1])) : ?>
                  <tr>
                  <td><?php echo $data['list'][$x+1]->date ?></td>
                  <td><?php echo $data['list'][$x+1]->patient ?></td>
                  <td><?php echo $data['list'][$x+1]->subject ?></td>
                  <td id='msg' style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $data['list'][$x+1]->message ?></td>
                  <td id='msg_id'><?php echo $data['list'][$x+1]->msg_id ?></td>
                  <td><button type="submit" class="viewmsg btn btn-link" data-toggle="modal" data-target="#vmsg"><i class="fa fa-ellipsis-h" aria-hidden="true" style="color: black;"></i></button></td>
                </tr>
                <?php endif; ?>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>


<div class="modal fade" id="vmsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Messege</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class='msgbody'></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.viewmsg').on('click', function() {
      var msg = $(this).closest('tr').find("#msg");
      var msg_id = $(this).closest('tr').find("#msg_id").text();
      // document.write(msg_id);
      $.ajax({
                type: "POST",
                url: "<?php echo URLROOT ?>/admin/viewmsg",
                dataType: 'json',
                data: {
                    "msg_id": msg_id,
                },
                success: function(data) {
                    if(data=='1'){
                        location.reload();
                        
                    }
                    document.write(data);
                }
            });
      var modal = $('#vmsg');
      modal.find('.msgbody').text(msg.text());
      $('#vmsg').modal('show');
    });
  });
</script>

<div class="col-md-2 bg-primary ">
<div class='result'></div>
</div>

<?php require APPROOT . '/views/inc/footer1.php'; ?>