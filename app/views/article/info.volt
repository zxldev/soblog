<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="_blogInfo"></div>
        <div id="disqus_thread"></div>
    </div>
</div>

<script>

    require(['domready'], function (domready) {
        domready(function () {
            require(['jquery', 'blog'], function ($, blog) {
                blog.blogInfo({{blogid}});
            });
        });
    });

</script>