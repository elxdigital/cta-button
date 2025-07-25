<?php
/**
 * @var string $field_name
 * @var string $btn_identificador
 * @var object|null $btn_conversao
 * @var array $tipos_conversao
 * @var array $formularios
 */

$script_path = getFullUrl("src/template/assets/script_admin.js");
?>
<script rel="text/javascript" src="<?= $script_path ?>" defer></script>

<div id="btn_form">
    <div class="card mb-4">
        <div class="card-body">
            <div class="col-lg-12">
                <h5 class='mb-4'>Botão de CTA</h5>

                <?php if (!empty($btn_conversao)): ?>
                    <input type="hidden" name="id" id="id" value="<?= $btn_conversao->id ?>">
                <?php endif; ?>

                <input type="hidden" name="btn_identificador" id="btn_identificador" value="<?= $btn_identificador ?>">

                <div class="form-group has-float-label">
                    <label for="btn_titulo">Título do Botão</label>
                    <input type="text" class="form-control" id="btn_titulo" name="btn_titulo"
                           value="<?= !empty($btn_conversao?->btn_titulo) ? $btn_conversao->btn_titulo : null ?>">
                </div>

                <label class="form-group has-float-label mt-3" style="display: block;">
                    <select name="tipo_cta" id="tipo_cta" class="form-control select2-single">
                        <option value=" ">Selecione um Tipo de Conversão</option>

                        <?php foreach ($tipos_conversao as $tipo => $conv): ?>
                            <option value="<?= $tipo ?>" <?= (!empty($btn_conversao?->tipo_cta) && $btn_conversao->tipo_cta == $tipo ? 'selected' : '') ?>><?= $conv ?></option>
                        <?php endforeach; ?>
                    </select>

                    <span>Tipo de CTA</span>
                </label>

                <!-- --------------------------------------------------------------------- -->
                <!-- campos condicionais -->

                <label class="form-group has-float-label mt-3" style="display: block;" id="form_lead_div">
                    <select name="form_lead" id="form_lead" class="form-control select2-single">
                        <option value=" ">Selecione um Formulário para Conversão</option>

                        <?php foreach ($formularios as $tipo_form => $formulario): ?>
                            <option value="<?= $tipo_form ?>" <?= (!empty($btn_conversao?->form_lead) && $btn_conversao->form_lead == $tipo_form ? 'selected' : '') ?>><?= $formulario ?></option>
                        <?php endforeach; ?>
                    </select>

                    <span>Formulário para Conversão de Lead</span>
                </label>

                <div class="form-group has-float-label" id="contato_wpp_div">
                    <label for="contato_wpp">Número do WhatsApp</label>
                    <input type="text" class="form-control telefone" id="contato_wpp" name="contato_wpp"
                           value="<?= !empty($btn_conversao?->contato_wpp) ? $btn_conversao->contato_wpp : null ?>">
                    <p class="text-muted">Número de telefone com DDD. Ex: (51) 99999-9999</p>
                </div>

                <div class="form-group has-float-label" id="link_redir_div">
                    <label for="link_redir">Link de Redirecionamento</label>
                    <input type="text" class="form-control" id="link_redir" name="link_redir"
                           value="<?= !empty($btn_conversao?->link_redir) ? $btn_conversao->link_redir : null ?>">
                </div>

                <!-- end campos condicionais -->
                <!-- --------------------------------------------------------------------- -->
            </div>

            <button type="button" id="btn btn-success mb-1 btn_save_btn_cta">Salvar Botão</button>
        </div>
    </div>
</div>

<input type="hidden" name="<?= $field_name ?>" id="btn_cta_id" value="<?= !empty($btn_conversao) ? $btn_conversao->id : '' ?>">
<br>
