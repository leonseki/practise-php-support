<?php
use yii\helpers\Url;

$this->title = "账号列表";
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_search'); ?>

<table id="account-table" lay-filter="accountTable"></table>

<script type="text/html" id="accountSwitchTpl">
    <input type="checkbox" name="state" value="{{ d.id }}" lay-skin="switch" lay-text="启用|禁用" lay-filter="accountState" {{ d.state == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="account-bar">
    <a class="layui-btn layui-btn-xs" lay-event="update">编辑</a>
</script>

<script type="text/javascript">
    baseConfig = $.extend(baseConfig, {
        urlAdminList: '<?= Url::toRoute(['admin/index', 'is_ajax => 1']) ?>',
        urlAdminUpdate: '<?= Url::toRoute(['admin/update']) ?>'
    });

    layui.use(['table', 'layerExt'], function () {
        let table = layui.table;
        let form = layui.form;
        let layerExt = layui.layerExt;
        table.render({
            elem: '#account-table'
            ,url: baseConfig.urlAdminList
            , page: {
                curr: location.hash.replace('#!page=', '')
                ,hash : 'page'
            }
            , where: {
                'username' : getQueryString('username'),
                'id'       : getQueryString('id'),
            }
            , limit: 15
            , limits: [10, 15, 20, 25]
            , cols: [[
                {type: 'checkbox'}
                ,{field: 'id',              title: 'ID'}
                ,{field: 'username',        title: '用户名'}
                ,{field: 'email',           title: '邮箱'}
                ,{field: 'state',           title: '启用状态', templet: '#accountSwitchTpl'}
                ,{field: 'last_login_ip',   title: '上次访问IP'}
                ,{field: 'last_login_time', title: '上次访问时间'}
                ,{field: 'created_at',      title: '创建时间'}
                ,{fixed: 'right',           title: '操作', width:150, align:'center', toolbar: '#account-bar'}
            ]]
        });

        // 监听启用状态
        form.on('switch(accountState)', function (obj) {
           let _this = this;
           let isCheck = obj.elem.checked;
           $(_this).prop('checked', isCheck==true?false:true);
           form.render();
           layer.confirm('确认要' + (isCheck==true?'启用':'禁用') + '吗?', {icon: 3, title: '提示'}, function (index) {
               let data = {'state' : (isCheck==true?'1':'0')};
               $.post(baseConfig.urlAdminUpdate+'?id='+obj.value, data, function (jsondata) {
                   if (jsondata.code == 1) {
                       $(_this).prop('checked', obj.elem.checked==true?false:true);
                       form.render();
                       layer.close(index);
                   }
                   layer.msg(jsondata.msg);
               });
           });
        });

        // 监听工具条
        table.on('tool(accountTable)', function (obj) {
            let data = obj.data;
            let layEvent = obj.event;
            let urlUpdate = baseConfig.urlAdminUpdate+'?id='+data.id;
            if (layEvent === 'update') {
                layerExt.open(urlUpdate, {width: '460px', height: '400px', title: '信息详情'});
            }
        });
    });
</script>