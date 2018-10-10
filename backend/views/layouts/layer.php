<?php
use yii\helpers\Html;
use backend\assets\AppAsset;

AppAsset::register($this);
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
</head>
<?php $this->beginBody() ?>
<body>
<?= $content ?>
<script type="text/javascript">
    // 引入扩展js
    layui.config({
        base: '/static/js/'
    });
</script>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
