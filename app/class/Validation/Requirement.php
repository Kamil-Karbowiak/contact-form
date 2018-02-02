<?php
namespace ContactForm\Validation;

class Requirement
{
    private $conditionName;
    private $requireValue;

    public function __construct($name, $require)
    {
        $this->conditionName = $name;
        $this->requireValue  = $require;
    }

    public function getName()
    {
        return $this->conditionName;
    }

    public function getRequire()
    {
        return $this->requireValue;
    }
}