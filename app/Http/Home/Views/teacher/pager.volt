{% if pager.total_pages > 0 %}
    <div class="user-list teacher-list clearfix">
        <div class="layui-row layui-col-space20">
            {% for item in pager.items %}
                {% set item.title = item.title ? item.title : '小小教书匠' %}
                {% set item.about = item.about ? item.about : '这个人很懒，什么都没留下' %}
                {% set user_url = url({'for':'home.teacher.show','id':item.id}) %}
                <div class="layui-col-md3">
                    <div class="user-card">
                        <div class="avatar">
                            <a href="{{ user_url }}" title="{{ item.about }}" target="_blank">
                                <img src="{{ item.avatar }}!avatar_160" alt="{{ item.name }}">
                            </a>
                        </div>
                        <div class="name layui-elip">
                            <a href="{{ user_url }}" title="{{ item.about }}" target="_blank">{{ item.name }}</a>
                        </div>
                        <div class="title layui-elip">{{ item.title }}</div>
                        <div class="action">
                            <span class="layui-btn apply-friend" data-id="{{ item.id }}" data-name="{{ item.name }}" data-avatar="{{ item.avatar }}">添加好友</span>
                        </div>
                    </div>
                </div>
            {% endfor %}
        </div>
    </div>
    {{ partial('partials/pager_ajax') }}
{% endif %}
