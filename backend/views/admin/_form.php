<?php
use yii\helpers\Url;
?>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px">
    <legend><?=$this->title?></legend>
</fieldset>

<form class="layui-form" method="post">
    <?php if ($model->isNewRecord !== true): ?>
        <input type="hidden" name="id" value="<?= $model->id ?>">
    <?php endif;?>

    <input type="hidden" name="<?=Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名:</label>
        <div class="layui-input-inline">
            <?php if ($model->isNewRecord === true):?>
                <input type="text" name="username" required placeholder=""   lay-verify="required" autocomplete="off" class="layui-input">
            <?php else:?>
                <input type="text" name="username" required placeholder=""   lay-verify="required" autocomplete="off" class="layui-input" value="<?= $model->username ?>" disabled>
            <?php endif;?>
        </div>
    </div>

    <div class="layui-form-item">
        <?php if ($model->isNewRecord === true):?>
            <label class="layui-form-label">密码:</label>
        <?php else:?>
            <label class="layui-form-label">密码:</label>
        <?php endif;?>

        <div class="layui-input-inline">
            <?php if ($model->isNewRecord === true):?>
                <input type="text" name="password" lay-verify="password" placeholder="" required  lay-verify="required" autocomplete="off" class="layui-input">
            <?php else:?>
                <input type="text" name="password" lay-verify="password" placeholder="不填默认不修改" autocomplete="off" class="layui-input">
            <?php endif;?>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">电子邮箱:</label>
        <div class="layui-input-inline">
            <input type="text" name="email" placeholder=""  lay-verify="email"  autocomplete="off" class="layui-input" value="<?= $model->email ?>">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="adminCreate">确认</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig,{
        isNewRecord: <?= $model->isNewRecord ? 'true' : 'false';?>
        ,adminCreateUrl:'<?= Url::toRoute(['admin/create'])?>'
        ,adminUpdateUrl:'<?= Url::toRoute(['admin/update'])?>'
        ,adminIndexUrl:'<?= Url::toRoute(['admin/index'])?>'
    });

    layui.use('form', function() {
        let form = layui.form;
        let reg = new RegExp("^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\\.[a-zA-Z0-9-]+)*\\.[a-zA-Z0-9]{2,6}$");
        //监听提交
        form.on('submit(adminCreate)', function(data) {
            let requestUrl = baseConfig.isNewRecord == true ? baseConfig.adminCreateUrl : baseConfig.adminUpdateUrl + '?id=' + data.field.id;
            $.post(requestUrl, data.field, function(jsondata) {
                if (jsondata.code == 1) {
                    layer.alert('添加成功!')
                    let index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭

                    // 新记录跳转到admin首页，更新记录则重载表格数据
                    if (baseConfig.isNewRecord == true) {
                        parent.location.href = baseConfig.adminIndexUrl;
                    }else {
                        parent.location.reload();
                    }
                }else {
                    layer.alert(jsondata.msg);
                    return true;
                }
            });
            return false;
        });

        //自定义验证规则
        form.verify({
            password: function(value){
                if(value.length < 4 && baseConfig.isNewRecord == false && value.length != 0){
                    return '密码长度最小长度为4位';
                }
                if(value.length < 4 && baseConfig.isNewRecord == true){
                    return '密码长度最小长度为4位';
                }
            },
            email: function(value){
                if (!reg.test(value)) {
                    return '邮箱不能为空或邮箱格式不正确';
                }
                if(value.length > 50){
                    return '邮箱最多应包含50个字符';
                }
            }
        });
    });
</script>
