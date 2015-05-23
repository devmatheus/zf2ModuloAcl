window.addEventListener('load', function () {
    $('#div_outro').css('display', 'none');
    $('label').has('input[value="outro"]').click(function () {
        if ($('#div_outro').css('display') == 'none') {
            $('#div_outro').css('display','block');
        } else {
            $('#div_outro').css('display','none');
        }
    });
}, false);