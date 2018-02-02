<?php
namespace ContactForm\Validation;

class Input
{
    private $name;
    private $fieldName;
    private $value;
    private $requirements;
    private $isValid = false;

    public function __construct($name, $fieldName, $value, $requirements = null)
    {
        $this->name      = $name;
        $this->fieldName = $fieldName;
        $this->value     = $value;
        if($requirements){
            $this->initRequirements($requirements);
        }
    }

    /**
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRequirement()
    {
        return $this->requirements ? array_pop($this->requirements) : false;
    }

    private function initRequirements($requirements = [])
    {
        foreach($requirements as $key => $value){
            $this->requirements[] = new Requirement($key, $value);
        }
    }
}