$(function(){
    
    $('.list-group a').click(function(e) {
        e.preventDefault()
        
        $that = $(this);
        
        $('.list-group').find('a').removeClass('active');
        $that.addClass('active');
    });
})