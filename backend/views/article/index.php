<?php

use yii\helpers\Url;
$this->title = '文章基本信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="datalist-table" lay-filter="datalistTable"></table>
<script type="text/html" id="articleSwitchTpl">
    <input type="checkbox" name="state" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="articleState" {{d.state == 1? 'checked' : ''}}>
</script>

<script type="text/html" id="datalist-bar">
    <a class="layui-btn layui-btn-xs" lay-event="view">查看详情</a>
</script>

<script type="text/javascript">

    baseConfig = $.extend(baseConfig, {
        urlArticleList: '<?= Url::toRoute(['article/index', 'is_ajax' => 1]) ?>',
        urlCreate: '<?=Url::toRoute(['article/create'])?>',
        urlArticleVIew: '<?= Url::toRoute(['article/view']) ?>',
        urlArticleUpdateState: '<?= Url::toRoute(['article/update-state']) ?>'
    });

    layui.use(['table', 'layerExt'], function () {
        let table = layui.table;
        let form = layui.form;
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
                ,{field: 'state',      title: '是否启用', templet: '#articleSwitchTpl'}
                ,{field: 'created_at', title: '创建时间'}
                ,{fixed: 'right',      title: '操作', width:150, align:'center', toolbar: '#datalist-bar'}
            ]]
        });

        // 监听启用状态
        form.on('switch(articleState)',function (obj) {
            let _this = this;
            let isCheck = obj.elem.checked;
            $(_this).prop('checked', isCheck==true?false:true);
            form.render();
            layer.confirm('确认要'+(isCheck==true?'启用':'禁用')+'吗?', {icon: 3, title: '提示'}, function (index) {
                let data = {'state':(isCheck==true?'1':'0')};
                $.post(baseConfig.urlArticleUpdateState+'?id='+obj.value, data, function (jsondata) {
                    if (jsondata.code == 1) {
                        $(_this).prop('checked',obj.elem.checked == true?false:true);
                        form.render();
                        layer.close(index);
                    }
                    layer.msg(jsondata.msg);
                });
            });
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
