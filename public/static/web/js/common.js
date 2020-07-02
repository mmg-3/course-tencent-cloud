layui.config({
    base: '/static/lib/layui/extends/'
}).extend({
    helper: 'helper'
});

layui.use(['jquery', 'form', 'element', 'layer', 'helper'], function () {

    var $ = layui.jquery;
    var form = layui.form;
    var layer = layui.layer;
    var helper = layui.helper;

    var $token = $('meta[name="csrf-token"]');

    $.ajaxSetup({
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-Csrf-Token', $token.attr('content'));
        }
    });

    setInterval(function () {
        $.ajax({
            type: 'POST',
            url: '/token/refresh',
            success: function (res) {
                $token.attr('content', res.token);
            }
        });
    }, 300000);

    form.on('submit(go)', function (data) {
        var submit = $(this);
        submit.attr('disabled', 'disabled').addClass('layui-btn-disabled');
        $.ajax({
            type: 'POST',
            url: data.form.action,
            data: data.field,
            success: function (res) {
                var icon = res.code === 0 ? 1 : 2;
                if (res.msg) {
                    layer.msg(res.msg, {icon: icon});
                }
                if (res.location) {
                    setTimeout(function () {
                        window.location.href = res.location;
                    }, 1500);
                } else {
                    submit.removeAttr('disabled').removeClass('layui-btn-disabled');
                }
            },
            error: function (xhr) {
                var res = JSON.parse(xhr.responseText);
                layer.msg(res.msg, {icon: 2});
                submit.removeAttr('disabled').removeClass('layui-btn-disabled');
            }
        });
        return false;
    });

    $('.kg-delete').on('click', function () {
        var url = $(this).data('url');
        var tips = '确定要删除吗？';
        layer.confirm(tips, function () {
            $.ajax({
                type: 'POST',
                url: url,
                success: function (res) {
                    layer.msg(res.msg, {icon: 1});
                    if (res.location) {
                        setTimeout(function () {
                            window.location.href = res.location;
                        }, 1500);
                    } else {
                        window.location.reload();
                    }
                },
                error: function (xhr) {
                    var json = JSON.parse(xhr.responseText);
                    layer.msg(json.msg, {icon: 2});
                }
            });
        });
    });

    $('.kg-back').on('click', function () {
        window.history.back();
    });

    $('body').on('click', '.layui-laypage > a', function () {
        var url = $(this).data('url');
        var target = $(this).data('target');
        if (url.length > 0 && target.length > 0) {
            helper.ajaxLoadHtml(url, target);
        }
    });

});