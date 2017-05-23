/**
 * Created by Axios on 2017/5/23.
 */

function editNode(obj,status) {
    var tds = $(obj).parent().parent().children();
    var td,html,name,value;
    if(status === undefined){
        $.each(tds,function (index,data) {
            td = $(data);
            if(td.hasClass('td_edit')){
                name = td.attr('data-name');
                value = td.html();
                html = "<input class='layui-input' type='text' name='"+name+"' data-value='"+value+"' value='"+value+"'>";
                td.html(html)
            }
            if(td.hasClass('td_operation')){
                html = '<button class="layui-btn layui-btn-small layui-btn-normal" onclick="updateNode(this);">保存</button>' +
                    '<button class="layui-btn layui-btn-small layui-btn-primary" onclick="editNode(this,0);">取消</button>';
                td.html(html);
            }
        });
    }else if(status===0){
        $.each(tds,function (index,data) {
            td = $(data);
            if(td.hasClass('td_edit')){
                name = td.attr('data-name');
                value = td.children(0).attr('data-value');
                td.html(value)
            }
            if(td.hasClass('td_operation')){
                html = '<button class="layui-btn layui-btn-small" onclick="editNode(this);">编辑</button>';
                td.html(html);
            }
        });
    }else{
        $.each(tds,function (index,data) {
            td = $(data);
            if(td.hasClass('td_edit')){
                name = td.attr('data-name');
                value = td.children(0).val();
                td.html(value)
            }
            if(td.hasClass('td_operation')){
                html = '<button class="layui-btn layui-btn-small" onclick="editNode(this);">编辑</button>';
                td.html(html);
            }
        });
    }

}

function updateNode(obj) {
    var tds = $(obj).parent().parent().children();
    var param = {};
    var value ;
    $.each(tds,function (index,data) {
        var td   = $(data);
        var name = td.attr("data-name");
        if(name!==undefined){
            if(index===1){
                value = td.html();
            }else{
                value = td.children(0).val();
            }
            param[name] = value;
        }
    });
    var url = "{:url('system/menu/updateMenu')}";
    postSomething(url,param,false);
    editNode(obj,1);
}

function updateMenu(param) {
    var update_url = '{:url("system/menu/updateMenu")}';
    postSomething(update_url,param);
}