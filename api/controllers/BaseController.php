<?php

namespace api\controllers;

use api\component\auth\SignAuth;
use api\component\exception\ErrorCode;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Request;
use Yii;
use yii\web\Response;

/**
 * 基础控制器
 * @package api\controllers
 */
abstract class BaseController extends Controller
{
    /**
     * Yii请求对象简写
     * @var Request
     */
    public $request;

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        $this->request = Yii::$app->request;
    }

    /**
     * 定义行为
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => SignAuth::className(),
            ]
        ];
    }

    /**
     * 响应返回JSON数据
     * @param integer $code
     * @param string $msg
     * @param array $data
     * @param array $errorInfo
     */
    public function responseJson($code, $msg = '', $data = [], $errorInfo = [])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode(CommonHelper::responseJson($code, $msg, $data, $errorInfo));
        Yii::$app->response->send();
        exit;
    }

    /**
     * 响应成功情况下返回的JSON
     *
     * @param string $msg
     * @param array $data
     * @param array $errorInfo
     */
    public function successResponseJson($msg = '', $data = [], $errorInfo = [])
    {
        $this->responseJson(ErrorCode::CODE_SUCCESS, $msg, $data, $errorInfo);
    }

    /**
     * 响应成功情况下返回的JSON
     *
     * @param string $msg
     * @param array $data
     * @param array $errorInfo
     */
    public function failResponseJson($msg = '', $data = [], $errorInfo = [])
    {
        $this->responseJson(ErrorCode::CODE_FAIL, $msg, $data, $errorInfo);
    }

    public function dataListResponseJson($dataList, $pageObject = null)
    {
        $data = $dataList;
        if ($pageObject != null) {
            $data = ArrayHelper::merge(
                ['page_info' => $this->getPageInfo($pageObject)],
                ['items' => $dataList]
            );
        }
        $this->successResponseJson('', $data);
    }

    public function getPageInfo($pageObject)
    {
        return [
            'total_count'   => $pageObject->totalCount,
            'page_size'     => $pageObject->getPageSize(),
            'current_page'  => $pageObject->getPage() + 1,
        ];
    }
}