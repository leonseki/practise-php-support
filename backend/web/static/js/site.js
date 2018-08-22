var baseConfig = {};

/**
 * 获取URL中的参数
 * @param name
 * @returns {null}
 */

function getQueryString(name)
{
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]);return null;
}

function showRate(num)
{
    var html = '';
    for (var i = num; i >= 1; i--) {
        html += '<i class="layui-icon layui-icon-rate-solid" style="font-size:20px;color:#FF8C69;"></i>';
    }
}