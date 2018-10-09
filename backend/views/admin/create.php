<?php
$this->title = '添加账号';
$this->params['breadcrumbs'][] = ['label' => '账号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
