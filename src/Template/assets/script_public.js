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

$(document).on('click', ".btn-send-form-cta-button", function (e) {
    e.preventDefault();

    var load = $(".ajax_load");
    var form = $(this).closest("form.cta-button-form-lead-wpp");

    var newTab = window.open('', '_blank');

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
                    if (newTab) {
                        newTab.location = response.redirect;
                    } else {
                        window.open(response.redirect, '_blank');
                    }
                } else {
                    if (newTab) newTab.close();
                    window.location.href = response.redirect;
                }
            } else {
                if (newTab) newTab.close();
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
            if (newTab) newTab.close();
            ajaxMessage(ajaxResponseRequestError, 5);
        }
    });
});

$(document).on('click', ".button-cta-clicked", function () {
    let urlBase = $(this).data('url');
    let identificador = $(this).data('identificador');

    $.post(urlBase + '/src/routes/index.php?route=button/click/save', {btn_identificador: identificador});
});
