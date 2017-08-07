$(document).ready(function() {
    let $container = $('div#tl_corebundle_command_tickets');
    let $index = $('input[name="tl_corebundle_command[nbrPerson]"]').val();
    let $ticketPriceBox = $('.tickets');

    function addForm($container, $index) {
        for (let i = 0; i < $index; i++) {          
            let template = $container.attr('data-prototype')
                .replace(/__name__label__/g, 'Visiteur ' + (i+1))
                .replace(/__name__/g, 'ticket'+ (i+1))

            let $protoype = $(template);
            $container.append($protoype);
        }
    }
    addForm($container, $index);
})