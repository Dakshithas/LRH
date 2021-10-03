<?php require APPROOT . '/views/inc/header1.php'; ?>
<div class="col-md-8 col-sm-10" style="padding:0px">

  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Create An Account</h2>
        <p>Please fill out this form to register with us</p>
        <form action="<?php echo URLROOT; ?>/admin/register" method="post">

          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
              <input type="radio" name="role" id="option1" autocomplete="off" value='physiotheraphist'> Physiotheraphist
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="role" id="option2" autocomplete="off" value='receptionist'> Receptionist
            </label>
            </div>
            <input type="radio" name="role" class="form-control <?php echo (!empty($data['role_err'])) ? 'is-invalid' : ''; ?>" id="option1" autocomplete="off" value="" checked style= 'display:none'>
            <span class="invalid-feedback">&emsp;&emsp;<?php echo join("<br>",$data['role_err']); ?></span>
            
          <!-- </div> -->
          <div class="form-group">
            <label for="username">User Name: <sup>*</sup></label>
            <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
            <span class="invalid-feedback"><?php echo join("<br>",$data['username_err']); ?></span>
          </div>
          <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
            <span class="invalid-feedback"><?php echo join("<br>",$data['email_err']); ?></span>
          </div>
          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
            <span class="invalid-feedback"><?php echo join("<br>",$data['password_err']); ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password: <sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
            <span class="invalid-feedback"><?php echo join("<br>",$data['confirm_password_err']); ?></span>
          </div>

          <div class="row">
            <div class="col">
              <input type="submit" value="Register" class="btn btn-success btn-block">
            </div>
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

<div class="col-md-2 bg-primary">
  
</div>

<?php require APPROOT . '/views/inc/footer1.php'; ?>