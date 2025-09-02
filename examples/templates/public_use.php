<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var \Elxdigital\CtaButton\Button $button
 * @var int $btn_id
 */

$this->layout("_template_view", [
    "title" => "Public Use - CTA Button",
]);
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-xl-6 align-self-center">
                <div class="box-text">
                    <h2><strong>Título</strong></h2>
                    <p>Descrição</p>
                    <div class="buttons">
                        <a href="https://google.com" class="btn-group">
                            <span class="text">Google</span>
                        </a>

                        <?php $button->renderPublic(
                            $btn_id,
                            [
                                "class" => "mb-4",
                            ],
                            true,
                            [
                                "class" => "text",
                            ],
                            "<span class='mb-2'>Span Antes</span>",
                            "<span class='mb-3'>Span Depois</span>"
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
