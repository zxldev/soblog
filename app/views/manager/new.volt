
<?php echo $this->tag->form("manager/create") ?>

<table width="100%">
    <tr>
        <td align="left"><?php echo $this->tag->linkTo(array("manager", "Go Back")) ?></td>
        <td align="right"><?php echo $this->tag->submitButton("Save") ?></td>
    </tr>
</table>

<?php echo $this->getContent(); ?>

<div align="center">
    <h1>Create article</h1>
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
            <label for="title">Title</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("title", "size" => 30)) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="contentI">Content</label>
        </td>
        <td align="left">
                <?php echo $this->tag->textArea(array("content", "cols" => 30, "rows" => 4,"class"=>'_showowninput')) ?>
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
            <label for="pic">Pic</label>
        </td>
        <td align="left">
            <?php echo $this->tag->textField(array("pic", "size" => 30)) ?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td><?php echo $this->tag->submitButton("Save") ?></td>
    </tr>
</table>

</form>


<script>

    require(['domready'], function (domReady) {
        domReady(function () {
            require(['iimarkdown'],function(iimark){
                iimark.init('._showowninput');
            });
        });
    });


</script>
