
{{ content() }}

<div align="right">
    {{ link_to("category/new", "新建 category","class":"btn btn-primary") }}
</div>

{{ form("category/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search category</h1>
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
            <label for="cate_name">Cate Of Name</label>
        </td>
        <td align="left">
            {{ text_field("cate_name", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="as_name">As Of Name</label>
        </td>
        <td align="left">
            {{ text_field("as_name", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="parent_id">Parent</label>
        </td>
        <td align="left">
            {{ text_field("parent_id", "type" : "numeric","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="seo_title">Seo Of Title</label>
        </td>
        <td align="left">
            {{ text_field("seo_title", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="seo_key">Seo Of Key</label>
        </td>
        <td align="left">
            {{ text_field("seo_key", "size" : 30,"class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="seo_desc">Seo Of Desc</label>
        </td>
        <td align="left">
            {{ text_field("seo_desc", "size" : 30,"class":"form-control") }}
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
            <label for="class_name">Class Of Name</label>
        </td>
        <td align="left">
            {{ text_field("class_name", "size" : 30,"class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
