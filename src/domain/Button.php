<?php

namespace Elxdigital\CtaButton\Domain;

class Button
{
    private object $button_cta;

    public function __construct(object $button)
    {
        $this->button_cta = $button;
    }

    public function getFunction(array $arrayBtnClasses, bool $span, array $arraySpanClasses, string $content_before, string $content_after, bool $translate): string
    {
        $funcao = $this->getTipoCta();
        $btn_title = $this->getBtnTitulo();

        if (!empty($arrayBtnClasses["class"])) {
            $arrayBtnClasses["class"] .= " btn-border";
        } else {
            $arrayBtnClasses["class"] = "btn-border";
        }

        if ($funcao == 'lead_whatsapp' || $funcao == 'lead') {
            $arrayBtnClasses["class"] .= " open-modal-button-cta";
        }

        $arrayBtnClasses["class"] .= " button-cta-clicked";

        $attr_str = implode(' ', array_map(
            fn($k, $v) => "$k='$v'",
            array_keys($arrayBtnClasses),
            $arrayBtnClasses
        ));

        $span_attr = implode(' ', array_map(
            fn($k, $v) => "$k='$v'",
            array_keys($arraySpanClasses),
            $arraySpanClasses
        ));

        if ($funcao == 'lead_whatsapp' || $funcao == 'whatsapp') {
            $titulo = $btn_title;
            $newTitulo = "<i class='fa-brands fa-whatsapp'></i>&nbsp;{$titulo}";
            $this->setBtnTitulo($newTitulo);
        }

        $content_str = $span ? "<span {$span_attr}>{$btn_title}</span>" : $btn_title;
        $identificador = $this->getBtnIdentificador();
        $urlBase = !$translate ? getFullUrl() : urlComTraducao();

        switch ($funcao) {
            case "lead_whatsapp":
            case "lead":
                $html = "<a href='#form-{$identificador}' {$attr_str} data-url='{$urlBase}' data-identificador='{$identificador}'>{$content_before}{$content_str}{$content_after}</a>";

                break;
            case "whatsapp":
                $contatoWpp = $this->getContatoWpp();
                $msg = $this->getMessageWpp();
                $msgWpp = !empty($msg) ? ("&text={$msg}") : "";

                $html = "<a href='https://api.whatsapp.com/send/?phone=55{$contatoWpp}{$msgWpp}' target='_blank' {$attr_str} data-url='{$urlBase}' data-identificador='{$identificador}'>{$content_before}{$content_str}{$content_after}</a>";

                break;
            case "externo":
                $target_blank = openOnNewWindow($this->getLinkRedir()) ? "target='_blank'" : "";
                $url_redirect = seeFullUrl($this->getLinkRedir(), $translate);

                $html = "<a href='{$url_redirect}' {$target_blank} {$attr_str} data-url='{$urlBase}' data-identificador='{$identificador}'>{$content_before}{$content_str}{$content_after}</a>";

                break;
            default:
                $html = "";

                break;
        }

        return $html;
    }

    public function getTipoCta(): string
    {
        return $this->button_cta->tipo_cta;
    }

    public function getBtnIdentificador(): string
    {
        return $this->button_cta->btn_identificador;
    }

    public function getBtnTitulo(): string
    {
        return $this->button_cta->btn_titulo;
    }

    public function setBtnTitulo(string $btn_titulo): void
    {
        $this->button_cta->btn_titulo = $btn_titulo;
    }

    public function getContatoWpp(): string
    {
        return $this->button_cta->contato_wpp;
    }

    public function getLinkRedir(): string
    {
        return $this->button_cta->link_redir;
    }

    public function getMessageWpp()
    {
        return $this->button_cta->message_wpp;
    }
}
