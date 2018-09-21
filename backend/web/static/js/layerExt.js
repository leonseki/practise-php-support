layui.define(function(exports){
    var obj = {
        open: function (url, optionsObj) {
            // 初始化默认信息
            var title       = '信息框';
            var width       = '800px';
            var height      = '800px';
            var skin        = 'layui-layer-rim';
            var buttons     = ['关闭'];
            var callback    = [];
            var reload      = false;

            // 根据可选参数进行赋值
            if (optionsObj != null) {
                title       = optionsObj.title == undefined ? title : optionsObj.title;
                width       = optionsObj.width == undefined ? width : optionsObj.width;
                height      = optionsObj.width == undefined ? height : optionsObj.height;
                skin        = optionsObj.skin == undefined ? skin : optionsObj.skin;
                buttons     = optionsObj.buttons == undefined ? buttons : optionsObj.buttons;
                callback    = optionsObj.buttonsCallback == undefined ? callback : optionsObj.buttonsCallback;
                reload      = optionsObj.reload == undefined ? reload : optionsObj.reload;
            }

            // 组装layer参数对象
            var obj = {
                type : 2,
                title: title,
                skin: skin,
                area : [width, height],
                btn : buttons,
                content : url,
                end : function () {
                    if (reload) location.reload();
                }
            };
            for (var i = 0, len = callback.length; i < len; i++) {
                var attr = 'btn' + (i + 1);
                if (i == 0) {
                    obj.yes = callback[i];
                } else {
                    obj[attr] = callback[i];
                }
            }

            // 注册原生layer弹层
            layer.open(obj);
        }
    };
    // 输出layerExt接口
    exports('layerExt', obj);
});