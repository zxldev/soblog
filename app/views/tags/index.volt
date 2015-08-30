
{{ content() }}

<div align="right">
    {{ link_to("tags/new", "新建 tags","class":"btn btn-primary") }}
</div>

{{ form("tags/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search tags</h1>
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
            <label for="name">Name</label>
        </td>
        <td align="left">
            {{ text_field("name", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="number">Number</label>
        </td>
        <td align="left">
            {{ text_field("number", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
