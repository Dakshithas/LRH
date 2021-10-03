<?php
function build_calendar($month, $year, $holidays, $publicholidays, $physio_list, $physio)
{
    $unavailabledays = array('sunday');
    $daysofweek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $firstdayofmonth = mktime(0, 0, 0, $month, 1, $year);
    $numberdays = date('t', $firstdayofmonth);
    $datecomponents = getdate($firstdayofmonth);
    $monthname = $datecomponents['month'];
    $dayofweek = $datecomponents['wday'];
    $dayofweek = ($dayofweek == 0) ? 6 : $dayofweek - 1;  #
    $datetoday = date('Y-m-d');
    $prev_month = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prev_year = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $next_month = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $next_year = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));
    $calendar = "<center><h2>$monthname $year<h2>";
    $calendar .= "<a class='btn btn-link' href='?month=" . $prev_month . "&year=" . $prev_year . "'><i class='fa fa-chevron-left fa-2x' style='color: #696969;' aria-hidden='true'></i></a>";
    $calendar .= "<a class='btn btn-link' href='?month=" . date('m') . "&year=" . date('Y') . "'><i class='fa fa-calendar-plus-o fa-2x' style='color: #696969;' aria-hidden='true'></i></a>";
    $calendar .= "<a class='btn btn-link' href='?month=" . $next_month . "&year=" . $next_year . "'><i class='fa fa-chevron-right fa-2x' style='color: #696969;' aria-hidden='true'></i></a></center>";


    $calendar .= "
        <form id='physio_select_form' style='width:30%; margin:auto;'>
        <div class='row'>
        <div class='col-md-12 col-md-offset-3 form-group'>
        <center><label>Select Physio</label></center>
        <select class='form-control' id='physio_select' name='physio' style='text-align-last:center;'>";
    foreach ($physio_list as $physio) {
        $calendar .= "<option value='" . $physio->id . "'><h4>" . $physio->username . "</h4></option>";
    };
    $calendar .= "</select>
        <input type='hidden' name='month' value='" . $month . "'>
        <input type='hidden' name='year' value='" . $year . "'>
        </div>
        </div>
        </form>
        ";

    $calendar .= "<table class='table table-bordered'>";
    $calendar .= "<tr>";

    foreach ($daysofweek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }
    $calendar .= "</tr><tr>";
    if ($dayofweek > 0) {
        for ($k = 0; $k < $dayofweek; $k++) {
            $calendar .= "<td></td>";
        }
    }
    $currentday = 1;
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($currentday <= $numberdays) {
        if ($dayofweek == 7) {
            $dayofweek = 0;
            $calendar .= "</tr><tr>";
        }
        $currentdayrel = str_pad($currentday, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentdayrel";
        $dayname = strtolower(date('l', strtotime($date)));
        $eventno = 0;
        $today = $date == date('Y-m-d') ? 'today' : "";
        // $bookings = isset($bookslots[$date]) ? $bookslots[$date] : 0;
        if (in_array($dayname, $unavailabledays)) {
            $calendar .= "<td class='$today'><h5>$currentday</h5><button class='btn btn-secondary btn-sm'>Hoiliday</button>";
        } elseif ($date < date('Y-m-d')) {
            $calendar .= "<td class='$today'><h5>$currentday</h5><button class='btn btn-danger btn-sm'>N/A</button>";
        } elseif (in_array($date, $publicholidays)) {
            $calendar .= "<td class='$today'><h5>$currentday</h5><button class='btn btn-danger btn-sm' data-container='body' data-toggle='popover' data-trigger='focus' data-placement='bottom' data-content='Public Holiday.'>Holiday</button>";
        } elseif (in_array($date, $holidays)) {
            $calendar .= "<td class='$today'><h5>$currentday</h5><button class='btn btn-danger btn-sm' data-container='body' data-toggle='popover' data-trigger='focus' data-placement='bottom' data-content='Holiday Already added.'>Leave</button>";
        } else {
            $calendar .= "<td class='$today'><h5>$currentday</h5>
            <button class='btn btn-success btn-sm book' data-toggle='modal' data-target='#myModal' data-timeslot='$date'>Add</button>";
            
        }
        $calendar .= "</td>";
        $currentday++;
        $dayofweek++;
    }
    if ($dayofweek != 7) {
        $remainingdays = 7 - $dayofweek;
        for ($i = 0; $i < $remainingdays; $i++) {
            $calendar .= "<td></td>";
        }
    }
    $calendar .= "</tr>";
    $calendar .= "</table>";
    return $calendar;
}
?>
<?php require APPROOT . '/views/inc/header1.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/calendar.css">
<div class="col-md-10 col-sm-12" style="padding:0px">


    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <?php
            $month = $data['month'];
            $year = $data['year'];
            $holidays = $data['holidays'];
            $publicholidays = $data['publicholidays'];
            $physio_list = $data['physio_list'];
            $physio = $data['physio'];
            // $holidays=array_column($holidays,'date');
            // print_r($ho);
            echo build_calendar($month, $year, $holidays, $publicholidays, $physio_list, $physio);
            ?>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class='col-12 modal-title text-center'>Leave Confirmation: </h5>
            </div>
            <!-- <p><span id="slot"></span></p> -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="">Timeslot</label>
                                <input required type="text" readonly name="date" id="timeslot" class="form-control">
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
</div>

<!-- <div class="col-md-2 bg-dark">
    <?php require APPROOT . '/views/physio/sidebar.php'; ?>
</div> -->

<?php require APPROOT . '/views/inc/footer1.php'; ?>


<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $(function() {
        $('[data-toggle="popover"]').popover()
        trigger: 'focus'
    })
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    $("#physio_select").change(function() {
        $("#physio_select_form").submit();
    });
    $("#physio_select option[value='<?php echo $physio; ?>']").attr('selected', 'selected');
</script>
<script>
    $(".book").click(function() {
        var timeslot = $(this).attr('data-timeslot');
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);
        $("#myModal").modal("show")
    })
</script>