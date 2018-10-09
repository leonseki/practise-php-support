<?php

use yii\helpers\Url;
$this->title = '学生基本信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="datalist-table" lay-filter="datalistTable"></table>

<script type="text/html" id="datalist-bar">
<a class="layui-btn layui-btn-xs" lay-event="view">查看详情</a>
</script>

<script type="text/javascript">

    baseConfig = $.extend(baseConfig, {
        urlStudentBasicInfoList: '<?= Url::toRoute(['student-basic-info/index', 'is_ajax' => 1]) ?>',
        urlCreate: '<?=Url::toRoute(['student-basic-info/create'])?>',
        urlStudentBasicInfoVIew: '<?= Url::toRoute(['student-basic-info/view']) ?>'
    });

    layui.use(['table', 'layerExt'], function () {
        let table = layui.table;
        let layerExt = layui.layerExt;
        table.render({
            elem: '#datalist-table'
            ,id: 'studentBasicInfoDataList'
            ,url: baseConfig.urlStudentBasicInfoList
            , page: {
                curr: location.hash.replace('#!page=', '')
                ,hash : 'page'
            }
            , where: {
                'id' : getQueryString('id'),
                'name' : getQueryString('name'),
                'student_id' : getQueryString('student_id'),
            }
            , limit: 15
            , limits: [10, 15, 20, 25]
            , cols: [[
                {type: 'checkbox'}
                ,{field: 'id',         title: 'ID'}
                ,{field: 'student_id', title: '学号'}
                ,{field: 'name',       title: '姓名'}
                ,{field: 'sex_label',  title: '性别'}
                ,{field: 'age',        title: '年龄'}
                ,{field: 'id_number',  title: '身份证号'}
                ,{field: 'created_at', title: '创建时间'}
                ,{fixed: 'right',      title: '操作', width:150, align:'center', toolbar: '#datalist-bar'}
            ]]
        });

        // 监听工具条
        table.on('tool(datalistTable)', function (obj) {
            let data = obj.data;
            let layEvent = obj.event;
            let urlView = baseConfig.urlStudentBasicInfoVIew+'?id='+data.id;
            if (layEvent === 'view') {
                layerExt.open(urlView, {width: '830px', height: '600px', title: '信息详情'});
            }
        })
    });
</script>
