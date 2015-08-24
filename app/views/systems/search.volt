
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("systems/index", "Go Back","class":"btn btn-primary") }}
        </td>
        <td align="right">
            {{ link_to("systems/new", "Create ","class":"btn btn-primary") }}
        </td>
    </tr>
</table>

<table class="browse table table-striped table-bordered table-hover table-responsive" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cate</th>
            <th>System Of Name</th>
            <th>System Of Value</th>

            <th colspan="2">操作</th></tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for system in page.items %}
        <tr>
            <td>{{ system.id }}</td>
            <td>{{ system.cate }}</td>
            <td>{{ system.system_name }}</td>
            <td>{{ system.system_value }}</td>
            <td>{{ link_to("systems/edit/"~system.id, "Edit") }}</td>
            <td>{{ link_to("systems/delete/"~system.id, "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("systems/search", "First") }}</td>
                        <td>{{ link_to("systems/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("systems/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("systems/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
