$(document).on('click', '.search', function(event) {
    var text = $('.search-text').val();
    location.href = '/index.php/shops/shopinfo/searchshop/'+text+'/1';
});

$('.search-case .search-text').keyup(function(e){ 
    var curkey = e.which; 
    if(curkey == 13){ 
        $(".search-box .search").click(); 
        return false; 
    } 
});
