{%- macro item_info(order) %}
    {% if order.item_type == 'course' %}
        {% set course = order.item_info['course'] %}
        <div class="kg-order-item">
            <p>课程名称：{{ course['title'] }}</p>
            <p>市场价格：￥{{ course['market_price'] }}，会员价格：￥{{ course['vip_price'] }}</p>
            <p>学习期限：{{ course['study_expiry'] }}个月，退款期限：{{ course['refund_expiry'] }}天</p>
        </div>
    {% elseif order.item_type == 'package' %}
        {% set courses = order.item_info['courses'] %}
        {% for course in courses %}
            <div class="kg-order-item">
                <p>课程名称：{{ course['title'] }}</p>
                <p>市场价格：￥{{ course['market_price'] }}，会员价格：￥{{ course['vip_price'] }}</p>
                <p>学习期限：{{ course['study_expiry'] }}个月，退款期限：{{ course['refund_expiry'] }}天</p>
            </div>
        {% endfor %}
    {% elseif order.item_type == 'vip' %}
        {% set vip = order.item_info['vip'] %}
        <div class="kg-order-item">
            <p>商品名称：{{ order.subject }}</p>
            <p>商品价格：￥{{ order.amount }}</p>
        </div>
    {% elseif order.item_type == 'reward' %}
        {% set course = order.item_info['course'] %}
        {% set reward = order.item_info['reward'] %}
        <div class="kg-order-item">
            <p>商品名称：{{ order.subject }}</p>
            <p>商品价格：￥{{ order.amount }}</p>
        </div>
    {% elseif order.item_type == 'test' %}
        <div class="kg-order-item">
            <p>商品名称：{{ order.subject }}</p>
            <p>商品价格：￥{{ order.amount }}</p>
        </div>
    {% endif %}
{%- endmacro %}

{%- macro item_type(value) %}
    {% if value == 'course' %}
        <span class="layui-badge layui-bg-green">课程</span>
    {% elseif value == 'package' %}
        <span class="layui-badge layui-bg-blue">套餐</span>
    {% elseif value == 'vip' %}
        <span class="layui-badge layui-bg-orange">会员</span>
    {% elseif value == 'reward' %}
        <span class="layui-badge layui-bg-red">打赏</span>
    {% elseif value == 'test' %}
        <span class="layui-badge layui-bg-black">测试</span>
    {% endif %}
{%- endmacro %}

{%- macro order_status(value) %}
    {% if value == 'pending' %}
        <span class="layui-badge layui-bg-blue">待支付</span>
    {% elseif value == 'finished' %}
        <span class="layui-badge layui-bg-green">已完成</span>
    {% elseif value == 'closed' %}
        <span class="layui-badge layui-bg-cyan">已关闭</span>
    {% elseif value == 'refunded' %}
        <span class="layui-badge layui-bg-red">已退款</span>
    {% endif %}
{%- endmacro %}