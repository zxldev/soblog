{{ content() }}
{{ form("category/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("category", "返回","class":"btn btn-primary") }}</td>
        <td align="right">{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit category</h1>
</div>

<table>
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
            <label for="class_name">Class Of Name</label>
        </td>
        <td align="left">
            {{ text_field("class_name", "size" : 30,"class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
