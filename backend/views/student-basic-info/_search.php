<?php
use common\models\StudentBasicInfo;
use yii\helpers\Url;
?>
<div class="student-basic-info-search">
    <form class="layui-form">
        <blockquote class="layui-elem-quote">
            <div class="layui-inline">
                <label class="layui-form-label">ID:</label>
                <div class="layui-input-inline" style="width: 90px">
                    <input type="text" name="id" class="layui-input" placeholder="" value="<?=Yii::$app->request->get('id')?>">
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
            layui.layerExt.open('<?=Url::toRoute(['student-basic-info/create'])?>', {width:'470px', height:'400px', title: '添加学生基本信息'});
        });
    }
</script>