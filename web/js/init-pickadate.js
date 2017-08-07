$(document).ready(function(){

    let today = new Date();
    let today_day = today.getDay()
    let today_hours = today.getHours()
    let today_minutes = today.getMinutes()
    let year = today.getFullYear();
    let month = today.getMonth();

     if(today_day === 1 || today_day === 4 || today_day === 6 || today_day === 7) {
        if(today_hours >= 18) {
            if(today_day === 1 || today_day === 6) {
                today = today.setDate(today.getDate()+2);
                today = new Date(today);
            } else {
                today = today.setDate(today.getDate()+1);
                today = new Date(today);
            }
        }
    } else if(today_day === 3 || today_day == 5) {
        if(today_hours >= 21 && today_minutes >= 45) {
            today = today.setDate(today.getDate()+1);
            today = new Date(today);
        }
    } 

    $('.birthday').pickadate({
        selectYears: 110,
        selectMonths: true,
        max: new Date()
    });

    $('.datepicker').pickadate({
        min: today,
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