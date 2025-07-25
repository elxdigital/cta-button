<?php

namespace Elxdigital\CtaButton\Domain;

class Button
{
    private object $button_cta;

    public function __construct(object $button)
    {
        $this->button_cta = $button;
    }

    public function getFunction(): string
    {
        $funcao = $this->getTipoCta();

        switch ($funcao) {
            case "lead":
                $html = "<a href='#form-" . $this->getBtnIdentificador() . "' class='btn-border open-modal-button-cta'>" . $this->getBtnTitulo() . "</a>";

                break;
            case "whatsapp":
                $html = "<a href='https://api.whatsapp.com/send/?phone=55" . $this->getContatoWpp() . "' target='_blank'>" . $this->getBtnTitulo() . "</a>";

                break;
            case "externo":
                $target_blank = openOnNewWindow($this->getLinkRedir()) ? "target='_blank'" : "";
                $url_redirect = seeFullUrl($this->getLinkRedir());
                $html = "<a href='{$url_redirect}' {$target_blank}>" . $this->getBtnTitulo() . "</a>";

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

    public function getFormLead(): string
    {
        return $this->button_cta->form_lead;
    }

    public function getContatoWpp(): string
    {
        return $this->button_cta->contato_wpp;
    }

    public function getLinkRedir(): string
    {
        return $this->button_cta->link_redir;
    }

    public function getCliques(): int
    {
        return $this->button_cta->cliques;
    }
}
