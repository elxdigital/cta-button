<?php

namespace ElxDigital\CtaButton\Domain;

require_once __DIR__ . "/../dep/set-variables.php";

class Email
{
    private \PHPMailer\PHPMailer\PHPMailer $mail;
    private \stdClass $data;
    private Message $message;

    public function __construct()
    {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $this->data = new \stdClass();
        $this->message = new Message();

        //setup
        $this->mail->isSMTP();
        $this->mail->setLanguage('br');
        $this->mail->isHTML();
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->CharSet = 'utf-8';

        //auth
        $this->mail->Host = \CONF_MAIL_HOST;
        $this->mail->Port = \CONF_MAIL_PORT;
        $this->mail->Username = \CONF_MAIL_USER;
        $this->mail->Password = \CONF_MAIL_PASS;
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient
     * @param string $recipientName
     * @return Email
     */
    public function bootstrap(string $subject, string $body, string $recipient, string $recipientName): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_email = $recipient;
        $this->data->recipient_name = $recipientName;
        return $this;
    }

    /**
     * @param $from
     * @param $fromName
     * @return bool
     */
    public function send(string $from = \CONF_MAIL_SENDER['address'], string $fromName = \CONF_MAIL_SENDER["name"], bool $casoEspecifico = false): bool
    {
        if (empty($this->data)) {
            $this->message->error("Erro ao enviar, favor verifique os dados");
            return false;
        }

        if (!is_str_email($this->data->recipient_email)) {
            $this->message->warning("O e-mail de destinatário não é válido");
            return false;
        }

        if (!is_str_email($from)) {
            $this->message->warning("O e-mail de remetente não é válido");
            return false;
        }

        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);

            if ($_SERVER["HTTP_HOST"] == "localhost" && !$casoEspecifico) {
                $this->mail->addAddress(\CONF_MAIL_TEST["address"], \CONF_MAIL_TEST["name"]);
                $this->mail->setFrom(\CONF_MAIL_SENDER["address"], \CONF_MAIL_SENDER["name"]);
            } else {
                $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
                $this->mail->setFrom($from, $fromName);
            }

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;
        } catch (\Exception $exception) {
            $this->message->error($exception->getMessage());
            return false;
        }
    }
}
