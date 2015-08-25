
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("manager/index", "返回","class":"btn btn-primary") }}
        </td>
        <td align="right">
            {{ link_to("manager/new", "新建 ","class":"btn btn-primary") }}
        </td>
    </tr>
</table>

<table class="browse table table-striped table-bordered table-hover table-responsive" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cate</th>
            <th>User</th>
            <th>Title</th>
            <th>Content</th>
            <th>Tags</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Pic</th>

            <th colspan="2">操作</th></tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for article in page.items %}
        <tr>
            <td>{{ article.id }}</td>
            <td>{{ article.cate_id }}</td>
            <td>{{ article.user_id }}</td>
            <td>{{ article.title }}</td>
            <td>{{ substr(article.content,0,400) }}</td>
            <td>{{ article.tags }}</td>
            <td>{{ article.created_at }}</td>
            <td>{{ article.updated_at }}</td>
            <td>{{ article.pic }}</td>
            <td>{{ link_to("manager/edit/"~article.id, "编辑","class":"label label-info") }}</td>
            <td>{{ link_to("manager/delete/"~article.id, "删除","class":"label label-danger") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="12" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("manager/search", "First","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("manager/search?page="~page.before, "Previous","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("manager/search?page="~page.next, "Next","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("manager/search?page="~page.last, "Last","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
