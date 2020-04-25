{%- macro position_info(value) %}
    {% if value == 'top' %}
        <span class="layui-badge layui-bg-green">顶部</span>
    {% elseif value == 'bottom' %}
        <span class="layui-badge layui-bg-blue">底部</span>
    {% endif %}
{%- endmacro %}

{%- macro target_info(value) %}
    {% if value == '_blank' %}
        <span class="layui-badge layui-bg-green">新窗口</span>
    {% elseif value == '_self' %}
        <span class="layui-badge layui-bg-blue">原窗口</span>
    {% endif %}
{%- endmacro %}

<div class="kg-nav">
    <div class="kg-nav-left">
        <span class="layui-breadcrumb">
            {% if parent.id > 0 %}
                <a class="kg-back" href="{{ url({'for':'admin.nav.list'}) }}">
                    <i class="layui-icon layui-icon-return"></i> 返回
                </a>
                <a><cite>{{ parent.name }}</cite></a>
            {% endif %}
            <a><cite>导航管理</cite></a>
        </span>
    </div>
    <div class="kg-nav-right">
        <a class="layui-btn layui-btn-sm" href="{{ url({'for':'admin.nav.add'},{'parent_id':parent.id}) }}">
            <i class="layui-icon layui-icon-add-1"></i>添加导航
        </a>
    </div>
</div>

<table class="kg-table layui-table layui-form">
    <colgroup>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col width="12%">
    </colgroup>
    <thead>
    <tr>
        <th>编号</th>
        <th>名称</th>
        <th>层级</th>
        <th>节点数</th>
        <th>位置</th>
        <th>目标</th>
        <th>排序</th>
        <th>发布</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    {% for item in navs %}
        <tr>
            <td>{{ item.id }}</td>
            {% if item.position == 'top' and item.level < 2 %}
                <td><a href="{{ url({'for':'admin.nav.list'},{'parent_id':item.id}) }}">{{ item.name }}</a></td>
            {% else %}
                <td>{{ item.name }}</td>
            {% endif %}
            <td><span class="layui-badge layui-bg-gray">{{ item.level }}</span></td>
            <td><span class="layui-badge layui-bg-gray">{{ item.child_count }}</span></td>
            <td>{{ position_info(item.position) }}</td>
            <td>{{ target_info(item.target) }}</td>
            <td><input class="layui-input kg-priority-input" type="text" name="priority" title="数值越小排序越靠前" value="{{ item.priority }}" data-url="{{ url({'for':'admin.nav.update','id':item.id}) }}"></td>
            <td><input type="checkbox" name="published" value="1" lay-skin="switch" lay-text="是|否" lay-filter="published" data-url="{{ url({'for':'admin.nav.update','id':item.id}) }}" {% if item.published == 1 %}checked{% endif %}></td>
            <td align="center">
                <div class="layui-dropdown">
                    <button class="layui-btn layui-btn-sm">操作 <span class="layui-icon layui-icon-triangle-d"></span></button>
                    <ul>
                        <li><a href="{{ url({'for':'admin.nav.edit','id':item.id}) }}">编辑</a></li>
                        {% if item.deleted == 0 %}
                            <li><a href="javascript:" class="kg-delete" data-url="{{ url({'for':'admin.nav.delete','id':item.id}) }}">删除</a></li>
                        {% else %}
                            <li><a href="javascript:" class="kg-restore" data-url="{{ url({'for':'admin.nav.restore','id':item.id}) }}">还原</a></li>
                        {% endif %}
                    </ul>
                </div>
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>