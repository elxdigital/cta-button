<?php

namespace Elxdigital\CtaButton\Model;

use PDO;

class Button
{
    public function __construct()
    {
        set_time_limit(0);
    }

    public function get(int $btn_id, ?bool $translate = false): object|array
    {
        $conexao = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $conexao->connect();
        $banco_de_dados = $conexao->getConnection();
        $entidade = "cta_button";

        if ($translate && (!empty($_SESSION['lang']) && $_SESSION['lang'] != "pt")) {
            $translateFields = $this->getCamposTraduziveis();

            if (!empty($translateFields)) {
                $fields = array_map(function ($field) use ($translateFields) {
                    $translateField = in_array($field, $translateFields);
                    return $translateField ? "IFNULL(translated_{$field}.column_value, cta_button.{$field}) AS {$field}" : "cta_button.{$field}";
                }, $this->getCampos());

                $subJoins = [];
                $subColumns = implode(", ", $fields);

                foreach ($translateFields as $field) {
                    $subJoins[] = "LEFT JOIN translate_schema AS translated_{$field} ON cta_button.id = translated_{$field}.column_index AND translated_{$field}.column_name = '{$field}' AND translated_{$field}.language = '{$_SESSION['lang']}' AND translated_{$field}.table_name = 'cta_button'";
                }

                $entidade = ("(SELECT {$subColumns} FROM `cta_button` " . implode(" ", $subJoins) . ") AS cta_button");
            }
        }

        if (!empty($btn_id)) {
            $result = $banco_de_dados->prepare("SELECT * FROM {$entidade} WHERE id = :btn_id");
            $result->execute([
                ':btn_id' => $btn_id,
            ]);

            return (object) $result->fetch(PDO::FETCH_ASSOC);
        }

        $result = $banco_de_dados->prepare("SELECT * FROM {$entidade}");
        $result->execute();

        return (array) $result->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public function getByIdentificador(string $identificador): object
    {
        $conexao = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $conexao->connect();
        $banco_de_dados = $conexao->getConnection();

        $result = $banco_de_dados->prepare("SELECT * FROM `cta_button` WHERE btn_identificador = :btn_identificador");
        $result->execute([
            ':btn_identificador' => $identificador,
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

        $id_save = !empty($btnObject?->id) ? $btnObject->id : $pdo->lastInsertId();

        $this->saveTraducoes($id_save);

        return $id_save;
    }

    public function saveTraducoes(int $id)
    {
        if (
            !empty($this->getCamposTraduziveis())
        ) {
            $entidade = "cta_button";
            $data_base = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
            $data_base->connect();
            $pdo = $data_base->getConnection();

            $delete_query = "DELETE FROM `translate_queue` WHERE model_name = 'cta_button' AND column_index = :id";
            $stmt_delete = $pdo->prepare($delete_query);
            $stmt_delete->execute(["id" => $id]);

            $add_query = "INSERT INTO `translate_queue` (`model_name`, `column_index`) VALUES ('cta_button', {$id})";
            $stmt_add = $pdo->prepare($add_query);
            $stmt_add->execute();
        }
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

    public function getCamposTraduziveis(): array
    {
        $conexao = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $conexao->connect();
        $banco_de_dados = $conexao->getConnection();
        $dbName = $conexao->getDataBaseName();

        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$dbName}' AND TABLE_NAME = 'cta_button' AND COLUMN_COMMENT LIKE '%@translatable%'";
        $stmt = $banco_de_dados->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getCampos(): array
    {
        $conexao = new \Elxdigital\CtaButton\Domain\DataBaseConnection();
        $conexao->connect();
        $banco_de_dados = $conexao->getConnection();
        $dbName = $conexao->getDataBaseName();

        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$dbName}' AND TABLE_NAME = 'cta_button'";
        $stmt = $banco_de_dados->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
