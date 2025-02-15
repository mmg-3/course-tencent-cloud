{% extends 'templates/main.volt' %}

{% block content %}

    <form class="layui-form kg-form" method="POST" action="{{ url({'for':'admin.article.create'}) }}">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加文章</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">分类</label>
            <div class="layui-input-block">
                <select name="category_id" lay-verify="required">
                    <option value="">请选择</option>
                    {% for item in categories %}
                        <option value="{{ item.id }}">{{ item.name }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input class="layui-input" type="text" name="title" lay-verify="required">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <button id="kg-submit" class="layui-btn" lay-submit="true" lay-filter="go">提交</button>
                <button type="button" class="kg-back layui-btn layui-btn-primary">返回</button>
            </div>
        </div>
    </form>

{% endblock %}
