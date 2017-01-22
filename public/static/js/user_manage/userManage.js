/**
 * Created by LuSonghua on 2017/1/21.
 */
/*页面加载完执行
 */
$(function () {
   layui.use('form',function () {
       layui.form();
   })
});
//添加用户
function addUser() {
    layui.use('layer',function () {
        var layer = layui.layer;
        index = layer.open({
            type:1,
            title:['新增用户','text-align:center'],
            btn:['提交','取消'],
            btnAlign:'c',
            content:$('div#add-layer'),
            yes:function () {
                $.post('addUser',{
                    'username':$('div#add-layer input[name="username"]').val(),
                    'password':$('div#add-layer input[name="password"]').val(),
                    'name':$('div#add-layer input[name="name"]').val(),
                    'phone':$('div#add-layer input[name="phone"]').val(),
                    'email':$('div#add-layer input[name="email"]').val(),
                    'type':$('div#add-layer select[name="type"]').val()
                },function (data) {
                    layer.close(index);
                    showMessage(data['message']);
                })
            }
        });
    });

}
