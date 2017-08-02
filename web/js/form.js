$(document).ready(function() {
    var $container = $('div#tl_corebundle_command_tickets');
    var $index = $('input[name="tl_corebundle_command[nbrPerson]"]').val();
    var $ticketPriceBox = $('.tickets')

    function addForm($container, $index) {
        for (var i = 0; i < $index; i++) {          
            var template = $container.attr('data-prototype')
                .replace(/__name__label__/g, 'Visiteur ' + (i+1))
                .replace(/__name__/g, 'ticket'+ (i+1))

            var $protoype = $(template);
            $container.append($protoype);
        }
    }
    addForm($container, $index);
})