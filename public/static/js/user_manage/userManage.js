/**
 * Created by LuSonghua on 2017/1/21.
 */
/*页面加载完执行
 */
$(function () {
   layui.use(['form','laypage'],function () {
       layui.form();
       layui.laypage({
           cont:'mypage',
           pages:$('input#pageCount').val(),
           groups:5,
           curr:$('input#currPage').val(),
           jump: function(e, first){ //触发分页后的回调
               if(!first){ //一定要加此判断，否则初始时会无限刷新
                   location.href = '?page='+e.curr;
               }
           }
       });
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
// 根据查询条件，查询用户
function searchUser() {
    $.post('searchUser',{
        'username':$('div.search-form input[name="username"]').val(),
        'name':$('div.search-form input[name="name"]').val(),
        'phone':$('div.search-form input[name="phone"]').val(),
        'type':$('div.search-form select[name="type"]').val()
    },function (data) {
        $('div.table-users').html(data);
    });

}
//停用 用户
function closeUser(val) {
    layui.use('layer',function () {
        var layer = layui.layer;
        index = layer.open({
            title:['提示信息','text-align:center'],
            btn:['确认','取消'],
            btnAlign:'c',
            content:'确认停用该用户?',
            yes:function () {
                $.post('closeUser',{
                    'userid':val
                },function (data) {
                    layer.close(index);
                    showMessage(data['message']);
                })
            }
        });
    })
}
// 修改用户
function editUser(val) {
    var userMsg = $('tr[userid="'+ val + '"]');
    $('#edit-layer input[name="username"]').val(userMsg.find('td[name="username"]').html());
    $('#edit-layer input[name="name"]').val(userMsg.find('td[name="name"]').html());
    $('#edit-layer input[name="phone"]').val(userMsg.find('td[name="phone"]').html());
    $('#edit-layer input[name="email"]').val(userMsg.find('td[name="email"]').html());
    var userType = userMsg.find('td[name="type"]').html();
    $("#edit-layer select option").each(function(){
        if($(this).text()==userType)
        {
            $(this).attr("selected",true);
        }
    });
    layui.use(['layer','form'],function () {
       var layer = layui.layer;
        var form = layui.form();
        form.render();
        index = layer.open({
            type:1,
           title:['修改用户','text-align:center'],
            btn:['修改','取消'],
            btnAlign:'c',
            content:$('div#edit-layer'),
            yes:function () {
                $.post('editUser',{
                    'userid':val,
                    'name':$('#edit-layer input[name="name"]').val(),
                    'phone':$('#edit-layer input[name="phone"]').val(),
                    'email':$('#edit-layer input[name="email"]').val(),
                    'type':$('#edit-layer select[name="type"]').val()
                },function (data) {
                    layer.close(index);
                    showMessage(data['message']);
                });
            }
        });
    });
}

