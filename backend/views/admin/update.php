<?php
$this->title = '修改账号'. $model->username;
$this->params['breadcrumbs'][] = ['label' => '账号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
