$(document).ready(function() {
    let $nbrTickets = $('input[name="tl_corebundle_command[nbrPerson]"]').val();
    let $reducedBox = $('.isReduced');
    let $tickets = $('.tickets')
    let $inputs = $('#tl_corebundle_command_tickets')
    let priceArray = []
    let price;

    let changePrice = function(price) {
        price.each(function(index, element) {
            let totalPrice = 0;
            priceArray[index] = (parseInt($(this).text()))
            for (var i = 0; i < priceArray.length; i++) {
                totalPrice += priceArray[i];
            }

            if ($('.halfDay').text() != '') {
                $('.total_price').html(totalPrice/2)
            } else {
                $('.total_price').html(totalPrice)
            }
        })
    }

    $('.birthday').each(function(index, element) {
        $tickets.append('<p class="ticket_'+index+'"></p>')
        let interval;

        var checkbox = []
        checkbox[index+1] = $('#tl_corebundle_command_tickets_ticket'+(index+1)+' input[type=checkbox]')
        checkbox[index+1].attr("disabled", true)
        checkbox[index+1].click(function() {
            if($(this).is(':checked')) {
                $('.ticket_'+index).html('1 ticket tarif réduit <span class="pull-right"><span class="price">10</span>€</span>')
                price = $('.price')
                changePrice(price)
            } else {
                definePrice()
                price = $('.price')
                changePrice(price)
            }
        })

        let definePrice = function() {
            let $birthday = ($(element).pickadate('picker').get('select', 'yyyy/mm/dd'))
            let $birthdayTS = new Date($birthday).getTime()
            let todayTS = new Date()
            interval = Math.floor((todayTS - $birthdayTS)/1000/365/30/24/60/2)
            if(!checkbox[index+1].is(':checked')) {
                if (interval >= 60) {
                    checkbox[index+1].removeAttr("disabled")
                    $('.ticket_'+index).html('1 ticket senior <span class="pull-right"><span class="price">12</span>€</span>')
                } else if(interval < 12 && interval >= 4) {
                    $('.ticket_'+index).html('1 ticket enfant <span class="pull-right"><span class="price">8</span>€</span>')
                    checkbox[index+1].attr("disabled", true)
                } else if(interval < 4) {
                    $('.ticket_'+index).html('1 ticket gratuit <span class="pull-right"><span class="price">0</span>€</span>')
                    checkbox[index+1].attr("disabled", true)
                } else {
                    checkbox[index+1].removeAttr("disabled")
                    $('.ticket_'+index).html('1 ticket normal <span class="pull-right"><span class="price">16</span>€</span>')
                } 
            }           
        }

        $(element).change(function() {
            definePrice();
            price = $('.price')
            changePrice(price)
        })
    })
});