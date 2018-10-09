<?php
use common\models\StudentBasicInfo;
use yii\widgets\DetailView;

$this->title = '查看详情'.$studentBasicInfoModel->id;
$this->params['breadcrumbs'][] = ['label' => '基本信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= DetailView::widget([
    'model' => $studentBasicInfoModel,
    'options' => ['class' => 'layui-table detail-view'],
    'attributes' =>[
        'id',
        'student_id',
        'name',
        [
            'attribute' => 'sex',
            'value'     => StudentBasicInfo::getSexLabels($studentBasicInfoModel->sex)
        ],
        'age',
        'id_number',
        'origin',
        'high_school',
        'residence',
        'census_register',
        'created_at:datetime',
        'updated_at:datetime'
    ]
])?>
