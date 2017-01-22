/**
 * Created by LuSonghua on 2017/1/22.
 */
/*
* layer消息弹框,1s后自动关闭
*/
function showMessage(msg) {
    layui.use('layer',function () {
        layui.layer.open({
            type:0,
            content:msg,
            time:1000
        });
    });
}