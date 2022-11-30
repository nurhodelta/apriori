$(function(){
    // base url
    var base_url = $('.base_url').data('value');

    var historytable = $('#historyTable').DataTable({
    	"processing": true, 
        "serverSide": true, 
        "order": [[0, 'desc']], 
 
        "ajax": {
            "url": base_url+"admin/history/dthistory",
            "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        { 
	            "targets": [],
	            "orderable": false,
	        },
        ],
        "columns": [
            { data: "date_viewed",
                render: function (data, type, row) {
                    return formatDate(data);
                }
            },
            { data: "user_id", 
                render: function (data, type, row) {
                    return row.first_name + ' ' + row.last_name;
                }
            },
            { data: "product_name" }
       ],
    });

});

function formatDate(date) {
    var main_data_array = date.split(' ');

    var date_array = main_data_array[0].split('-');
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    var time_array = main_data_array[1].split(':');
    var meridian = '';
    var hour_time = '';
    var hour = time_array[0];
    var min = time_array[1];

    if (hour < 12) {
        meridian = 'AM';
        hour_time = hour;
    }

    if (hour > 12) {
        meridian = 'PM';
        var new_hour = parseInt(hour)-12;
        if (new_hour < 10) {
            hour_time = '0'+new_hour;
        } else {
            hour_time = new_hour;
        }
    }

    if (hour == 12) {
        if (min == '00') {
            meridian = 'NN';
        } else {
            meridian = 'PM'; 
        }
        hour_time = hour;
    }

    return months[parseInt(date_array[1]) - 1] + ' ' + date_array[2] + ', ' + date_array[0] + ' - ' + hour_time + ':' + min + ' ' + meridian;
}