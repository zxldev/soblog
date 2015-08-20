<?php use Phalcon\Tag; ?>

<?php echo $this->getContent(); ?>

<table width="100%">
    <tr>
        <td align="left">
            <?php echo $this->tag->linkTo(array("manager/index", "Go Back")); ?>
        </td>
        <td align="right">
            <?php echo $this->tag->linkTo(array("manager/new", "Create ")); ?>
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cate</th>
            <th>User</th>
            <th>Title</th>
            <th>Content</th>
            <th>Tags</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Pic</th>
         </tr>
    </thead>
    <tbody>
    <?php foreach ($page->items as $article) { ?>
        <tr>
            <td><?php echo $article->id ?></td>
            <td><?php echo $article->cate_id ?></td>
            <td><?php echo $article->user_id ?></td>
            <td><?php echo $article->title ?></td>
            <td><?php echo $article->content ?></td>
            <td><?php echo $article->tags ?></td>
            <td><?php echo $article->created_at ?></td>
            <td><?php echo $article->updated_at ?></td>
            <td><?php echo $article->pic ?></td>
            <td><?php echo $this->tag->linkTo(array("manager/edit/" . $article->id, "Edit")); ?></td>
            <td><?php echo $this->tag->linkTo(array("manager/delete/" . $article->id, "Delete")); ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td><?php echo $this->tag->linkTo("manager/search", "First") ?></td>
                        <td><?php echo $this->tag->linkTo("manager/search?page=" . $page->before, "Previous") ?></td>
                        <td><?php echo $this->tag->linkTo("manager/search?page=" . $page->next, "Next") ?></td>
                        <td><?php echo $this->tag->linkTo("manager/search?page=" . $page->last, "Last") ?></td>
                        <td><?php echo $page->current, "/", $page->total_pages ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
