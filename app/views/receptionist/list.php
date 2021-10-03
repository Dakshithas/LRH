<?php require APPROOT . '/views/inc/header1.php'; ?>
<div class="col-md-8 col-sm-10" style="padding:30px">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"> -->

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
                            <th>#</th>
                            <?php foreach ($data['titles'] as $title) : ?>
                                <th><?php echo ucfirst($title) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php for ($x = 0; $x < count($data['list']); $x += 2) : ?>
                            <tr>
                                <td><?php echo $x ?></td>
                                <?php foreach ($data['titles'] as $title) : ?>
                                    <td><?php echo $data['list'][$x]->$title ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <?php if ($data['role'] == 'patient') : ?>
                                            <button type="button" class="btn btn-link editbtn" data-toggle="modal" data-target="#editmodal"><i class="fa fa-id-card-o fa-3x" aria-hidden="true"></i></button>
                                            
                                        <?php endif; ?>
                                       </div>
                                </td>

                            </tr>
                            <?php if (isset($data['list'][$x + 1])) : ?>
                                <tr>
                                    <td><?php echo $x + 1 ?></td>
                                    <?php foreach ($data['titles'] as $title) : ?>
                                        <td><?php echo $data['list'][$x + 1]->$title ?></td>
                                    <?php endforeach; ?>
                                    <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <?php if ($data['role'] == 'patient') : ?>
                                            <button type="button" class="btn btn-link editbtn" data-toggle="modal" data-target="#editmodal"><i class="fa fa-id-card-o fa-3x" aria-hidden="true"></i></button>
                                            
                                        <?php endif; ?>
                                        </div>
                                </td>

                                </tr>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
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
                                        <input class="" type="text" name="lname" id="lname" style="width:100%; font-size:13px">
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
                                    <input type="hidden" name="id" id="patient_id">
                                    <div class="col-sm-3">
                                        <center><a href=""><i class="fa fa-list-alt fa-3x" style="color: #0E92EF;" aria-hidden="true"></i></a>
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
                                            <button class="btn btn-link" type="submit" formaction="<?php echo URLROOT; ?>/receptionist/giveappoinment"><i class='fa fa-calendar-plus-o fa-3x' style="color: #0E92EF;" aria-hidden='true'></i></button>
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

    <script>
        $(document).ready(function() {
            $('.editbtn').on('click', function() {
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                var modal = $('#editmodal');
                modal.find('.name').text(data[0]);
                modal.find('.mnumber').text(data[1]);
                modal.find('.email').text('email: ' + data[2]);
                modal.find('.address').text(data[3]);
                modal.find('.next').text(data[4]);
                $('#patient_id').val(data[1]);
                $('#editmodal').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Activate tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Filter table rows based on searched term
            $("#search").on("keyup", function() {
                var term = $(this).val().toLowerCase();
                $("table tbody tr").each(function() {
                    $row = $(this);
                    var name = $row.find("td").text().toLowerCase();
                    console.log(name);
                    if (name.search(term) < 0) {
                        $row.hide();
                    } else {
                        $row.show();
                    }
                });
            });
        });
    </script>
    <style>
        .col-md-5 input[type=text] {
            color: white;
            border: 0px;
            text-align: center;
            background: transparent;
        }

        .col-md-7 input[type=text] {
            color: grey;
            border: 0px;
            text-align: center;
            background: transparent;
        }

        .row .col-sm-3 p {
            font-size: 12px;
        }

        .profile-info {
            padding: auto;
        }
    </style>
</div>
<div class="col-md-2">
</div>

<?php require APPROOT . '/views/inc/footer1.php'; ?>