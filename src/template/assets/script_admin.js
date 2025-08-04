$(document).ready(function () {
    $('.telefone').mask('(00) 00000-0000');

    let lastSubmitButton = null;
    $(document).on('click', 'button[type=submit], input[type=submit], button:not([type])', function (e) {
        lastSubmitButton = this;
    });

    $('form').on('submit', function () {
        if (lastSubmitButton && lastSubmitButton.id !== 'btn_save_btn_cta') {
            $('#btn_form :input').prop('disabled', true);

            setTimeout(function () {
                $('#btn_form :input').prop('disabled', false);
            }, 500);
        }

        lastSubmitButton = null;
    });
});

$(document).ready(function () {
    let tipo_cta_selecionado = $("#tipo_cta").val();

    switch (tipo_cta_selecionado) {
        case 'lead_whatsapp':
            // esconde e remove valor de campos que não são iniciados
            $("#form_lead").val("padrao_wpp").trigger('change');
            $("#form_lead_div").hide();

            $("#link_redir").val("");
            $("#link_redir_div").hide();

            break;
        case 'lead':
            // esconde e remove valor de campos que não são iniciados
            $("#contato_wpp").val("");
            $("#contato_wpp_div").hide();

            $("#message_wpp").val("");
            $("#message_wpp_div").hide();

            $("#link_redir").val("");
            $("#link_redir_div").hide();

            break;
        case 'whatsapp':
            // esconde e remove valor de campos que não são iniciados
            $("#form_lead").val(" ").trigger('change');
            $("#form_lead_div").hide();

            $("#link_redir").val("");
            $("#link_redir_div").hide();

            break;
        case 'externo':
            // esconde e remove valor de campos que não são iniciados
            $("#form_lead").val(" ").trigger('change');
            $("#form_lead_div").hide();

            $("#contato_wpp").val("");
            $("#contato_wpp_div").hide();

            $("#message_wpp").val("");
            $("#message_wpp_div").hide();

            break;
        default:
            $("#form_lead_div").hide();
            $("#form_lead").val(" ").trigger('change');

            $("#contato_wpp_div").hide();
            $("#contato_wpp").val("");

            $("#message_wpp").val("");
            $("#message_wpp_div").hide();

            $("#link_redir_div").hide();
            $("#link_redir").val("");
    }

    $("#tipo_cta").on('change', function () {
        let selecionado = $(this).val();

        switch (selecionado) {
            case 'lead_whatsapp':
                // mostrar campos necessários
                $("#contato_wpp_div").show();
                $("#message_wpp_div").show();

                // esconde e remove valor de campos que não são iniciados
                $("#form_lead").val("padrao_wpp").trigger('change');
                $("#form_lead_div").hide();

                $("#link_redir").val("");
                $("#link_redir_div").hide();

                break;
            case 'lead':
                // mostrar campos necessários
                $("#form_lead_div").show();

                // esconde e remove value de campos desnecessários
                $("#contato_wpp").val("");
                $("#contato_wpp_div").hide();

                $("#message_wpp").val("");
                $("#message_wpp_div").hide();

                $("#link_redir").val("");
                $("#link_redir_div").hide();

                break;
            case 'whatsapp':
                // mostrar campos necessários
                $("#contato_wpp_div").show();
                $("#message_wpp_div").show();

                // esconde e remove value de campos desnecessários
                $("#form_lead").val(" ").trigger('change');
                $("#form_lead_div").hide();

                $("#link_redir").val("");
                $("#link_redir_div").hide();

                break;
            case 'externo':
                // mostrar campos necessários
                $("#link_redir_div").show();

                // esconde e remove value de campos desnecessários
                $("#form_lead").val(" ").trigger('change');
                $("#form_lead_div").hide();

                $("#contato_wpp").val("");
                $("#contato_wpp_div").hide();

                $("#message_wpp").val("");
                $("#message_wpp_div").hide();

                break;
            default:
                // action default
                $("#form_lead").val(" ").trigger('change');
                $("#form_lead_div").hide();

                $("#contato_wpp").val("");
                $("#contato_wpp_div").hide();

                $("#message_wpp").val("");
                $("#message_wpp_div").hide();

                $("#link_redir").val("");
                $("#link_redir_div").hide();
        }
    });

    $("#btn_save_btn_cta").on('click', function () {
        var dadosFilho = {};

        $('#btn_form :input').each(function() {
            if ($(this).is(':button, [type="button"], [type="submit"], [type="reset"]')) return;

            dadosFilho[$(this).attr('name')] = $(this).val();
        });

        var origin = window.location.origin;
        var path = window.location.pathname.split('/').filter(Boolean)[0];
        var baseUrl = origin + '/' + path;

        $.post(baseUrl + '/src/routes/index.php?route=button/save', dadosFilho)
            .done(function(resposta) {
                let resp = JSON.parse(resposta);

                if (resp.code !== 200) {
                    console.log(resp);
                    alert(resp.message);
                    return;
                }

                $("#btn_cta_id").val(resp.saveCode);
            })
            .fail(function() {
                alert('Erro ao enviar!');
            });
    });
});
