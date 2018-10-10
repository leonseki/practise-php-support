<?php

namespace api\component\exception;

use Throwable;
use yii\base\UserException;

/**
 * Class ApiException
 * @package api\component\exception
 */
class ApiException extends UserException
{
    public function __construct($message = null, $code = ErrorCode::CODE_FAIL, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}