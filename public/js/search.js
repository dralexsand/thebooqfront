$(function () {
    
    let search, redirect;
    
    $('body').on('click', '#s_button', function (e) {
        
        search = $('#s').val();
        
        if (search.trim() !== '') {
            redirect = '/search/' + search;
            window.location.href = redirect;
        } else {
            redirect = '/';
            window.location.href = redirect;
        }
    });
    
    $('body').on('keypress', '#s', function (e) {
        
        search = $('#s').val();
        
        if (e.which === 13) {
            e.preventDefault();
            
            if (search.trim() !== '') {
                redirect = '/search/' + search;
                window.location.href = redirect;
            }else {
                redirect = '/';
                window.location.href = redirect;
            }
        }
    });
    
});
