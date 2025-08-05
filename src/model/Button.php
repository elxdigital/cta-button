<?php

namespace Elxdigital\CtaButton\Model;

use PDO;

class Button
{
    public function __construct()
    {
        set_time_limit(0);
    }

    public function get(int $btn_id): object
    {
        $conexao = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $conexao->connect();
        $banco_de_dados = $conexao->getConnection();

        $result = $banco_de_dados->prepare("SELECT * FROM `cta_button` WHERE id = :btn_id");
        $result->execute([
            ':btn_id' => $btn_id,
        ]);

        return (object) $result->fetch(PDO::FETCH_ASSOC);
    }

    public function save(array $data): bool|int
    {
        if (empty($data["btn_identificador"])) {
            $json = ["code" => 400, "message" => "Identificador do botão não informado! Garanta que você saiba qual botão está monitorando e tente novamente."];
            echo json_encode($json);
            return false;
        }

        if (empty($data["btn_titulo"])) {
            $json = ["code" => 400, "message" => "{$data['btn_identificador']} - Título do botão não informado! Garanta que o botão tenha uma mensagem e tente novamente."];
            echo json_encode($json);
            return false;
        }

        if (empty($data["tipo_cta"])) {
            $json = ["code" => 400, "message" => "{$data['btn_identificador']} - Tipo de conversão não informado! Selecione um e tente novamente!"];
            echo json_encode($json);
            return false;
        }

        $data["id"] = !empty($data["id"]) ? (int) $data["id"] : null;
        $data["contato_wpp"] = !empty($data["contato_wpp"]) ? preg_replace('/\D/', '', $data["contato_wpp"]) : null;
        $data["message_wpp"] = !empty($data["message_wpp"]) ? rawurlencode($data["message_wpp"]) : null;
        $data["form_lead"] = !empty($data["form_lead"]) ? \string_slug($data["form_lead"]) : ($data["tipo_cta"] == "lead_whatsapp" ? "padrao" : null);
        $data["link_redir"] = $data["link_redir"] ?? null;

        $btnObject = (object) $data;
        if (!empty($btnObject->id)) {
            $insertQuery = "UPDATE `cta_button` SET `tipo_cta` = :tipo_cta, `btn_identificador` = :btn_identificador, `btn_titulo` = :btn_titulo, `form_lead` = :form_lead, `contato_wpp` = :contato_wpp, `message_wpp` = :message_wpp, link_redir = :link_redir WHERE `id` = {$btnObject->id};";
        } else {
            $insertQuery = "INSERT INTO `cta_button` (tipo_cta, btn_identificador, btn_titulo, form_lead, contato_wpp, message_wpp, link_redir) VALUES (:tipo_cta, :btn_identificador, :btn_titulo, :form_lead, :contato_wpp, :message_wpp, :link_redir);";
        }

        $params = [
            ':tipo_cta'          => $btnObject->tipo_cta,
            ':btn_identificador' => $btnObject->btn_identificador,
            ':btn_titulo'        => $btnObject->btn_titulo,
            ':form_lead'         => $btnObject->form_lead,
            ':contato_wpp'       => $btnObject->contato_wpp,
            ':message_wpp'       => $btnObject->message_wpp,
            ':link_redir'        => $btnObject->link_redir,
        ];

        $data_base = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $data_base->connect();

        $pdo = $data_base->getConnection();
        $stmt = $pdo->prepare($insertQuery);

        try {
            $stmt->execute($params);
        } catch (\PDOException $exception) {
            $json = ["code" => 422, "message" => "Não foi possível salvar o registro na tabela. " . $exception->getMessage()];
            echo json_encode($json);
            return false;
        }

        return !empty($btnObject?->id) ? $btnObject->id : $pdo->lastInsertId();
    }

    public function addClique(int $id)
    {
        $button = $this->get($id);
        $cliques = $button->cliques + 1;

        $insertQuery = "UPDATE `cta_button` SET `cliques` = :cliques WHERE `id` = {$id};";
        $params = [
            ':cliques'          => $cliques,
        ];

        $data_base = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $data_base->connect();

        $pdo = $data_base->getConnection();
        $stmt = $pdo->prepare($insertQuery);

        try {
            $stmt->execute($params);
        } catch (\PDOException $exception) {
            $json = ["code" => 422, "message" => "Não foi possível salvar o registro na tabela. " . $exception->getMessage()];
            echo json_encode($json);
            return false;
        }

        return !empty($btnObject?->id) ? $btnObject->id : $pdo->lastInsertId();
    }
}
