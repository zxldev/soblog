{{ content() }}
{{ form("systems/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("systems", "Go Back","class":"btn btn-primary") }}</td>
        <td align="right">{{ submit_button("Save","class":"btn btn-primary") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit systems</h1>
</div>

<table>
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
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save","class":"btn btn-primary") }}</td>
    </tr>
</table>

</form>
