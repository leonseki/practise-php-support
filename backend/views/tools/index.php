<?php
use yii\helpers\Url;

$this->title = "系统工具";
$this->params['breadcrumbs'][] = $this->title;
?>
<blockquote class="layui-elem-quote">
    工具箱描述
</blockquote>
<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">DebugKey</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_debug-key'); ?>
        </div>
    </div>
</div>

<script>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        let element = layui.element;
    });
</script>
