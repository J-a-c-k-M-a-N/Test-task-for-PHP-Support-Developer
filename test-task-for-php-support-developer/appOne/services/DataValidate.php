<?php

class DataValidate
{
    const NAME = 'name';
    const EMAIL = 'email';
    const B_DAY = 'bDay';
    const MESSAGE = 'message';

    private $data;
    private $_errors = [];

    /**
     * DataValidate constructor.
     * @param array $data from $_POST
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array of data validated and errors
     */
    public function execute(): array
    {
        $data = $this->data;
        $dataValidated = [];

        foreach ($data as $key => $value) {
            $value = strip_tags(trim($value));
            $dataValidated["{{$key}}"] = $value;

            switch($key) {
                case self::NAME:
                    if (!$this->checkName($value)) {
                        $this->_errors[] = 'Name must be 2-20 characters';
                    }
                    break;

                case self::EMAIL:
                    if (!$this->checkEmail($value)) {
                        $this->_errors[] = 'Your email address is invalid';
                    }
                    break;

                case self::B_DAY:
                    if (!$this->checkDate($value)) {
                        $this->_errors[] = 'Enter your birthday';
                    }
                    break;

                case self::MESSAGE:
                    if (!$this->checkMessage($value)) {
                        $this->_errors[] = 'Message must be 2-100 characters';
                    }
                    break;
            }
        }
        return $dataValidated;
    }

    public function checkName(string $name): bool
    {
        if (filter_var($name, FILTER_VALIDATE_REGEXP,
            array(
                "options" => array("regexp"=>"/^[\w]{2,20}\$/")
            ) )) {
            return true;
        }
        return false;
    }

    public function checkEmail($email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        return false;
    }

    public function checkDate($date): bool
    {
        if (filter_var($date, FILTER_VALIDATE_REGEXP,
            array(
            "options" => array("regexp"=>"/\d{4}-\d{2}-\d{2}/")
        ) )) {
            return true;
        }
        return false;
    }

    public function checkMessage(string $name): bool
    {
        if (strlen($name) >= 2 && strlen($name) <= 150) {
            return true;
        }
        return false;
    }

    public function getErrors(): array
    {
        return $this->_errors;
    }
}