var start = {
    elem: '#ustart',
    format: 'YYYY-MM-DD',
    max: '2099-06-16', //最大日期
    istime: false,
    istoday: false,
    choose: function(datas){
        end.min = datas; //开始日选好后，重置结束日的最小日期
        end.start = datas ;//将结束日的初始值设定为开始日
    }
};
var end = {
    elem: '#uend',
    format: 'YYYY-MM-DD',
    max: '2099-06-16',
    istime: false,
    istoday: false,
    choose: function(datas){
        start.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(start);
laydate(end);

var start1 = {
    elem: '#dstart',
    format: 'YYYY-MM-DD',
    max: '2099-06-16 ', //最大日期
    istime: false,
    istoday: false,
    choose: function(datas){
        end1.min = datas; //开始日选好后，重置结束日的最小日期
        end1.start = datas ;//将结束日的初始值设定为开始日
    }
};
var end1 = {
    elem: '#dend',
    format: 'YYYY-MM-DD',
    max: '2099-06-16',
    istime: false,
    istoday: false,
    choose: function(datas){
        start1.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(start1);
laydate(end1);

var start2 = {
    elem: '#hstart',
    format: 'YYYY-MM-DD',
    max: '2099-06-16', //最大日期
    istime: false,
    istoday: false,
    choose: function(datas){
        end2.min = datas; //开始日选好后，重置结束日的最小日期
        end2.start = datas ;//将结束日的初始值设定为开始日
    }
};
var end2 = {
    elem: '#hend',
    format: 'YYYY-MM-DD',
    max: '2099-06-16',
    istime: false,
    istoday: false,
    choose: function(datas){
        start2.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(start2);
laydate(end2);

var start3 = {
    elem: '#jstart',
    format: 'YYYY-MM-DD',
    max: '2099-06-16', //最大日期
    istime: false,
    istoday: false,
    choose: function(datas){
        end3.min = datas; //开始日选好后，重置结束日的最小日期
        end3.start = datas ;//将结束日的初始值设定为开始日
    }
};
var end3 = {
    elem: '#jend',
    format: 'YYYY-MM-DD',
    max: '2099-06-16',
    istime: false,
    istoday: false,
    choose: function(datas){
        start3.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(start3);
laydate(end3);

var start4 = {
    elem: '#xstart',
    format: 'YYYY-MM-DD',
    max: '2099-06-16', //最大日期
    istime: false,
    istoday: false,
    choose: function(datas){
        end4.min = datas; //开始日选好后，重置结束日的最小日期
        end4.start = datas; //将结束日的初始值设定为开始日
    }
};
var end4 = {
    elem: '#xend',
    format: 'YYYY-MM-DD',
    max: '2099-06-16',
    istime: false,
    istoday: false,
    choose: function(datas){
        start4.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(start4);
laydate(end4);

