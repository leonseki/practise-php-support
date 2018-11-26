<?php
use yii\helpers\Url;

$actionName = Yii::$app->controller->id .'/'.Yii::$app->controller->action->id;
?>
<div class="layui-side-scroll">
    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
    <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item layui-nav-itemed <?=$actionName == 'site/index' ? 'layui-this' : '';?>">
            <a class="" href="<?= Url::toRoute(['site/index']) ?>">首页</a >
        </li>
    </ul>

    <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item layui-nav-itemed">
            <a class="" href="javascript:;">内容管理</a >
            <dl class="layui-nav-child">
                <dd class="<?=$actionName == 'article/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['article/index'])?>">文章管理</a ></dd>
            </dl>
        </li>
    </ul>

    <?php if (Yii::$app->user->identity->getId() == 1): ?>
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">系统管理</a >
                <dl class="layui-nav-child">
                    <dd class="<?=$actionName == 'admin/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['admin/index'])?>">账号列表</a ></dd>
                    <dd class="<?=$actionName == 'system-log/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['appkey/index'])?>">AppKey管理</a ></dd>
                    <dd class="<?=$actionName == 'tools/index-dk' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['tools/index', 'type' => 'dk'])?>">系统工具</a ></dd>
                    <dd class="<?=$actionName == 'encryption/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['encryption/index'])?>">加解密工具</a ></dd>
                </dl>
            </li>
        </ul>
    <?php endif;?>

    <?php if (Yii::$app->user->identity->getId() == 1): ?>
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">小工具</a >
                <dl class="layui-nav-child">
                    <dd class="<?=$actionName == 'tools/index-en' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['tools/index', 'type' => 'en'])?>">加密测试</a ></dd>
                    <dd class="<?=$actionName == 'tools/index-de' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['tools/index', 'type' => 'de'])?>">解密测试</a ></dd>
                </dl>
            </li>
        </ul>
    <?php endif;?>

</div>
