<?php
namespace ContactForm\Model;

use ContactForm\Core\Database;
use ContactForm\Validation\Input;
use ContactForm\Validation\Validation;

class UserMessage
{
    private $name;
    private $lastName;
    private $phoneNumber;
    private $email;
    private $message;
    private $ip;
    private $validation;
    private $db;

    public function __construct(Validation $validation, Database $db)
    {
        $this->validation = $validation;
        $this->db = $db;
    }

    public function isValid()
    {
        $this->validation->add(new Input('Name', 'userName', $this->name, [
            'required'  => true,
            'maxLength' => 40
        ]));
        $this->validation->add(new Input('Last name', 'userLastName', $this->lastName, [
            'required'  => true,
            'maxLength' => 40
        ]));
        $this->validation->add(new Input('Message', 'userMessage', $this->message, [
            'required' => true,
            'maxLength' => 400
        ]));
        $this->validation->add(new Input('Phone number', 'userPhoneNumber', $this->phoneNumber, [
                'type' => 'phoneNumber',
                'requiredOneOfTwoFields' => 'Email',
        ]));
        $this->validation->add(new Input('Email', 'userEmail', $this->email, [
                'requiredOneOfTwoFields' => 'Phone number',
                'type' => 'email',
        ]));

        return $this->validation->isValid();
    }

    public function getValidationErrors()
    {
        return $this->validation->getErrors();
    }

    public function persist()
    {
        $this->db->query('INSERT INTO `messages` (
          `username`, `lastname`, `phone`, `email`, `message`, `ip`
          ) VALUES (
          :username, :lastname, :phone, :email, :message, :ip
          )');
        $this->db->bind(':username', $this->name);
        $this->db->bind(':lastname', $this->lastName);
        $this->db->bind(':phone', $this->phoneNumber);
        $this->db->bind(':email', $this->email);
        $this->db->bind(':message', $this->message);
        $this->db->bind(':ip', $this->ip);
        $this->db->execute();
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = trim($phoneNumber);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}