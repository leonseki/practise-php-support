<?php
namespace api\modules\v1\controllers\test;

use api\controllers\BaseController;

class TestController extends BaseController
{
    public function actionTest()
    {
        return [
            'code' => 1
        ];
    }
}