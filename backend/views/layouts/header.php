<?php
use yii\helpers\Url;
?>

<div class="layui-header">
    <div class="layui-logo"><b>后台管理系统</b></div>

    <ul class="layui-nav layui-layout-right">
        <li class="layui-nav-item">
            <a href="javascript:;">
                <img src="/static/images/avatar/avatar.png" class="layui-nav-img"><?= $username ?>
            </a>
            <dl class="layui-nav-child">
                <dd><a style="cursor: pointer" onclick="changePassword()">修改密码</a></dd>>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="<?=Url::toRoute(['site/logout']) ?>" data-method = "post">退出</a></li>
    </ul>
</div>
<script type="text/javascript">
    function changePassword() {
    }
</script>
