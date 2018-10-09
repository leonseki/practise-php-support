<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\AppkeySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appkey-search">
    <form class="layui-form">
        <blockquote class="layui-elem-quote">
            <div class="layui-inline" style="margin-left: -50px">
                <label class="layui-form-label">标签:</label>
                <div class="layui-input-inline" style="width: 90px" >
                    <input type="text" name="label" class="layui-input" placeholder="" value="<?=Yii::$app->request->get('label')?>">
                </div>
            </div>
            <div class="layui-inline" style="margin-left: -30px">
                <label class="layui-form-label">appkey:</label>
                <div class="layui-input-inline" style="width: 120px">
                    <input type="text" name="app_key" class="layui-input" placeholder="" value="<?=Yii::$app->request->get('app_key')?>">
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
            layui.layerExt.open('<?=Url::toRoute(['appkey/create'])?>', {width:'470px', height:'400px', title: '添加AppKey'});
        });
    }
</script>
