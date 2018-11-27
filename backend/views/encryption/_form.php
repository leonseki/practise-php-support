<?php

use yii\helpers\Url;
use common\models\Encryption;

/* @var $this yii\web\View */
/* @var $model common\models\Encryption */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    .layui-form-label {width: 113px;}
    .abc .layui-input-block {
        margin-left:143px;
    }
    .layui-form-mid {font-size: 10px;}
</style>

<div class="encryption-form">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><?=$this->title?></legend>
    </fieldset>

    <form class="layui-form" lay-filter="encryptionForm" method="post">
        <input type="hidden" name="<?=\Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="layui-form-item">
            <label class="layui-form-label" required>密码名称：</label>
            <div class="layui-input-inline" style="width: 250px;">
                <input type="text" name="name" placeholder="请输入" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" required>明文：</label>
            <div class="layui-input-inline" style="width: 250px;">
                <input type="text" name="plain_text" id="plain_text" placeholder="请输入" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" required>明文确定：</label>
            <div class="layui-input-inline" style="width: 250px;">
                <input type="password" name="plain_text_repeat" id="plain_text_repeat" placeholder="请输入" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">启用状态：</label>
            <div class="layui-input-block">
                <input type="radio" name="state" value="1" checked title="启用">
                <input type="radio" name="state" value="0" title="禁用">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formEncryption">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig,{
        urlEncryptionIndex:'<?= Url::toRoute(['encryption/index'])?>'
        ,urlEncryptionCreate:'<?= Url::toRoute(['encryption/create', 'is_ajax' => 1])?>'
    });
    layui.use(['layer', 'form'], function(){
        let form = layui.form;
        let layer= layui.layer;

        //监听提交
        form.on('submit(formEncryption)', function(data){
            let url = baseConfig.urlEncryptionCreate;
            if ($('#plain_text').val().trim() !== $('#plain_text_repeat').val().trim()) {
                layer.alert('两次密码输入不一致')
            } else {
                $.post(url, data.field, function(jsondata) {
                    if (jsondata.code == 1) {
                        let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                        // 新记录跳转到首页，更新记录则重载表格数据
                        parent.location.href = baseConfig.urlEncryptionIndex;
                    } else {
                        layer.alert(jsondata.msg);
                    }
                });
            }
            return false;
        });
    });
</script>
