<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::register($this);

$this->context->layout = false;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            body{overflow:hidden;}
            .video_mask{ width:100%; height:100%; position:absolute; left:0; top:0; z-index:90; background-color:rgba(0,0,0,0.5); }
            .login{ height:220px;width:260px;padding: 20px;background-color:rgba(0,0,0,0.5);border-radius: 4px;position:absolute;left: 50%;top: 50%; margin:-150px 0 0 -150px;z-index:99;}
            .login h1{ text-align:center; color:#fff; font-size:24px; margin-bottom:20px; }
            .form_code .code{ position:absolute; right:0; top:1px; cursor:pointer; }
            .login_btn{ width:100%; }
        </style>
    </head>
    <?php $this->beginBody() ?>
    <div class="video_mask"></div>
    <div class="login">
        <h1>后台管理系统</h1>
        <form class="layui-form" method="post">
            <div class="layui-form-item">
                <input class="layui-input" name="username" placeholder="用户名" required lay-verify="required" type="text" autocomplete="off">
            </div>
            <div class="layui-form-item">
                <input class="layui-input" name="password" placeholder="密码" required lay-verify="required" type="password" autocomplete="off">
            </div>
            <button class="layui-btn login_btn" lay-submit="" lay-filter="login">登录</button>
        </form>
    </div>

    <script type="text/javascript">
        baseConfig = $.extend(baseConfig,{
            loginUrl: '<?= Url::toRoute(['site/login'])?>'
            ,indexUrl:'<?= Url::toRoute(['site/index'])?>'
        });

        layui.use('form', function() {
            /* ----------------------- */
            /* var form = layui.form;
             *
             *  之前这里使用的是'var'，编译器会报提示：
             *  'var' used instead of 'let' or 'const'
             */
            /* ----------------------- */
            let form = layui.form;

            //监听提交
            form.on('submit(login)', function(data) {
                $.post(baseConfig.loginUrl, data.field, function(jsondata) {
                    if (jsondata.code == 1) {
                        layer.msg('登录成功,正在跳转...');
                        setTimeout(function() {window.location.href = baseConfig.indexUrl;}, 1000);
                        return true;
                    }else {
                        layer.msg('登录失败');
                    }
                });
                return false;
            });
        });
    </script>
    <?php $this->endBody() ?>
    </html>
<?php $this->endPage() ?>