<?php
use yii\helpers\Url;
$this->title = 'AppKey管理列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="datalist-table" lay-filter="datalistTable"></table>

<script type="text/html" id="switchTpl">
    <input type="checkbox" name="state" value="{{d.app_id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="stateDemo" {{d.state == 1? 'checked' : ''}}>
</script>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig, {
        urlAppkeyList: '<?= Url::toRoute(['appkey/index', 'is_ajax' => 1]) ?>',
        urlAppkeyUpdate: '<?= Url::toRoute(['appkey/update']) ?>'
    });

    layui.use('table', function () {
        let table = layui.table;
        let form = layui.form;
        table.render({
            elem: '#datalist-table'
            ,url: baseConfig.urlAppkeyList
            , page: {
                curr: location.hash.replace('#!page=', '')
                ,hash : 'page'
            }
            , where: {
                'app_key' : getQueryString('app_key'),
                'label'   : getQueryString('label'),
            }
            , limit: 15
            , limits: [10, 15, 20, 25]
            , cols: [[
                 {field: 'app_id',         title: 'ID'}
                ,{field: 'label',      title: '标签(可编辑)', edit: 'text'}
                ,{field: 'app_key',    title: 'AppKey'}
                ,{field: 'app_secret',    title: 'app_secret'}
                ,{field: 'state',      title: '是否启用', templet: '#switchTpl'}
                ,{field: 'created_at', title: '创建时间'}
            ]]
        });

        // 监听启用状态
        form.on('switch(stateDemo)',function (obj) {
            let _this = this;
            let isCheck = obj.elem.checked;
            $(_this).prop('checked', isCheck==true?false:true);
            form.render();
            layer.confirm('确认要'+(isCheck==true?'启用':'禁用')+'吗?', {icon: 3, title: '提示'}, function (index) {
                let data = {'state':(isCheck==true?'1':'0')};
                $.post(baseConfig.urlAppkeyUpdate+'?id='+obj.value, data, function (jsondata) {
                    if (jsondata.code == 1) {
                        $(_this).prop('checked',obj.elem.checked == true?false:true);
                        form.render();
                        layer.close(index);
                    }
                    layer.msg(jsondata.msg);
                });
            });
        });

        // 监听单元格编辑
        table.on('edit(datalistTable)', function (obj) {
           let value = obj.value;
           let app_id = obj.data.app_id;
           $.post(baseConfig.urlAppkeyUpdate+'?id='+app_id, {'label': value}, function (jsondata) {
               layer.msg(jsondata.msg);
           });
        });


    });
</script>