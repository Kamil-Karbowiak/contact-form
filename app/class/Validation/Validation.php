<?php
namespace ContactForm\Validation;

class Validation
{
    private $errors = [];
    private $inputs = [];
    private $passed = true;

    public function add(Input $input)
    {
        $this->inputs[] = $input;
    }

    public function getErrors()
    {
        $errors       = $this->errors;
        $this->errors = [];
        return $errors;
    }

    public function isValid()
    {
        $this->validate();
        $result       = $this->passed;
        $this->inputs = [];
        $this->passed = true;
        return $result;
    }

    private function validate()
    {
        foreach($this->inputs as $input){
            $this->checkRequirements($input);
        }
    }

    private function checkRequirements(Input $input)
    {
        while($requirement = $input->getRequirement()){
            if(!$input->getIsValid()){
                    $conditionName = $requirement->getName();
                    $conditionValue = $requirement->getRequire();
                    switch($conditionName){
                        case 'required':
                            $this->checkIfFieldIsFilled($input);
                            break;
                        case 'requiredOneOfTwoFields':
                            $this->checkIfOneOfTwoFieldsIsFilled($input, $conditionValue);
                            break;
                        case 'maxLength':
                            $this->checkMaxLength($input, $conditionValue);
                            break;
                        case 'type':
                            $this->validateType($input, $requirement);
                            break;
                }
            }
        }
    }

    public function checkIfFieldIsFilled(Input $input){
        if(empty($input->getValue())) {
            $this->errors[$input->getFieldName()] = $input->getName() . " field is required.";
            $this->passed = false;
        }else{
            $input->setIsValid(true);
        }
    }

    private function checkIfOneOfTwoFieldsIsFilled(Input $input, $secondInputName){
        if(empty($input->getValue())) {
            $secondInput = $this->getInputByName($secondInputName);
            if ($secondInput && empty($secondInput->getValue())) {
                $this->errors[$input->getFieldName()] = 'Enter ' . $input->getName() . ' or ' . $secondInput->getName() . ' fields';
                $this->errors[$secondInput->getFieldName()] = 'Enter ' . $input->getName() . ' or ' . $secondInput->getName() . ' fields';
                $this->passed = false;
            } else {
                $input->setIsValid(true);
            }
        }
    }

    private function checkMaxLength(Input $input, $length)
    {
           if (strlen($input->getValue()) > $length) {
                $this->errors[$input->getFieldName()] = $input->getName() . " field has a maximum length of " . $length . " characters.";
                $this->passed = false;
                $input->setIsValid(false);
            }
    }

    private function validateType(Input $input, Requirement $requirement)
    {
        switch($requirement->getRequire()){
            case 'phoneNumber':
                $this->validatePhoneNumber($input);
                break;
        }
    }

    private function validatePhoneNumber(Input $input)
    {
        $isValid = false;
        if(preg_match('/^[0-9]{3}(\s|-)[[0-9]{3}(\s|-)[[0-9]{3}$/', $input->getValue()) === 1){
            $isValid = true;
        }elseif(preg_match('/^[0-9]{2}(\s|-)[[0-9]{3}(\s|-)[[0-9]{2}(\s|-)[[0-9]{2}$/', $input->getValue()) === 1){
            $isValid = true;
        }elseif(preg_match('/^[0-9]{9}$/', $input->getValue()) === 1){
            $isValid = true;
        }

        if(!$isValid){
            $this->errors[$input->getFieldName()] = "This is not valid phone number type.";
            $this->passed = false;
            $input->setIsValid(false);
        }
    }
    
    private function getInputByName($name)
    {
        foreach($this->inputs as $input){
            if($input->getName() == $name){
                return $input;
            }
        }
        return false;
    }
}