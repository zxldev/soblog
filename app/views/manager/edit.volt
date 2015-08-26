{{ content() }}
{{ form("manager/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("manager", "返回","class":"btn btn-primary") }}</td>
        <td align="right">{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit article</h1>
</div>

<table>
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
                {{ text_area("content", "cols": "30", "rows": "4","class":"form-control _showowninput") }}
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
            <label for="pic">Pic</label>
        </td>
        <td align="left">
            {{ text_field("pic", "size" : 30,"class":"form-control") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>

<script>

    require(['domready'], function (domready) {
        domready(function () {
            require(['iimarkdown'],function(iimark){
                iimark.init('._showowninput');
            });
        });
    });


</script>
