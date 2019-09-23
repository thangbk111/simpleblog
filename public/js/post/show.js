$(document).ready(function () {
    $('#published_at').datetimepicker({
        defaultDate: moment().format('YYYY-MM-DD HH:mm:ss'),
        format: 'YYYY-MM-DD HH:mm:ss',
    });
});