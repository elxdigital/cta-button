<?php

namespace Elxdigital\CtaButton\Domain;

class Contato
{
    public function email(array $data): void
    {
        if (empty($data['nome'])) {
            $json["message"] = (new \Elxdigital\CtaButton\Domain\Message())->error("Você precisa preencher o campo nome para continuar!")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['telefone'])) {
            $json["message"] = (new \Elxdigital\CtaButton\Domain\Message())->error("Você precisa preencher o campo telefone para continuar!")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['email'])) {
            $json["message"] = (new \Elxdigital\CtaButton\Domain\Message())->error("Você precisa preencher o campo e-mail para continuar!")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['btn_id'])) {
            $json["message"] = (new \Elxdigital\CtaButton\Domain\Message())->error("Você precisa identificar o botão para continuar!")->render();
            echo json_encode($json);
            return;
        }

        $data['nome'] = ucwords(mb_strtolower(trim($data['nome']), 'UTF-8'));
        $data['telefone'] = trim(get_str_phone($data['telefone']));
        $data['email'] = mb_strtolower(trim($data['email']), 'UTF-8');
        $data['btn_id'] = filter_var($data["btn_id"], FILTER_VALIDATE_INT);

        $mensagem = "
            NOME: {$data['nome']}<br>
            E-MAIL: {$data['email']}<br>
            TELEFONE: {$data['telefone']}
        ";

        $view = new \Elxdigital\CtaButton\View\View(__DIR__ . "/../template/shared/views");
        $subject = "[ LEAD DO SITE ] Novo lead clicou em um botão !";

        $body = $view->render("email", [
            "titulo" => "{$data['nome']} se interessou em entrar em contato e preencheu o formulário de lead.",
            "mensagem" => $mensagem
        ]);

        $email = new \Elxdigital\CtaButton\Domain\Email();
        $email->bootstrap(
            $subject,
            $body,
            \CONF_MAIL_SENDER['address'],
            \CONF_MAIL_SENDER["name"]
        )->send($data['email'], $data['nome']);

        $model = new \Elxdigital\CtaButton\Model\Button();
        $btn_conversao = $model->get($data['btn_id']);

        $model->addClique($data['btn_id']);

        $contatoWpp = $btn_conversao->contato_wpp;
        $msg = $btn_conversao->message_wpp;
        $msgWpp = !empty($msg) ? ("&text={$msg}") : "";

        $json["redirect"] = "https://api.whatsapp.com/send/?phone=55{$contatoWpp}{$msgWpp}";
        $json["target_blank"] = true;
        $json["reload"] = true;
        echo json_encode($json);
        return;
    }
}
