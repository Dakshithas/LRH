<?php $profile = $_SESSION['profile']; ?>
<div id="sidebar-container" class="sidebar-expanded d-none d-md-block col-3">
    <div class="profile">

        <div class="profile-userpic">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($profile['pic']) ?> " height="100" class="rounded-circle">
            <!-- <i class="fa fa-camera upload-button"></i>
        <input class="file-upload" type="file" accept="image/*"/> -->
        </div>
        <p class='full-name m-1'><?php echo $profile['fname'] . ' ' . $profile['lname'] ?></p>
        <p class='email m-1'><?php echo $profile['email'] ?></p>
        <p class='address m-1'><?php echo $profile['address'] ?></p>
        <p class='birthday m-1'><?php echo $profile['mnumber'] ?></p>
    </div>
    <div class="menu">
        <ul class="list-group sticky-top sticky-offset bg-dark">
            <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>MAIN MENU</small>
            </li>
            <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-user fa-fw mr-3"></span>
                    <span class="menu-collapsed">Profile</span>
                    <span class="submenu-icon ml-auto"></span>
                </div>
            </a>

            <div id="submenu2" class="collapse sidebar-submenu">
                <button type="button" class="btn list-group-item list-group-item-action bg-dark text-white" data-toggle="modal" data-target=".bd-example-modal-lg"><span class="menu-collapsed">Update Informations</span></button>
                <button type="button" class="btn list-group-item list-group-item-action bg-dark text-white" data-toggle="modal" data-target="#changepwd"><span class="menu-collapsed">Change Password</span></button>
            </div>

            <?php require APPROOT . '/views/inc/navleft/' . $_SESSION['role'] . '.php'; ?>

        </ul>
    </div>

</div>



<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changepwd">Launch demo modal</button> -->

<!-- CHANGE PASSWORD -->
<div class="modal fade" id="changepwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" role="form" id='chg' autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputPasswordOld">Current Password</label>
                        <input type="password" class="form-control" id="currentpwd" required="">
                        <div class="invalid-feedback d-block currentpwd"></div>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordNew">New Password</label>
                        <input type="password" class="form-control" id="newpwd" required="">
                        <div class="invalid-feedback d-block newpwd"></div>
                        <span class="form-text small text-muted">
                            The password must be 8-20 characters, and must <em>not</em> contain spaces.
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordNewVerify">Verify</label>
                        <input type="password" class="form-control" id="confirmpwd" required="">
                        <div class="invalid-feedback d-block confirmpwd"></div>
                        <span class="form-text small text-muted">
                            To confirm, type the new password again.
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary changepwd">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id='update' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id='view'>
                <div class="col-sm-12">

                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>First Name</label>
                            <input type="fname" id='fname' name="fname" class="form-control" value="<?php echo $profile['fname']; ?>">
                            <div class="invalid-feedback d-block fname"></div>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Last Name</label>
                            <input type="text" id='lname' name="lname" class="form-control" value="<?php echo $profile['lname']; ?>">
                            <div class="invalid-feedback d-block lname"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id='email' class="form-control" value="<?php echo $profile['email']; ?>">
                        <div class="invalid-feedback d-block email"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $profile['username']; ?>">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>NIC No</label>
                            <input type="text" name="nic" maxlength="12" class="form-control" value="<?php echo $profile['nic']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <label>Birthday</label>
                            <input type="date" id='bday' max='<?php echo date('Y-m-d', strtotime(date('Y-m-d') . " - 30 day")); ?>' name="bday" class="form-control" value="<?php echo $profile['bday']; ?>">
                            <div class="invalid-feedback d-block bday"></div>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Contact No(mobile)</label>
                            <input type="tel" name="mnumber" id='mnumber' class="form-control" value="<?php echo $profile['mnumber']; ?>">
                            <div class="invalid-feedback d-block mnumber"></div>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Contact No(land)</label>
                            <input type="lnumber" name="lnumber" id='lnumber' class="form-control" value="<?php echo $profile['lnumber']; ?>">
                            <div class="invalid-feedback d-block lnumber"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" row='3' id='address' class="form-control"><?php echo $profile['address']; ?></textarea>
                        <div class="invalid-feedback d-block address"></div>
                    </div>
                    <div class="row justify-content-end">
                        <input type="submit" value="Update Informations" class="btn btn-success btn-block updateinfo" style="margin:30px">
                    </div>
                    <!-- <button type="button" class="btn btn-lg btn-info">Submit</button> -->
                </div>
            </form>
            <div class="result bg-white">
            </div>
        </div>
    </div>
</div>
<!-- ===================================================================================================================================== -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
    $(document).ready(function() {
        $('.updateinfo').click(function(e) {
            e.preventDefault();
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var bday = $('#bday').val();
            var mnumber = $('#mnumber').val();
            var lnumber = $('#lnumber').val();
            var address = $('#address').val();
            // document.write(fname);
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT . '/' . $_SESSION['role'] ?>/updateinfo",
                dataType: 'json',
                data: {
                    "first_name": fname,
                    "last_name": lname,
                    "email": email,
                    "birth_day": bday,
                    "mobile_number": mnumber,
                    "land_number": lnumber,
                    "address": address
                },
                success: function(data) {
                    if (data == '1') {
                        location.reload();

                    }
                    var fname = data.first_name_err;
                    // document.write(fname);
                    var lname = data.last_name_err;
                    var email = data.email_err;
                    var bday = data.birth_day_err;
                    var mnumber = data.mobile_number_err;
                    var lnumber = data.land_number_err;
                    var address = data.address_err;
                    var modal = $('#update');
                    modal.find('.fname').text(fname);
                    modal.find('.lname').text(lname);
                    modal.find('.email').text(email);
                    modal.find('.bday').text(bday);
                    modal.find('.mnumber').text(mnumber);
                    modal.find('.lnumber').text(lnumber);
                    modal.find('.address').text(address);
                    $('.result').html(data);
                    // $('#view')[0].reset();

                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.changepwd').click(function(e) {
            e.preventDefault();
            var currentpwd = $('#currentpwd').val();
            var newpwd = $('#newpwd').val();
            var confirmpwd = $('#confirmpwd').val();
            // document.write(confirmpwd);
            $.ajax({
                type: "POST",
                url: "<?php echo URLROOT . '/' . $_SESSION['role'] ?>/changepwd",
                dataType: 'json',
                data: {
                    "current_password": currentpwd,
                    "new_password": newpwd,
                    "retype_new_password": confirmpwd,
                },
                success: function(data) {
                    // document.write(data);
                    if (data == '1') {
                        location.reload();
                    }
                    var currentpwd = data.current_password_err;
                    var newpwd = data.new_password_err;
                    var confirmpwd = data.retype_new_password_err;

                    var modal = $('#changepwd');
                    modal.find('.currentpwd').text(currentpwd);
                    modal.find('.newpwd').text(newpwd);
                    modal.find('.confirmpwd').text(confirmpwd);
                    $('.result').html(data);
                    document.getElementById("chg").reset();

                }
            });
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {


        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });
    });
</script> -->


<style>
    .modal-content {
        width: 100%;
    }

    .modal-dialog-centered {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        min-height: calc(100% - (.5rem * 2));
    }

    @media (min-width: 576px) {
        .modal-dialog-centered {
            min-height: calc(100% - (1.75rem * 2));
        }
    }
   
</style>