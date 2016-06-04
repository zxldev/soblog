
{{ form("manager/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("manager", "返回","class":"btn btn-primary") }}</td>
        <td align="right">{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create article</h1>
</div>

<table>
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
            <label for="cate_id">Cate</label>
        </td>
        <td align="left">
            {{ selectstatic(['cate_id', cates, 'using': ['id', 'cate_name'], 'useEmpty': false, 'emptyText': '请选择分类...', 'emptyValue': '@','class':'form-control']) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tags">Tags</label>
        </td>
        <td align="left">
            {{ text_field("tags", "size" : 30,"class":"form-control","id":"tags") }}
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
        <td></td>
        <td>{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>


<script>

    require(['domready'], function (domready) {
        domready(function () {
            require(['iimarkdown','tokenfield'],function(iimark,tokenfield){
                iimark.init('._showowninput');
                $('#tags').tokenfield();
            });
        });
    });


</script>
