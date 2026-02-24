<?php

namespace ElxDigital\CtaButton\Examples\Controller;

class PublicController
{
    private \Elxdigital\CtaButton\View\View $view;
    private string $view_path = __DIR__ . "/../templates/";

    public function __construct()
    {
        $this->view = new \ElxDigital\CtaButton\View\View($this->view_path);
    }

    public function public(): void
    {
        /**
         * MOCK DE DADOS, PASSE O ID NECESSÁRIO QUE DESEJA CARREGAR NA TELA
         */
        $btn_id = 11;

        /**
         * IMPORTANTE PASSAR O CAMINHO DAS VIEWS DO SISTEMA QUE USARÁ ESTE BOTÃO
         */
        $button = new \ElxDigital\CtaButton\Button($this->view_path);

        echo $this->view->render("public_use", [
            "btn_id" => $btn_id,
            "button" => $button,
        ]);
    }

    public function private(): void
    {
        $button = new \ElxDigital\CtaButton\Button();

        /**
         * MOCK DE DADOS PARA TESTES
         * PARA ALTERNAR ENTRE TESTES COM OU SEM BOTÃO JÁ CADASTRADO, COMENTE OU DESCOMENTE A VARIÁVEL $data ABAIXO
         */

//        $data = null;
        $data = (object) ['btn_cta' => 11];
        $forms = ["contato" => "Formulário de Contato", "curriculo" => "Formulário de Currículo", "modal" => "Formulário de Modal"];

        echo $this->view->render("admin_use", [
            "button" => $button,
            "data" => $data,
            "forms" => $forms,
        ]);
    }
}
