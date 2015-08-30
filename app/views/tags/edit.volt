{{ content() }}
{{ form("tags/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("tags", "返回","class":"btn btn-primary") }}</td>
        <td align="right">{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit tags</h1>
</div>

<table>
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
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("保存","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
