
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("tags/index", "返回","class":"btn btn-primary") }}
        </td>
        <td align="right">
            {{ link_to("tags/new", "新建 ","class":"btn btn-primary") }}
        </td>
    </tr>
</table>

<table class="browse table table-striped table-bordered table-hover table-responsive" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Number</th>

            <th colspan="2">操作</th></tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for tagentity in page.items %}
        <tr>
            <td>{{ tagentity.id }}</td>
            <td>{{ tagentity.name }}</td>
            <td>{{ tagentity.number }}</td>
            <td>{{ link_to("tags/edit/"~tagentity.id, "编辑","class":"label label-info") }}</td>
            <td>{{ link_to("tags/delete/"~tagentity.id, "删除","class":"label label-danger") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="6" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("tags/search", "First","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("tags/search?page="~page.before, "Previous","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("tags/search?page="~page.next, "Next","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("tags/search?page="~page.last, "Last","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
