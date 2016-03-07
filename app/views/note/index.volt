
{{ content() }}

<div align="right">
    {{ link_to("note/new", "新建 note","class":"btn btn-primary") }}
</div>

{{ form("note/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search note</h1>
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
            <label for="content">Content</label>
        </td>
        <td align="left">
                {{ text_area("content", "cols": "30", "rows": "4","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="created_at">Created</label>
        </td>
        <td align="left">
            {{ text_field("created_at", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="state">State</label>
        </td>
        <td align="left">
            {{ text_field("state", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
