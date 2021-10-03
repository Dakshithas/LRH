<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<div class="holder">
  <iframe src="http://lrh.health.gov.lk/home-en/" id="theframe" frameborder="0" allowfullscreen></iframe>

  <button type="button" class="btn btn-link" id="bt1" ><a href="<?php echo URLROOT; ?>/users/login"><i class="fa fa-user fa-3x" style="color:white;" aria-hidden="true"></i> <i class="fa fa-sign-in fa-2x" style="color:white;" aria-hidden="true"></i></a></button>
</div>   

<style>
html,
/* body {
  height: 100vh;
  width: 100vw;
} */

button img {
  width: 100%;
}

#bt1 {
  position: absolute;
  right: 20px;
}

#theframe {
  width: 100%;
  height: 100%;
}

.holder {
  width: 100%;
  height: 100%;
  position: relative;
}
</style>