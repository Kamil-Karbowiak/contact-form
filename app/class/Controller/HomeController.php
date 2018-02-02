<?php
namespace ContactForm\Controller;

use ContactForm\Core\Controller;
use ContactForm\Core\Database;
use ContactForm\Model\UserMessage;
use ContactForm\Utilities\IpProvider;
use ContactForm\Utilities\Mail;
use ContactForm\Utilities\Redirect;
use ContactForm\Utilities\Timer;
use ContactForm\Validation\Validation;
use ContactForm\Session;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends Controller
{
	public function index()
    {
        $session = new Session();
        $fields  = [];
        $errors  = [];
        if (array_key_exists('contactFormSubmit', $_POST)){
            $name        = isset($_POST['userName']) ? $_POST['userName'] : null;
            $lastName    = isset($_POST['userLastName']) ? $_POST['userLastName'] : null;
            $phone       = isset($_POST['userPhoneNumber']) ? $_POST['userPhoneNumber'] : null;
            $email       = isset($_POST['userEmail']) ? $_POST['userEmail'] : null;
            $message     = isset($_POST['userMessage']) ? $_POST['userMessage'] : null;
            $ip          = IpProvider::get_client_ip();
            $validation  = new Validation();
            $db          = new Database();
            $userMessage = new UserMessage($validation, $db);
            $userMessage->setName(htmlspecialchars($name));
            $userMessage->setLastName(htmlspecialchars($lastName));
            $userMessage->setEmail(htmlspecialchars($email));
            $userMessage->setPhoneNumber(htmlspecialchars($phone));
            $userMessage->setMessage(htmlspecialchars($message));
            $userMessage->setIp($ip);
            if($userMessage->isValid()){
                $timer = new Timer($session);
                if($timer->isRequiredTimePassed()){
                    $userMessage->persist();
                    $mailSend = new Mail(new PHPMailer());
                    $mailSend->sendEmail($userMessage);
                    $timer->updateStartTime();
                    Redirect::redirect('welcome/index');
                }else{
                    $session->flashMessage('Od wysłania poprzedniej
                    wiadomości nie upłynęła jeszcze minuta. Prosimy spróbować ponownie za chwilę');
                }
            }
            $errors = $userMessage->getValidationErrors();
            $fields['userName'] = $name;
            $fields['userLastName'] = $lastName;
            $fields['userPhoneNumber'] = $phone;
            $fields['userEmail'] = $email;
            $fields['userMessage'] = $message;
        }
        $this->view('home/index.html.twig', [
            'errors' => $errors,
            'fields' => $fields,
            'message' => $session->flashMessage()
        ]);
    }
}