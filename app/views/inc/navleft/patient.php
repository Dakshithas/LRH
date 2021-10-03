<a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="fa fa-folder-open-o mr-3" aria-hidden="true"></i>
        <span class="menu-collapsed">Reports</span>
        <span class="submenu-icon ml-auto"></span>
    </div>
</a>

<div id="submenu3" class="collapse sidebar-submenu">
    <a href="<?php echo URLROOT; ?>/admin/msglist" class="list-group-item list-group-item-action bg-dark text-white">
        <span class="menu-collapsed">daily Reports</span>
    </a>
    <a href="<?php echo URLROOT; ?>/admin/msglist?type=seen" class="list-group-item list-group-item-action bg-dark text-white">
        <span class="menu-collapsed">long form</span>
    </a>
</div>

<button type="button" class="btm list-group-item bg-dark text-white" data-toggle="modal" data-target="#sendmsg">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="fa fa-comments-o mr-3" aria-hidden="true"></i>
        <span class="menu-collapsed">Send Message</span>
    </div>
</button>

<a href="<?php echo URLROOT; ?>/patient/chgappoinment" class="bg-dark list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
    <i class="fa fa-calendar mr-3" aria-hidden="true"></i>
        <span class="menu-collapsed">Appoinment</span>
    </div>
</a>

<!-- <a href="<?php echo URLROOT; ?>/admin/list" class="bg-dark list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="fa fa-list-alt mr-3" aria-hidden="true"></i>
        <span class="menu-collapsed">User Informations</span>
    </div>
</a> -->

<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
</button> -->

<!-- Modal -->




<div class="modal fade" id="sendmsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Message to Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <form>
                            <table class="table">
                                <tr>
                                    <td><input type="tel" class="form-control" id="contact_number" placeholder="Your e-mail">
                                        <div class="invalid-feedback d-block contact_number"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" id='subject' type="text" placeholder="Subject">
                                        <div class="invalid-feedback d-block subject"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><textarea class="form-control" id='message' rows="7" placeholder="Message text . . ."></textarea>
                                        <div class="invalid-feedback d-block message"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-danger btn-sm sendmsg" style="width: 100%;"><i class="fa fa-envelope-o" style="padding-right: 5px;"></i> Send</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
    $(document).ready(function() {
        $('.sendmsg').click(function(e) {
            e.preventDefault();
            var contact_number = $('#contact_number').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            // document.write(message);
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT; ?>/patient/sendmsg",
                dataType: 'json',
                data: {
                    "contact_number": contact_number,
                    "subject": subject,
                    "message": message,
                },
                success: function(data) {
                    // document.write(data);
                    if (data == 1) {
                        location.reload();
                    } else if (data == '2') {
                        document.write(data);
                    } else {
                        var contact_number = data.contact_number_err;
                        var subject = data.subject_err;
                        var message = data.message_err;
                        var modal = $('#sendmsg');
                        modal.find('.contact_number').text(contact_number);
                        modal.find('.subject').text(subject);
                        modal.find('.message').text(message);
                    }

                    // $('.result').html(data);
                    // document.getElementById("chg").reset();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorFunction();
                }
            });
        });
    });
</script>
<style>
    .modal-backdrop {
        z-index: -1;
    }
</style>