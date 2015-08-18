


    define( "index", ['jquery'], function($) {
        var exports = {
            blogList: function (page){
                page=page||1;
                $.ajax({
                    url: '/api/blog/'+page,
                    type: 'get',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        var i = 0,
                            html='',
                            length = data.records.items.length;
                        for(i=0;i<length;i++){
                            html+='<div class="post-preview">\
                            <a href="post.html">\
                            <h2 class="post-title">'+data.records.items[i].title+'</h2>\
                            <h3 class="post-subtitle">'+data.records.items[i].content+'</h3>\
                            </a>\
                                <p class="post-meta">发布于'+data.records.items[i].updated_at+'</p>\
                            </div>\
                            <hr>'
                        }
                        html+=' <ul class="pager">\
                        <li class="next">\
                        <a href="#">更多 &rarr;</a>\
                        </li>\
                        </ul>';
                        $('._bloglist').html(html);





                    }
                });
            }
        };
        return exports;
    });
