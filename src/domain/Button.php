<?php

namespace Elxdigital\CtaButton\Domain;

class Button
{
    private object $button_cta;

    public function __construct(object $button)
    {
        $this->button_cta = $button;
    }

    public function getFunction(array $arrayClasses, bool $span): string
    {
        $funcao = $this->getTipoCta();

        if (!empty($arrayClasses["class"])) {
            $arrayClasses["class"] .= " btn-border";
        } else {
            $arrayClasses["class"] = "btn-border";
        }

        if ($funcao == 'lead_whatsapp' || $funcao == 'lead') {
            $arrayClasses["class"] .= " open-modal-button-cta";
        }

        $attr_str = implode(' ', array_map(
            fn($k, $v) => "$k='$v'",
            array_keys($arrayClasses),
            $arrayClasses
        ));

        if ($funcao == 'lead_whatsapp' || $funcao == 'whatsapp') {
            $titulo = $this->getBtnTitulo();
            $newTitulo = "<i class='fa-brands fa-whatsapp'></i> {$titulo}";
            $this->setBtnTitulo($newTitulo);
        }

        $content_str = $span ? "<span>" . $this->getBtnTitulo() . "</span>" : $this->getBtnTitulo();

        switch ($funcao) {
            case 'lead_whatsapp':
                $identificador = $this->getBtnIdentificador();

                $html = "<a href='#form-{$identificador}' {$attr_str}>{$content_str}</a>";

                break;
            case "lead":
                $identificador = $this->getBtnIdentificador();

                $html = "<a href='#form-{$identificador}' {$attr_str}>{$content_str}</a>";

                break;
            case "whatsapp":
                $contatoWpp = $this->getContatoWpp();
                $msg = $this->getMessageWpp();
                $msgWpp = !empty($msg) ? ("&text={$msg}") : "";

                $html = "<a href='https://api.whatsapp.com/send/?phone=55{$contatoWpp}{$msgWpp}' target='_blank' {$attr_str}>{$content_str}</a>";

                break;
            case "externo":
                $target_blank = openOnNewWindow($this->getLinkRedir()) ? "target='_blank'" : "";
                $url_redirect = seeFullUrl($this->getLinkRedir());

                $html = "<a href='{$url_redirect}' {$target_blank} {$attr_str}>{$content_str}</a>";

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
