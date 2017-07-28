$(document).ready(function(){

    var day = new Date();
    var year = day.getFullYear();
    var month = day.getMonth();

    $('.datepicker').pickadate({
        min: day,
        max: new Date(year+2,month,01),
        disable: [
            2,7,
            new Date(year,11,25),
            new Date((year+1),11,25),
            new Date((year+2),11,25),
            new Date(year,10,01),
            new Date((year+1),10,01),
            new Date((year+2),10,01),
            new Date(year,04,01),
            new Date((year+1),04,01),
            new Date((year+2),04,01),
        ]
    });
});