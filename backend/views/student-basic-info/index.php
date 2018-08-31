<?php

use yii\helpers\Url;
$this->title = '学生基本信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="datalist-table" lay-filter="datalistTable"></table>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig, {
        urlStudentBasicInfoList: '<?= Url::toRoute(['student-basic-info/index', 'is_ajax' => 1]) ?>'
    });

    layui.use(['table'], function () {
        let table = layui.table;

        table.render({
            elem: '#datalist-table'
            ,id: 'studentBasicInfoDataList'
            ,url: baseConfig.urlStudentBasicInfoList
            , page: {
                curr: location.hash.replace('#!page=', '')
                ,hash : 'page'
            }
            , where: {
                'name' : getQueryString('name')
            }
            , limit: 15
            , limits: [10, 15, 20, 25]
            , cols: [[
                {type: 'checkbox'}
                ,{field: 'id', title: 'ID'}
                ,{field: 'student_id', title: '学号'}
                ,{field: 'name', title: '姓名'}
                ,{field: 'sex', title: '性别'}
                ,{field: 'age', title: '年龄'}
                ,{field: 'id_number', title: '身份证号'}
            ]]
        });
    });
</script>
