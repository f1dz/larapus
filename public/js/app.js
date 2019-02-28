$(document).ready(function(){
    // Confirm delete
    $(document.body).on('submit', '.js-confirm', function(){
        let $el = $(this);
        let text = $el.data('confirm') ? $el.data('confirm') : "Anda yakin?";
        let c = confirm(text);
        return c;
    });
});