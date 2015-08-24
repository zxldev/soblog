
{{ content() }}

<div align="right">
    {{ link_to("systems/new", "Create systems","class":"btn btn-primary") }}
</div>

{{ form("systems/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search systems</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="id">Id</label>
        </td>
        <td align="left">
            {{ text_field("id", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cate">Cate</label>
        </td>
        <td align="left">
            {{ text_field("cate", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="system_name">System Of Name</label>
        </td>
        <td align="left">
            {{ text_field("system_name", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="system_value">System Of Value</label>
        </td>
        <td align="left">
            {{ text_field("system_value", "size" : 30,"class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
