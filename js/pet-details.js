$(document).ready(function () {
    var xmlhttp;

    if(youtube_link !== ''){
        $('#watch-video').click(function () {
        var src = youtube_link.replace("watch?v=", "v/");
        src += "&autoplay=1";
        $('#video-modal').modal('show');
        $('#video-modal iframe').attr('src', src);
        $('#video-modal iframe').attr('frameborder', '0');
        });

        } else{
        $('#watch-video').html("No Video Available");
        $("#watch-video").removeAttr("href");
        }

    $('#video-modal').on('hidden.bs.modal', function () {
        $('#video-modal iframe').removeAttr('src');
    });

    $('#adopt-me').click(function (e) {
        if (g_signed) {
            $('#adopt-modal').modal('show');
        } else {
            $('#login-modal').modal('show');
        }
        e.preventDefault();
    });

    var request;
    $('#adopt-form').submit(function (e) {
        //alert("doesn't work yet");
        if (request) {
            request.abort();
        }

        var cur_url = window.location.href;
        var pet_id = cur_url.substr(cur_url.lastIndexOf("=") + 1);
        if (pet_id.lastIndexOf('#') != -1) {
            pet_id = pet_id.substr(0, pet_id.lastIndexOf('#'));
        }

        var $form = $(this);
        var $inputs = $form.find("input, select, button, textarea");

        var postData = {
            "mail_subject" : $inputs[1].value == "" ? $inputs[1].placeholder : $inputs[1].value,
            "mail_to" : "demiwangya@gmail.com",
            "mail_from" : $inputs[0].value,
            "mail_msg" : $inputs[2].value == "" ? $inputs[2].placeholder : $inputs[2].value,
            "mail_pet_id" : pet_id
        };

        request = $.ajax({
            url: "utils/mail.php",
            type: "post",
            data: postData
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);
            $('#adopt-modal').modal('hide');
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
        e.preventDefault();
    });

    function loadXMLDoc(url,cfunc){
        if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=cfunc;
        xmlhttp.open("POST",url,true);
        xmlhttp.send();
    }

    $('#fav_button1').click(function (e) {
        var cur_url = window.location.href;
        var pet_id = cur_url.substr(cur_url.lastIndexOf("=") + 1);
        loadXMLDoc("utils/addfav.php?user_id="+user_id+"&pet_id="+pet_id+"&b="+1,function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("fav_button1").innerHTML=xmlhttp.responseText;
            }
        });

        e.preventDefault();
    });

    $('#fav_button2').click(function (e) {
        var cur_url = window.location.href;
        var pet_id = cur_url.substr(cur_url.lastIndexOf("=") + 1);
        loadXMLDoc("utils/addfav.php?user_id="+user_id+"&pet_id="+pet_id+"&b="+2,function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("fav_button2").innerHTML=xmlhttp.responseText;
            }
        });

        e.preventDefault();
    });

});