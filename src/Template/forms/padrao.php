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

    <button type="button" class="btn btn-default btn-success btn-send-form-cta-button">
        <span>
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.72.45 3.4 1.3 4.88L2.05 22l5.36-1.41a9.9 9.9 0 0 0 4.63 1.18h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2zm0 18.1h-.01c-1.44 0-2.86-.39-4.09-1.12l-.29-.17-3.18.84.85-3.1-.19-.32a8.15 8.15 0 0 1-1.25-4.32c0-4.5 3.67-8.16 8.17-8.16 2.18 0 4.23.85 5.77 2.4a8.1 8.1 0 0 1 2.39 5.77c0 4.5-3.67 8.18-8.17 8.18zm4.48-6.12c-.25-.12-1.45-.71-1.67-.8-.22-.08-.39-.12-.55.13-.16.24-.63.79-.78.96-.14.16-.29.18-.53.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42-.14-.01-.31-.01-.47-.01-.16 0-.43.06-.65.31-.22.25-.86.84-.86 2.04 0 1.2.88 2.36 1 2.52.12.16 1.72 2.63 4.17 3.69.58.25 1.04.4 1.39.51.58.19 1.11.16 1.53.1.47-.07 1.45-.59 1.65-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.47-.28z"/></svg>
            </div>
            CONVERSAR
        </span>
    </button>
</form>
