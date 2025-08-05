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

$(".btn-send-form-cta-button").on('click', function (e) {
    e.preventDefault();

    var load = $(".ajax_load");
    var form = $(".cta-button-form-lead-wpp");

    form.ajaxSubmit({
        url: form.attr("action"),
        type: "POST",
        dataType: "json",
        beforeSend: function () {
            load.fadeIn(200).css("display", "flex");
        },
        uploadProgress: function (event, position, total, completed) {
            var loaded = completed;
            var load_title = $(".ajax_load_box_title");
            load_title.text("Enviando (" + loaded + "%)");

            if (completed >= 100) {
                load_title.text("Aguarde, carregando...");
            }
        },
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
                ajaxMessage(response.message, 5);
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
