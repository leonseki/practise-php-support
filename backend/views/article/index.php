<?php

use yii\helpers\Url;
$this->title = '文章基本信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="datalist-table" lay-filter="datalistTable"></table>

<script type="text/html" id="datalist-bar">
    <a class="layui-btn layui-btn-xs" lay-event="view">查看详情</a>
</script>

<script type="text/javascript">

    baseConfig = $.extend(baseConfig, {
        urlArticleList: '<?= Url::toRoute(['article/index', 'is_ajax' => 1]) ?>',
        urlCreate: '<?=Url::toRoute(['article/create'])?>',
        urlArticleVIew: '<?= Url::toRoute(['article/view']) ?>'
    });

    layui.use(['table', 'layerExt'], function () {
        let table = layui.table;
        let layerExt = layui.layerExt;
        table.render({
            elem: '#datalist-table'
            ,id: 'articleDataList'
            ,url: baseConfig.urlArticleList
            , page: {
                curr: location.hash.replace('#!page=', '')
                ,hash : 'page'
            }
            , where: {
                'id' : getQueryString('id'),
                'title' : getQueryString('title'),
            }
            , limit: 15
            , limits: [10, 15, 20, 25]
            , cols: [[
                {type: 'checkbox'}
                ,{field: 'id',         title: 'ID'}
                ,{field: 'title',      title: '标题'}
                ,{field: 'content',    title: '内容'}
                ,{field: 'created_at', title: '创建时间'}
                ,{fixed: 'right',      title: '操作', width:150, align:'center', toolbar: '#datalist-bar'}
            ]]
        });

        // 监听工具条
        table.on('tool(datalistTable)', function (obj) {
            let data = obj.data;
            let layEvent = obj.event;
            let urlView = baseConfig.urlArticleVIew+'?id='+data.id;
            if (layEvent === 'view') {
                layerExt.open(urlView, {width: '830px', height: '600px', title: '信息详情'});
            }
        })
    });
</script>
