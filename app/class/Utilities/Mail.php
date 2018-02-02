<?php
namespace ContactForm\Utilities;

use ContactForm\Model\UserMessage;
use Html2Text\Html2Text;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private $host         = EMAIL_HOST;
    private $port         = EMAIL_PORT;
    private $smtpSecure   = EMAIL_SMTP_SECURE;
    private $userName     = EMAIL_USERNAME;
    private $password     = EMAIL_PASSWORD;
    private $emailAddress = EMAIL_ADDRESS;
    private $mail;

    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
        $this->configureMailer();
    }

    private function configureMailer()
    {
        $this->mail->isSMTP();
        $this->mail->SMTPDebug   = 0;
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        );
        $this->mail->CharSet    = 'UTF-8';
        $this->mail->Host       = $this->host;
        $this->mail->Port       = $this->port;
        $this->mail->SMTPSecure = $this->smtpSecure;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $this->userName;
        $this->mail->Password   = $this->password;
    }
    public function sendEmail(UserMessage $userMessage, $subject = 'Message from contact form')
    {
        $htmlMessage = new Html2Text($this->prepareMessage($userMessage));
        $message = $htmlMessage->getText();
        $this->mail->setFrom($this->emailAddress);
        if(!empty($userMessage->getEmail())){
            $userEmail = $userMessage->getEmail();
            $name = $userMessage->getName();
            $this->mail->addReplyTo($userEmail, $name);
        }
        $this->mail->addAddress($this->emailAddress);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->send();
    }

    private function prepareMessage(UserMessage $userMessage)
    {
        $msg = '';
        $msg .= 'Imię: '.$userMessage->getName().'<br>';
        $msg .= 'Nazwisko: '.$userMessage->getLastName().'<br>';
        $msg .= 'Telefon kontaktowy: '.$userMessage->getPhoneNumber().'<br>';
        $msg .= 'Adres e-mail: '.$userMessage->getEmail().'<br>';
        $msg .= 'Treść wiadomości: '.$userMessage->getMessage().'<br>';
        return $msg;
    }
}