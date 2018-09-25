<?php
use yii\helpers\Url;
?>
<div class="admin">
    <form class="layui-form">
        <blockquote class="layui-elem-quote">
            <div class="layui-inline" style="margin-left: -50px">
                <label class="layui-form-label">ID:</label>
                <div class="layui-input-inline" style="width: 120px">
                    <input type="text" name="id" class="layui-input" placeholder="请输入ID" value="<?=Yii::$app->request->get('id')?>">
                </div>
            </div>
            <div class="layui-inline" style="margin-left: -40px">
                <label class="layui-form-label">用户名:</label>
                <div class="layui-input-inline" style="width: 150px">
                    <input type="text" name="username" class="layui-input" placeholder="请输入搜索内容" value="<?=Yii::$app->request->get('username')?>">
                </div>
            </div>
            <div class="layui-inline">
                <button class="layui-btn"><i class="layui-icon layui-icon-search"></i>搜索</button>
                <a class="layui-btn layui-btn-normal" onclick="create()">
                    <i class="layui-icon layui-icon-add-circle"></i>添加
                </a>
            </div>
        </blockquote>
    </form>
</div>
<script type="text/javascript">
    function create() {
        layui.use(['layerExt'], function () {
            layui.layerExt.open('<?=Url::toRoute(['admin/create'])?>', {width:'460px', height:'400px', title: '添加账号'});
        });
    }
</script>