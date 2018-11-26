<?php

$this->title = '添加密码';
$this->params['breadcrumbs'][] = ['label' => '密码管理列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="encryption-created">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
