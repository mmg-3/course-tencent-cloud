{% set owner_url = url({'for':'home.user.show','id':group.owner.id}) %}
{% set group.owner.title = group.owner.title ? group.owner.title : '暂无头衔' %}

<div class="layui-card">
    <div class="layui-card-header">小组组长</div>
    <div class="layui-card-body">
        <div class="sidebar-user-card clearfix">
            <div class="avatar">
                <img src="{{ group.owner.avatar }}" alt="{{ group.owner.name }}">
            </div>
            <div class="info">
                <div class="name layui-elip">
                    <a href="{{ owner_url }}" title="{{ group.owner.about }}" target="_blank">{{ group.owner.name }}</a>
                </div>
                <div class="title layui-elip">{{ group.owner.title }}</div>
            </div>
        </div>
    </div>
</div>