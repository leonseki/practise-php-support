<?php
use yii\helpers\Url;
$this->title = '密码列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="datalist-table" lay-filter="datalistTable"></table>
<script type="text/html" id="encryptionSwitchTpl">
    <input type="checkbox" name="state" value="{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="encryptionState" {{d.state == 1? 'checked' : ''}}>
</script>

<script type="text/html" id="datalist-bar">
    <a class="layui-btn layui-btn-xs" lay-event="view">查看详情</a>
    <a class="layui-btn layui-btn-xs" lay-event="decryption">解密</a>
</script>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig, {
        urlEncryptionList: '<?= Url::toRoute(['encryption/index', 'is_ajax' => 1]) ?>',
        urlCreate: '<?=Url::toRoute(['encryption/create'])?>',
        urlEncryptionVIew: '<?= Url::toRoute(['encryption/view']) ?>',
        urlEncryptionUpdateState: '<?= Url::toRoute(['encryption/update-state']) ?>'
    });

    layui.use(['table', 'layerExt'], function () {
        let table = layui.table;
        let form = layui.form;
        let layerExt = layui.layerExt;
        table.render({
            elem: '#datalist-table'
            ,id: 'encryptionDataList'
            ,url: baseConfig.urlEncryptionList
            , page: {
                curr: location.hash.replace('#!page=', '')
                ,hash : 'page'
            }
            , where: {
                'id' : getQueryString('id'),
            }
            , limit: 15
            , limits: [10, 15, 20, 25]
            , cols: [[
                {type: 'checkbox'}
                ,{field: 'id',            title: 'ID'}
                ,{field: 'name',          title: '名称'}
                ,{field: 'category_label',title: '类别'}
                ,{field: 'password_hash', title: '密文', width: 256}
                ,{field: 'state',      title: '是否启用', templet: '#encryptionSwitchTpl', width: 120}
                ,{field: 'created_at', title: '创建时间', width: 200}
                ,{fixed: 'right',      title: '操作', width:150, align:'center', toolbar: '#datalist-bar'}
            ]]
        });

        // 监听启用状态
        form.on('switch(encryptionState)',function (obj) {
            let _this = this;
            let isCheck = obj.elem.checked;
            $(_this).prop('checked', isCheck==true?false:true);
            form.render();
            layer.confirm('确认要'+(isCheck==true?'启用':'禁用')+'吗?', {icon: 3, title: '提示'}, function (index) {
                let data = {'state':(isCheck==true?'1':'0')};
                $.post(baseConfig.urlEncryptionUpdateState+'?id='+obj.value, data, function (jsondata) {
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
            let urlView = baseConfig.urlEncryptionVIew+'?id='+data.id;
            if (layEvent === 'view') {
                layerExt.open(urlView, {width: '830px', height: '600px', title: '信息详情'});
            }
        })
    });
</script>
