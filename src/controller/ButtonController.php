<?php

namespace ElxDigital\CtaButton\Controller;

class ButtonController
{
    private \ElxDigital\CtaButton\View\View $view;

    public function __construct() {}

    public function render_public(int $btn_id, array $arrayBtnClasses, bool $span, ?string $templates_path, array $arraySpanClasses, string $content_before, string $content_after, bool $translate): void
    {
        $this->view = new \ElxDigital\CtaButton\View\View(__DIR__ . "/../template/");

        $model = new \ElxDigital\CtaButton\Model\Button();
        $btn_conversao = $model->get($btn_id, $translate);
        $hasModal = ($btn_conversao->tipo_cta == "lead" || $btn_conversao->tipo_cta == "lead_whatsapp");

        $form = null;
        if ($hasModal && !empty($templates_path)) {
            if ($btn_conversao->tipo_cta == "lead_whatsapp") {
                $form = $this->view->render("forms/{$btn_conversao->form_lead}", [
                    "modalId" => "form-{$btn_conversao->btn_identificador}",
                    "modalTitle" => $btn_conversao->btn_titulo,
                    "btn_id" => $btn_id,
                ]);
            } else {
                $view_path = new \ElxDigital\CtaButton\View\View($templates_path);
                $form = $view_path->render("forms/{$btn_conversao->form_lead}", []);
            }
        }

        echo $this->view->render('public', [
            "btn_conversao" => $btn_conversao,
            "hasModal" => $hasModal,
            "form" => $form,
            "arrayBtnClasses" => $arrayBtnClasses,
            "arraySpanClasses" => $arraySpanClasses,
            "span" => $span,
            "content_before" => $content_before,
            "content_after" => $content_after,
            "translate" => $translate,
        ]);
    }

    public function render_admin(string $field_name, string $btn_identificador, array $formularios, ?int $btn_id, array $tipos_conversao): void
    {
        $this->view = new \ElxDigital\CtaButton\View\View(__DIR__ . "/../template/");

        $btn_conversao = null;
        if (!empty($btn_id)) {
            $model = new \ElxDigital\CtaButton\Model\Button();
            $btn_conversao = $model->get($btn_id);
        }

        echo $this->view->render('admin', [
            "field_name" => $field_name,
            "btn_identificador" => $btn_identificador,
            "btn_conversao" => $btn_conversao,
            "tipos_conversao" => $tipos_conversao,
            "formularios" => $formularios,
        ]);
    }

    public function saveButton(array $data): void
    {
        $dadosPost = array_filter($data, fn ($dado) => !empty(trim($dado)));
        if (empty($dadosPost)) {
            $json = ["code" => 400, "message" => "Nenhuma informação preenchida."];
            echo json_encode($json);
            return;
        }

        $dataFiltered = filter_var_array($dadosPost, FILTER_SANITIZE_SPECIAL_CHARS);
        $model = new \ElxDigital\CtaButton\Model\Button();
        $lastId = $model->save($dataFiltered);

        if (!$lastId) {
            $json = ["code" => 400, "message" => "Erro ao salvar o botão no banco de dados!!"];
            echo json_encode($json);
            return;
        }

        $json = ["code" => 200, "message" => "Sucesso! Botão salvo no banco de dados.", "saveCode" => $lastId];
        echo json_encode($json);
        return;
    }

    public function saveClique(array $data)
    {
        $data['btn_identificador'] = filter_var($data["btn_identificador"], FILTER_SANITIZE_SPECIAL_CHARS);

        $model = new \ElxDigital\CtaButton\Model\Button();
        $botao = $model->getByIdentificador($data["btn_identificador"]);

        $model->addClique($botao->id);
    }
}
