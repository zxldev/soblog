
{{ content() }}

<div align="right">
    {{ link_to("manager/new", "新建 article","class":"btn btn-primary") }}
</div>

{{ form("manager/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search article</h1>
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
            <label for="cate_id">Cate</label>
        </td>
        <td align="left">
            {{ text_field("cate_id", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="user_id">User</label>
        </td>
        <td align="left">
            {{ text_field("user_id", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="title">Title</label>
        </td>
        <td align="left">
            {{ text_field("title", "size" : 30,"class":"form-control") }}
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
            <label for="tags">Tags</label>
        </td>
        <td align="left">
            {{ text_field("tags", "size" : 30,"class":"form-control") }}
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
            <label for="updated_at">Updated</label>
        </td>
        <td align="left">
            {{ text_field("updated_at", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="pic">Pic</label>
        </td>
        <td align="left">
            {{ text_field("pic", "size" : 30,"class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
