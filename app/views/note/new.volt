
{{ form("note/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("note", "返回","class":"btn btn-primary") }}</td>
        <td align="right">{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create note</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="content">Content</label>
        </td>
        <td align="left">
                {{ text_area("content", "cols": "30", "rows": "4","class":"form-control") }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
