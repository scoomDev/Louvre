$(document).ready(function() {
    let today = new Date();
    let todayDate = today.getDate() + '/' + today.getMonth() + '/' + today.getFullYear()

    let toDate = function(dateStr) {
        var parts = dateStr.split("/");
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    let getDayPicker = function() {
        let $dayPicker = $('.datepicker').pickadate('picker').get('select', 'yyyy/mm/dd')
        let day = toDate($dayPicker)
        let dayDate = day.getDate() + '/' + day.getMonth() + '/' + day.getFullYear()
        return dayDate
    }
    
    let verifyHours = function(todayDate, dayDate) {
        if(todayDate === dayDate && today.getHours() >= '14') {
            $('#start_type option[value="day"]').attr('disabled', 'disabled')
            $('#start_type').val("halfDay")
            $('#start_type').trigger('chosen:updated')
        } else {
            $('#start_type option[value="day"]').removeAttr('disabled')
        }
    }

    let dayDate = getDayPicker()
    verifyHours(todayDate, dayDate)
    $('.datepicker').change(function() {
        dayDate = getDayPicker()
        verifyHours(todayDate, dayDate)
    })
})