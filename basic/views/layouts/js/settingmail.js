/**
 * Created by 李洋 on 2015/7/7.
 */
$(document).ready(function(){
    $("#username").on('blur', function () {
        var username = $("#username").val();
        var password = $("#password").val();
        var userarr = username.split('@');
        var sendhost = "smtp."+userarr[1];
        var sendport = 25;
        var user = userarr[0];
        var receivehost;
        if(userarr[1]=="buaa.edu.cn")
            receivehost = "mail."+userarr[1];
        else
            receivehost = "imap."+userarr[1];
        var receiveport = 993;
        $("#sendhost").attr('value',sendhost);
        $("#sendport").attr('value',sendport);
        $("#receivehost").attr('value',receivehost);
        $("#receiveport").attr('value',receiveport);
        $("#user").attr('value',user);
    });
})