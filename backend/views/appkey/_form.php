<?php

use yii\helpers\Url;
use common\models\Appkey;

/* @var $this yii\web\View */
/* @var $model common\models\Appkey */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    .layui-form-label {width: 113px;}
    .abc .layui-input-block {
        margin-left:143px;
    }
    .layui-form-mid {font-size: 10px;}
</style>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig,{
        urlAppkeyIndex:'<?= Url::toRoute(['appkey/index'])?>'
        ,urlAppkeyCreate:'<?= Url::toRoute(['appkey/create', 'is_ajax' => 1])?>'
        ,urlAppkeyUpdate:'<?= Url::toRoute(['appkey/update', 'id' =>$model->app_id, 'is_ajax' => 1])?>'
        ,postType:'<?= $model->isNewRecord ? 'create' : 'update';?>'
    });
    layui.use(['layer', 'form'], function(){
        let form = layui.form;
        let layer= layui.layer;

        //监听提交
        form.on('submit(formAppkey)', function(data){
            let url = baseConfig.postType == 'create' ? baseConfig.urlAppkeyCreate : baseConfig.urlAppkeyUpdate;
            $.post(url, data.field, function(jsondata) {
                if (jsondata.code == 1) {
                    let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭

                    // 新记录跳转到appkey首页，更新记录则重载表格数据
                    if (baseConfig.postType == 'create') {
                        parent.location.href = baseConfig.urlAppkeyIndex;
                    }else {
                        parent.location.reload();
                    }
                }else {
                    layer.alert(jsondata.msg);
                }
            });
            return false;
        });
    });
</script>

<div class="appkey-form">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend><?=$this->title?></legend>
    </fieldset>

    <form class="layui-form" lay-filter="appkeyForm" method="post">
        <input type="hidden" name="<?=\Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="layui-form-item">
            <label class="layui-form-label" required>标签：</label>
            <div class="layui-input-inline" style="width: 250px;">
                <input type="text" name="label" id="label" value="<?= $model->label ?>" placeholder="请输入" required  lay-verify="required" autocomplete="off" class="layui-input">
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
                <button class="layui-btn" lay-submit lay-filter="formAppkey">提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
