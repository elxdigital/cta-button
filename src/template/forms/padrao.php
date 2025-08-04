<?php
/**
 * @var string $modalId
 * @var string $modalTitle
 * @var int $btn_id
 */
?>

<form class="cta-button-form-lead-wpp" name="<?= $modalId ?>" action="<?= getFullUrl('src/routes/index.php?route=forms/padrao/enviar') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="btn_id" value="<?= $btn_id ?>">

    <div class="form-group">
        <span class="field-title">NOME</span>
        <input type="text" name="nome" required>
    </div>

    <div class="form-group">
        <span class="field-title">TELEFONE</span>
        <input type="tel" class="telefone" name="telefone" required>
    </div>

    <div class="form-group">
        <span class="field-title">E-MAIL</span>
        <input type="email" name="email" required>
    </div>

    <button type="submit" class="btn btn-default">
        <span><i class='fa-brands fa-whatsapp'></i> CONVERSAR</span>
    </button>
</form>
