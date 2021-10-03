// $(document).ready(function () {
//     $('#dtBasicExample').DataTable();
//     $('.dataTables_length').addClass('bs-select');
//     });
//     function search(){
//         // Activate tooltips
//         $('[data-toggle="tooltip"]').tooltip();
        
//         // Filter table rows based on searched term
//         $("#search").on("keyup", function() {
//             var term = $(this).val().toLowerCase();
//             $("table tbody tr").each(function(){
//                 $row = $(this);
//                 var name = $row.find("td").text().toLowerCase();
//                 console.log(name);
//                 if(name.search(term) < 0){                
//                     $row.hide();
//                 } else{
//                     $row.show();
//                 }
//             });
//         });
//     };


    $(".book").click(function() {
        var timeslot = $(this).attr('data-timeslot');
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);
        $("#myModal").modal("show")
    })