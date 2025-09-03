<?php

namespace Elxdigital\CtaButton;

require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/dep/set-variables.php";
require_once __DIR__ . "/../src/helper/string.php";
require_once __DIR__ . "/../src/helper/url.php";

class Button
{
    private array $tipos_conversao;
    private ?string $public_template_path;

    public function __construct(?string $template_path = null)
    {
        $this->public_template_path = $template_path;
        $this->tipos_conversao = [
            'lead_whatsapp' => 'Capturar Lead + Redirecionar para WhatsApp',
            'lead' => 'Capturar Lead',
            'whatsapp' => 'Direto por WhatsApp',
            'externo' => 'Link Externo'
        ];
    }

    /**
     * ######################
     * ### PUBLIC METHODS ###
     * ######################
     */

    public function renderPublic(int $btn_cta_id, ?array $btn_classes = [], ?bool $span = false, ?array $span_classes = [], ?string $content_before = "", ?string $content_after = "", ?bool $translate = false): void
    {
        $btn_id = filter_var($btn_cta_id, FILTER_VALIDATE_INT);
        $arrayBtnClasses = !empty($btn_classes) ? $btn_classes : [];
        $arraySpanClasses = !empty($span_classes) ? $span_classes : [];
        $templates_path = $this->getPublicTemplatePath();

        $controller = new \Elxdigital\CtaButton\Controller\ButtonController();
        $controller->render_public($btn_id, $arrayBtnClasses, $span, $templates_path, $arraySpanClasses, $content_before, $content_after, $translate);
    }

    public function renderPrivate(string $field_name, string $identificador, array $formularios, ?int $btn_cta_id = null): void
    {
        $btn_id = $btn_cta_id !== null ? filter_var($btn_cta_id, FILTER_VALIDATE_INT) : null;
        $tipos_conversao = $this->getTiposConversao();

        $controller = new \Elxdigital\CtaButton\Controller\ButtonController();
        $controller->render_admin($field_name, $identificador, $formularios, $btn_id, $tipos_conversao);
    }

    /**
     * #######################
     * ### PRIVATE METHODS ###
     * #######################
     */
    private function getPublicTemplatePath(): ?string
    {
        return $this->public_template_path;
    }

    private function getTiposConversao(): array
    {
        return $this->tipos_conversao;
    }
}
