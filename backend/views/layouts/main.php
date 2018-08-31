<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
$username = isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <?= $this->render('header.php', ['username' => $username]) ?>
    <!-- 左侧导航栏-->
    <div class="layui-side layui-bg-black">
        <?= $this->render('nav-left.php') ?>
    </div>
    <!-- 内容主体区域 -->
    <div class="layui-body">
        <!-- 设置面包屑 -->
        <div style="padding: 15px">
            <?= \yii\widgets\Breadcrumbs::widget([
                'tag'  => 'div',
                'homeLink' => [
                    'label'=> '首页',
                    'url'  => Url::toRoute(['site/index']),
                ],
                'options' => ['class' => 'layui-breadcrumb', 'style' => 'margin-bottom: 10px'],
                'itemTemplate' => "{link}",
                'activeItemTemplate' => "<a><cite>{link}</cite></a>",
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>
<script type="text/javascript">
    layui.use('element', function () {

    });
    layui.config({
        base:'/static/js'
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
