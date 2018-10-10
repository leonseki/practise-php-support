<?php
namespace api\component\exception;

/**
 * 输入不合法异常定义
 * @package api\component\exception
 */
class InputInvalidApiException extends ApiException
{
    /**
     * 错误码
     * @var integer
     */
    public $code = ErrorCode::INPUT_INVALID;
}