<?php


namespace common\exceptions;


use yii\base\Exception;

class SaveModelException extends Exception
{
    private $errors = [];

    public function __construct($message, $errors = [], $code = 0, \Exception $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }
}
