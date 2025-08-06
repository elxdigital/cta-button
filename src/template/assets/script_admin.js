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
    $(".select_tipo_cta").each(function (index, element) {
        let tipo_cta_selecionado = $(this).val();
        let identificador = $(this).data("ident");

        if (identificador == undefined) {
            return true;
        }

        switch (tipo_cta_selecionado) {
            case 'lead_whatsapp':
                // esconde e remove valor de campos que não são iniciados
                $("#form_lead_" + identificador).val("padrao").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();

                break;
            case 'lead':
                // esconde e remove valor de campos que não são iniciados
                $("#contato_wpp_" + identificador).val("");
                $("#contato_wpp_div_" + identificador).hide();

                $("#message_wpp_" + identificador).val("");
                $("#message_wpp_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();

                break;
            case 'whatsapp':
                // esconde e remove valor de campos que não são iniciados
                $("#form_lead_" + identificador).val(" ").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();

                break;
            case 'externo':
                // esconde e remove valor de campos que não são iniciados
                $("#form_lead_" + identificador).val(" ").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#contato_wpp_" + identificador).val("");
                $("#contato_wpp_div_" + identificador).hide();

                $("#message_wpp_" + identificador).val("");
                $("#message_wpp_div_" + identificador).hide();

                break;
            default:
                $("#form_lead_div_" + identificador).hide();
                $("#form_lead_" + identificador).val(" ").trigger('change');

                $("#contato_wpp_div_" + identificador).hide();
                $("#contato_wpp_" + identificador).val("");

                $("#message_wpp_" + identificador).val("");
                $("#message_wpp_div_" + identificador).hide();

                $("#link_redir_div_" + identificador).hide();
                $("#link_redir_" + identificador).val("");
        }
    });

    $(".select_tipo_cta").on('change', function () {
        let selecionado = $(this).val();
        let identificador = $(this).data("ident");

        switch (selecionado) {
            case 'lead_whatsapp':
                // mostrar campos necessários
                $("#contato_wpp_div_" + identificador).show();
                $("#message_wpp_div_" + identificador).show();

                // esconde e remove valor de campos que não são iniciados
                $("#form_lead_" + identificador).val("padrao").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();

                break;
            case 'lead':
                // mostrar campos necessários
                $("#form_lead_div_" + identificador).show();

                // esconde e remove value de campos desnecessários
                $("#contato_wpp_" + identificador).val("");
                $("#contato_wpp_div_" + identificador).hide();

                $("#message_wpp_" + identificador).val("");
                $("#message_wpp_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();

                break;
            case 'whatsapp':
                // mostrar campos necessários
                $("#contato_wpp_div_" + identificador).show();
                $("#message_wpp_div_" + identificador).show();

                // esconde e remove value de campos desnecessários
                $("#form_lead_" + identificador).val(" ").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();

                break;
            case 'externo':
                // mostrar campos necessários
                $("#link_redir_div_" + identificador).show();

                // esconde e remove value de campos desnecessários
                $("#form_lead_" + identificador).val(" ").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#contato_wpp_" + identificador).val("");
                $("#contato_wpp_div_" + identificador).hide();

                $("#message_wpp_" + identificador).val("");
                $("#message_wpp_div_" + identificador).hide();

                break;
            default:
                // action default
                $("#form_lead_" + identificador).val(" ").trigger('change');
                $("#form_lead_div_" + identificador).hide();

                $("#contato_wpp_" + identificador).val("");
                $("#contato_wpp_div_" + identificador).hide();

                $("#message_wpp_" + identificador).val("");
                $("#message_wpp_div_" + identificador).hide();

                $("#link_redir_" + identificador).val("");
                $("#link_redir_div_" + identificador).hide();
        }
    });

    $(".btn_save_btn_cta").on('click', function () {
        var dadosFilho = {};
        let identificadorBtn = $(this).data("ident");

        $('#btn_form_' + identificadorBtn + ' :input').each(function() {
            if ($(this).is(':button, [type="button"], [type="submit"], [type="reset"]')) return;

            dadosFilho[$(this).attr('name')] = $(this).val();
        });

        var origin = window.location.origin;

        $.post(origin + '/src/routes/index.php?route=button/save', dadosFilho)
            .done(function(resposta) {
                let resp = JSON.parse(resposta);

                if (resp.code !== 200) {
                    console.log(resp);
                    alert(resp.message);
                    return;
                }

                $("#btn_cta_id_" + identificadorBtn).val(resp.saveCode);
            })
            .fail(function() {
                alert('Erro ao enviar!');
            });
    });
});
