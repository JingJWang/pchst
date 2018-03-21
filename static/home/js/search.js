$('.imports .entry').keyup(function(e){ 
    var curkey = e.which; 
    if(curkey == 13){ 
        $(".search-rock .search").click(); 
        return false; 
    } 
});

$('.search-rock .search').on('click', function() {
    var text = $('.imports .entry').val();
    if (text=='') {
        return ;
    };
    var type = $('.search-rock .total').attr('data');
    if (type=='mobile') {
        type='/mobile';
    }else if(type=='flat'){
        type='/flat';
    }else{
        alert('请选择类型');
        return ;
    }
    var url = '/recover/search/'+text+type;
    location.href = url;
});

$(".sort-name").click(function(){
    $(".categorize").css("display","none");
    $(".total").html($(this).html());
    $(".total").attr('data',$(this).attr('data'));
    $(this).siblings(".sort-name.active").removeClass("active");
    $(this).addClass("active");
});