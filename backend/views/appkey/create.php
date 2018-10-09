<?php

$this->title = '添加AppKey';
$this->params['breadcrumbs'][] = ['label' => 'AppKey管理列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appkey-created">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>
