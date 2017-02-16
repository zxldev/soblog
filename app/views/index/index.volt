<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="_cate_title">{% if  cateEntity is not empty %} <h1><i class="{{ cateEntity.class_name }}"></i> {{ cateEntity.cate_name }} </h1>{% endif %}{% if tag %} <h1><i class="glyphicon glyphicon-tag"></i> {{ tag }} </h1>{% endif %}</div>
        <div id="_bloglist" class="_bloglist">
            <div class="post"></div>
            {{ content() }}
        </div>
    </div>

    {{ hidden_field("tag") }}
    {{ hidden_field("cate") }}
    {{ hidden_field("searchtext") }}
    <div class="_nav">
        <a class="" href="/api/page=1/blog"></a>
    </div>
</div>

<script>


    require(['domready'], function (domready) {
        domready(function () {
            require(['jquery', 'blog'], function ($, blog) {
                var tag = $('#tag').val() || '',
                        text = $('#searchtext').val() || '',
                        cate = $('#cate').val() || '';
                blog.blogList(1,tag,cate,text);

                $('._blog_search').val(text);
                $('._blog_search').bind('keyup',function(e){
                    if (e.keyCode == 13) {
                        window.location.href = '/page=1/tag=/cate=/text='+encodeURIComponent($(this).val())
                    }
                });
            });
        });
    });
</script>