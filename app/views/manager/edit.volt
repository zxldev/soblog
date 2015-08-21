
<?php echo $this->getContent(); ?>

<?php echo $this->tag->form("manager/save") ?>

<table width="100%">
    <tr>
        <td align="left"><?php echo $this->tag->linkTo(array("manager", "Back")) ?></td>
        <td align="right"><?php echo $this->tag->submitButton("Save") ?></td>
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
            <?php echo $this->tag->textField(array("cate_id", "type" => "number")) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="user_id">User</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("user_id", "type" => "number")) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="title">Title</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("title", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="content">Content</label>
        </td>
        <td align="left">
                <?php echo $this->tag->textArea(array("content", "cols" => 30, "rows" => 4)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tags">Tags</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("tags", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="created_at">Created</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("created_at", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="updated_at">Updated</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("updated_at", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="pic">Pic</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("pic", "size" => 30)) ?>
        </td>
    </tr>

    <tr>
        <td><?php echo $this->tag->hiddenField("id") ?></td>
        <td><?php echo $this->tag->submitButton("Save") ?></td>
    </tr>
</table>

</form>
