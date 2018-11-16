<?php

namespace api\modules\v1\controllers\article;

use api\controllers\BaseController;

class ArticleController extends BaseController
{
    public function actionGetArticleList()
    {
        $this->successResponseJson('返回成功');
    }
}