<?php require APPROOT . '/views/inc/header1.php'; ?>
<div class="col-md-8 col-sm-10" style="padding:0px">

<div class='row justify-content-center'>
                    <div class='col-md-11'>
                    <div class="card card-body bg-light mt-5">
                    <h2>Add a Patient</h2>
                    <form action="<?php echo URLROOT; ?>/receptionist/register" method="post">
                            <div class="col-sm-12">
                                
                            <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>First Name</label>
                                <input type="fname" name="fname" class="form-control <?php echo (!empty($data['fname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['fname']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['fname_err']); ?></span>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" class="form-control <?php echo (!empty($data['lname_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['lname']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['lname_err']); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                            <span class="invalid-feedback"><?php echo join("<br>", $data['email_err']); ?></span>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['username_err']); ?></span>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>NIC No</label>
                                <input type="text" name="nic" maxlength="12" class="form-control <?php echo (!empty($data['nic_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nic']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['nic_err']); ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <label>Birthday</label>
                                <input type="date" max='<?php echo date('Y-m-d', strtotime(date('Y-m-d') . " - 30 day")); ?>' name="bday" class="form-control <?php echo (!empty($data['bday_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['bday']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['bday_err']); ?></span>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label>Contact No(mobile)</label>
                                <input type="tel" name="mnumber" class="form-control <?php echo (!empty($data['mnumber_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['mnumber']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['mnumber_err']); ?></span>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label>Contact No(land)</label>
                                <input type="lnumber" name="lnumber" class="form-control <?php echo (!empty($data['lnumber'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['lnumber']; ?>">
                                <span class="invalid-feedback"><?php echo join("<br>", $data['lnumber_err']); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name='address' rows="3" class="form-control"></textarea>
                        </div>
                        <div class="row justify-content-end">
                            <input type="submit" value="Register" class="btn btn-success btn-block" style="margin:30px">
                        </div>
                                <!-- <button type="button" class="btn btn-lg btn-info">Submit</button> -->
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
</div>
<div class="col-md-2 bg-primary">
</div>
<?php require APPROOT . '/views/inc/footer1.php'; ?>