<?php
use common\models\StudentBasicInfo;
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
            </div>
        </blockquote>
    </form>
</div>
