$(document).ready(function () {
    $('.telefone').mask('(00) 00000-0000');

    //MODAL
    $('.open-modal-button-cta').on('click', function(e) {
        e.preventDefault();
        var modalSelector = $(this).attr('href');

        $('#modalOverlay').fadeIn(200);
        $(modalSelector).fadeIn(200);
    });

    $(".open-modal-button-cta").click(function(){
        var thisModal = $(this).attr("href");
        $(thisModal).fadeIn(200);
        return false;
    });

    $(".close-modal, .overlay-modal").click(function(){
        $(".wrap-modal").fadeOut(200);
        return false
    });

    $(window).scroll(function(){
        if($(this).scrollTop() >= $("header .top-bar").innerHeight()){
            $("body").addClass("fixHeader");
        } else {
            $("body").removeClass("fixHeader");
        }
    });
});

$("form[class='cta-button-form-lead-wpp']").submit(function (e) {
    e.preventDefault();
    alert('disparado');

    var form = $(this);
    var flashClass = "ajax_response";
    var flash = $("." + flashClass);

    form.ajaxSubmit({
        url: form.attr("action"),
        type: "POST",
        dataType: "json",
        success: function (response) {
            //redirect
            if (response.redirect) {
                if (response.target_blank) {
                    window.open(response.redirect, '_blank');
                } else {
                    window.location.href = response.redirect;
                }
            } else {
                form.find("input[type='file']").val(null);
            }

            //reload
            if (response.reload) {
                window.location.reload();
            }

            //message
            if (response.message) {
                ajaxMessage(response.message, ajaxResponseBaseTime);
            }

            if (response.messagedesk) {
                if (flash.length) {
                    flash.html(response.messagedesk).fadeIn(100).effect("bounce", 300);
                } else {
                    form.prepend("<div class='" + flashClass + "'>" + response.messagedesk + "</div>")
                        .find("." + flashClass).effect("bounce", 300);
                }
            }

            //text
            if (response.html) {
                $('.' + response.html[0]).html(response.html[1]);
            }

            //text
            if (response.html2) {
                $('.' + response.html2[0]).html(response.html2[1]);
            }

            if (response.chat) {
                var list = "";
                var chatAppScroll;

                $.each(response.chat, function (item, data) {
                    list += mensageHtmlUsuario(data.foto, data.nome, data.hora, data.mensagem, data.class);
                });

                $(".mensagens").html(list);
                $(".j_mensagem").val("");

                $(".scroll").each(function () {
                    if ($(this).parents(".chat-app").length > 0) {
                        chatAppScroll = new PerfectScrollbar($(this)[0]);
                        $(".chat-app .scroll").scrollTop(
                            $(".chat-app .scroll").prop("scrollHeight")
                        );
                        chatAppScroll.update();
                        return;
                    }
                    var ps = new PerfectScrollbar($(this)[0]);
                });
            }

            //image by fsphp mce upload
            if (response.mce_image) {
                $('.mce_upload').fadeOut(200);
                tinyMCE.activeEditor.insertContent(response.mce_image);
            }
        },
        complete: function () {
            if (form.data("reset") === true) {
                form.trigger("reset");
            }
        },
        error: function () {
            ajaxMessage(ajaxResponseRequestError, 5);
        }
    });
});
