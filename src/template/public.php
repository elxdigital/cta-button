<?php
/**
 * @var \League\Plates\Template\Template $this
 * @var string $content_before
 * @var string $content_after
 * @var object $btn_conversao
 * @var array $arrayBtnClasses
 * @var array $arraySpanClasses
 * @var bool $translate
 * @var bool $hasModal
 * @var string $form
 * @var bool $span
 */

$button = new \ElxDigital\CtaButton\Domain\Button($btn_conversao);
echo $button->getFunction($arrayBtnClasses, $span, $arraySpanClasses, $content_before, $content_after, $translate);
?>

<?php if ($hasModal && !empty($form)): ?>
    <template id="cta-modal-tpl-<?= htmlspecialchars($button->getBtnIdentificador(), ENT_QUOTES) ?>">
        <div
                id="form-<?= htmlspecialchars($button->getBtnIdentificador(), ENT_QUOTES) ?>"
                class="modal-button-cta wrap-modal"
                data-cta-modal="1"
                aria-hidden="true"
                style="display:none"
        >
            <div class="overlay-modal"></div>
            <div class="box-modal">
                <button class="close-modal"><span class="material-symbols-outlined">X</span></button>
                <div class="box-title">
                    <h2><?= $button->getBtnTitulo() ?></h2>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <?= $form ?>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        (function(){
            var ident = <?= json_encode($button->getBtnIdentificador(), JSON_UNESCAPED_UNICODE) ?>;
            var tplId = "cta-modal-tpl-" + ident;
            var rootId = "cta-modals-root";

            function ensureRoot(){
                var r = document.getElementById(rootId);
                if(!r){
                    r = document.createElement("div");
                    r.id = rootId;
                    // opcional: z-index alto para escapar de contextos dos pais
                    r.style.position = "relative";
                    r.style.zIndex = "2147483647";
                    document.body.appendChild(r);
                }
                return r;
            }

            function mount(){
                try {
                    var tpl = document.getElementById(tplId);
                    if(!tpl) return;

                    // se já existe um modal com este ID em body, não duplica
                    if(document.getElementById("form-" + ident)) return;

                    var root = ensureRoot();
                    var node = null;

                    if (tpl.content && tpl.content.firstElementChild) {
                        node = tpl.content.firstElementChild.cloneNode(true);
                    } else {
                        // fallback para navegadores sem <template>.content
                        var tmp = document.createElement("div");
                        tmp.innerHTML = tpl.innerHTML;
                        node = tmp.firstElementChild;
                    }

                    if(node){
                        node.style.display = "";
                        root.appendChild(node);
                    }
                } catch(e) {
                    // falha silenciosa para não quebrar a página hospedeira
                    // console.warn("[CTA Button] mount modal failed:", e);
                }
            }

            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", mount);
            } else {
                mount();
            }
        })();
    </script>
<?php endif; ?>
