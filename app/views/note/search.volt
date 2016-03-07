
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("note/index", "返回","class":"btn btn-primary") }}
        </td>
        <td align="right">
            {{ link_to("note/new", "新建 ","class":"btn btn-primary") }}
        </td>
    </tr>
</table>

<table class="browse table table-striped table-bordered table-hover table-responsive" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Content</th>
            <th>Created</th>
            <th>State</th>

            <th colspan="2">操作</th></tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for note in page.items %}
        <tr>
            <td>{{ note.id }}</td>
            <td>{{ note.content }}</td>
            <td>{{ note.created_at }}</td>
            <td>{{ note.state }}</td>
            <td>{{ link_to("note/edit/"~note.id, "编辑","class":"label label-info") }}</td>
            <td>{{ link_to("note/delete/"~note.id, "删除","class":"label label-danger") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="6" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("note/search", "First","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("note/search?page="~page.before, "Previous","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("note/search?page="~page.next, "Next","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ link_to("note/search?page="~page.last, "Last","class":"btn btn-default btn-sm") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
