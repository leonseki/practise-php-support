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
            <a class="" href="javascript:;">学生信息管理</a >
            <dl class="layui-nav-child">
                <dd class="<?=$actionName == 'student-basic-info/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['student-basic-info/index'])?>">学生基本信息</a ></dd>
            </dl>
        </li>
    </ul>
    <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item layui-nav-itemed">
            <a class="" href="javascript:;">文章管理</a >
            <dl class="layui-nav-child">
                <dd class="<?=$actionName == 'article/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['article/index'])?>">文章列表</a ></dd>
            </dl>
        </li>
    </ul>

    <?php if (Yii::$app->user->identity->getId() == 1): ?>
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;">系统管理</a >
                <dl class="layui-nav-child">
                    <dd class="<?=$actionName == 'admin/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['admin/index'])?>">账号列表</a ></dd>
                    <dd class="<?=$actionName == 'system-log/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['system-log/index'])?>">操作日志</a ></dd>
                    <dd class="<?=$actionName == 'tools/index' ? 'layui-this' : '';?>"><a href="<?=Url::toRoute(['tools/index'])?>">系统工具</a ></dd>
                </dl>
            </li>
        </ul>
    <?php endif;?>
</div>

