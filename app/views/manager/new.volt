
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
        <td></td>
        <td><?php echo $this->tag->submitButton("Save") ?></td>
    </tr>
</table>

</form>


<script>
    setTimeout(require(['iimarkdown'],function(iimark){
        iimark.init('._showowninput');
    }),100);
//    require(['jquery','showdown'],function($,showdown){
//        var selector = '._showowninput';
//        $(selector).bind('keyup',function(){
//            var converter = new showdown.Converter();
//            var has = $(selector).parent().find('.markdown-body-view');
//            if(has.length){
//                has.html(converter.makeHtml($(selector).val()));
//            }else{
//                $(selector).parent().append('<div class="markdown-body-view">'+converter.makeHtml($(selector).val())+'</div>');
//            }
//            $('pre code').each(function(i, block) {
//                hljs.highlightBlock(block);
//            });
//        }).bind('focus',function(){
//            $(this).addClass('markdown-pen-view');
//        }).bind('blur',function(){
//            $(this).removeClass('markdown-pen-view');
//        });
//
//    })

</script>
