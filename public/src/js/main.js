$(".layui-form").submit(function () {
    submitForm(".layui-form");
    return false;
});

function submitForm(id, callback) {
    var form = $(id);
    submitFormIframe(form,callback)
}

function submitFormIframe(form,callback) {
    var url = form.attr('action');
    var obj = serializeForm(form);
    if(url!=='' && url!==undefined){
        postSomething(url, obj, callback);
    }else{
        console.log('url empty');
    }
    return false;
}

function serializeForm(obj) {
    var params = {};
    $.each($(obj).serializeArray(), function (index, param) {
        if (!(param.name in params)) {
            params[param.name] = param.value;
        }
    });
    return params;
}

function postSomething(url, obj, callback) {
    $.ajax({
        type: "POST",
        url: url,
        enctype: 'multipart/form-data',
        data: obj,
        success: function (res) {
            if(callback === undefined){
                callback = function (res) {
                    if(res.code){
                        layer.msg(res.msg,{icon:1,time:1500},function () {
                            window.location.href = res.url;
                        });
                    }else{
                        layer.msg(res.msg,{icon:2,time:1500});
                    }
                };
            }
            callback(res);
        }
    });
}

function getFetch(url,callback) {
    $.ajax({
        type: "GET",
        url: url,
        enctype: 'multipart/form-data',
        data: {},
        success: function (res) {
            if(callback === undefined){
                callback = function (res) {
                    console.log(res);
                };
            }
            callback(res);
        }
    });
}

function openLayer(url , config, btnFunction) {
    getFetch(url,function (content) {
        var option = {
            type: 1,title: '查看',closeBtn: 1
            ,width: '400px',height:'400px',shade: 0.3,shadeClose:true
            ,btn: ['保存','取消'],moveType: 1
            ,maxmin: false
        };

        $.extend(option,config);

        var layer_option = {
            type: option.type
            ,title: option.title
            ,area: [option.width, option.height]
            ,shade: option.shade
            ,shadeClose: option.shadeClose
            ,maxmin: option.maxmin
            ,content: content
            ,moveType:option.moveType
            ,btn: option.btn
        };
        $.extend(layer_option , btnFunction);
        console.log(layer_option);
        layer.open(layer_option);
    });
}