<?php

namespace api\modules\v1\controllers\content;

use api\controllers\BaseController;

class ArticleController extends BaseController
{
    public function actionGetArticleList()
    {
        $this->successResponseJson('返回成功');
    }
}