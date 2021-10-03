<?php
$duration = $data['duration'];
$cleanup = $data['cleanup'];
$start = $data['start'];
$end = $data['end'];
$date = $data['date'];
function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slot = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
    }
    return $slots;
}
?>







<?php require APPROOT . '/views/inc/header1.php'; ?>
<div class="col-md-8 col-sm-10" style="padding:0px">


    <div class='row justify-content-center'>
        <div class='col-md-11'>
            <!-- <div class="container"> -->
                <h1 class="text-center">Book for Date <?php echo $date; ?></h1>
                <hr>
                <div class="row">
                    <?php $timeslots = timeslots($duration, $cleanup, $start, $end);
                    foreach ($timeslots as $ts) :
                    ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php if (in_array($ts, $data['bookings'])) : ?>
                                    <button class="btn btn-danger"><?php echo $ts; ?></button>
                                <?php else : ?>
                                    <button class="btn btn-success book" data-toggle="modal" data-target="#myModal" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class='col-12 modal-title text-center'>Booking Confirmation: </h5>
                        </div>
                        <!-- <p><span id="slot"></span></p> -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input required type="date" readonly name="date" value=<?php echo $date ?> class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Timeslot</label>
                                            <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input required type="text" readonly name="name" class="form-control" value="dakshitha">
                                        </div>
                                        <div class="form-group pull-right">
                                            <button type="submit" class="btn btn-primary" name="submit">Confirm</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
</div>
<script>
    $(".book").click(function() {
        var timeslot = $(this).attr('data-timeslot');
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);
        $("#myModal").modal("show")
    })
</script>


<div class="col-md-2 bg-dark">

</div>

<?php require APPROOT . '/views/inc/footer1.php'; ?>