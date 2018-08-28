<?php
use yii\helpers\Url;
?>
<div class="layui-header">
    <div class="layui-logo"><b>产品库后台管理系统</b></div>
    <!-- 头部区域（可配合layui已有的水平导航） -->

    <!--
    <ul class="layui-nav layui-layout-left">
        <li class="layui-nav-item"><a href="">控制台</a ></li>
        <li class="layui-nav-item"><a href="">商品管理</a ></li>
        <li class="layui-nav-item"><a href="">用户</a ></li>
        <li class="layui-nav-item">
            <a href=" ">其它系统</a >
            <dl class="layui-nav-child">
                <dd><a href="">邮件管理</a ></dd>
                <dd><a href="">消息管理</a ></dd>
                <dd><a href="">授权管理</a ></dd>
            </dl>
        </li>
  </ul>
    -->
    <ul class="layui-nav layui-layout-right">
        <li class="layui-nav-item">
            <a href="javascript:;">
                < img src="/static/images/avatar/avatar5.png" class="layui-nav-img">用户名
            </a >
            <dl class="layui-nav-child">
                <dd><a style="cursor: pointer" onclick="changePassword()">修改密码</a ></dd>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="<?=Url::toRoute(['site/logout'])?>" data-method="post">退出</a ></li>
    </ul>
</div>
<script type="text/javascript">
    function changePassword() {
        layui.use(['layer', 'layerExt'], function() {
            var layer = layui.layer;
            layui.layerExt.open('<?=Url::toRoute(['site/change-password'])?>', {width:'460px', height:'400px', title:'修改密码'});
        });
    }
</script>