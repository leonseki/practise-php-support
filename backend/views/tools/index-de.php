<?php
use yii\helpers\Url;

$this->title = "小工具";
$this->params['breadcrumbs'][] = $this->title;
?>
<blockquote class="layui-elem-quote">
    解密工具
</blockquote>
<div class="layui-tab layui-tab-brief">
    <ul class="layui-tab-title">
        <li class="layui-this">解密</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <?= $this->render('_decryption'); ?>
        </div>
    </div>
</div>

<script>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        let element = layui.element;
    });
</script>
