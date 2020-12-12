$(document).ready(function() {
    
    if ($('input[type=checkbox]').prop('checked') == false) {
        $('.discount').hide();
    }
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    $('input[type=checkbox]').on('change', function(e) {
        e.preventDefault();
        console.log('checked');

        var isChecked = $(this).prop('checked');
        
        if (isChecked) {
            $('.discount').show();
        } else {
            $('.discount').hide();
        }
    })    
})