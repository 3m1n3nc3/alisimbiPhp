$(document).ready(function () {
    $('#paymentTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': siteUrl + '/connection/tables.php?fetch=payment'
        },
        'columns': [
            {data: 'id'},
            {data: 'pl_name'},
            {data: 'pf_name'},
            {data: 'email'},
            {data: 'amount'},
            {data: 'payment_id'},
            {data: 'order_ref'},
            {data: 'date'},
        ],
        searching: false, paging: true, info: false
    });


    $('#userTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': siteUrl + '/connection/tables.php?fetch=users'
        },
        'columns': [
            {data: 'id'},
            {data: 'l_name'},
            {data: 'username'},
            {data: 'f_name'},
            {data: 'email'},
            {data: 'phone'},
            {data: 'city'},
            {data: 'state'},
            {data: 'country'},
            {data: 'role'},
        ]
    });


    $('#learnerTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            'url': siteUrl + '/connection/tables.php?fetch=learner'
        },
        'columns': [
            {data: 'user_id'},
            {data: 'delete'},
            {data: 'username'},
            {data: 'f_name'},
            {data: 'course_id'},
            {data: 'date'},
        ]
    });

    var timer = window.setTimeout(setCellTitle, 3000);

    function setCellTitle() {
        $('td').each(function() {
            let title = $(this).text();
            $(this).attr('title', title);
        });
    }


});

function deleteIt(type, id) {
    // $.ajax({
    //    type: "POST",
    //    url: siteUrl+"/connection/delete.php",
    //    data: "id="+id+"&type="+type,
    //    cache: false,
    //    success: function(html) {
    //       if(type == 0) {
    //          $('#sche-message').html(html);
    //          $('#schedule_'+id).fadeOut(500, function() { $('#schedule_'+id).remove(); });
    //       }
    //    }
    // });
}

