
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("category/index", "返回","class":"btn btn-primary") }}
        </td>
        <td align="right">
            {{ link_to("category/new", "新建 ","class":"btn btn-primary") }}
        </td>
    </tr>
</table>

<table class="browse table table-striped table-bordered table-hover table-responsive" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cate Of Name</th>
            <th>As Of Name</th>
            <th>Parent</th>
            <th>Seo Of Title</th>
            <th>Seo Of Key</th>
            <th>Seo Of Desc</th>
            <th>Created</th>
            <th>Updated</th>

            <th colspan="2">操作</th></tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for category in page.items %}
        <tr>
            <td>{{ category.id }}</td>
            <td>{{ category.cate_name }}</td>
            <td>{{ category.as_name }}</td>
            <td>{{ category.parent_id }}</td>
            <td>{{ category.seo_title }}</td>
            <td>{{ category.seo_key }}</td>
            <td>{{ category.seo_desc }}</td>
            <td>{{ category.created_at }}</td>
            <td>{{ category.updated_at }}</td>
            <td>{{ link_to("category/edit/"~category.id, "编辑","class":"label label-info") }}</td>
            <td>{{ link_to("category/delete/"~category.id, "删除","class":"label label-danger") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="6" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("category/search", "First","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("category/search?page="~page.before, "Previous","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("category/search?page="~page.next, "Next","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("category/search?page="~page.last, "Last","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
