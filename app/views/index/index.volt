<div class="row">
    <div id="_bloglist" class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 _bloglist">
        <div class="post"></div>
        {{ content() }}

    </div>
    {{ hidden_field("tag") }}
    <div class="_nav">
        <a class="" href="/api/page=1/blog"></a>
    </div>
</div>

<script>


    require(['domready'], function (domready) {
        domready(function () {
            require(['jquery', 'blog'], function ($, blog) {
                var tag = $('#tag').val() || '';
                blog.blogList(1,tag);
            });
        });
    });
</script>