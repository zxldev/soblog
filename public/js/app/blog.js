


    define( "blog", ['jquery','showdown','hljs','infintescroll'], function($,showdown,hljs,infintescroll) {
        var exports = {
            //记录博客总页数，用于翻页
            blogTotalPages:1,
            //根据页码生成ajax请求链接
            pageUrl:function(page){
                debugger;
                return "/api/page="+page+"/blog";
            },
            //ajax回调绘制列表页面
            buildListPage:function(data){
                exports.blogTotalPages = data.records.total_pages;
                var i = 0,
                    html='',
                    length = data.records.items.length;
                for(i=0;i<length;i++){
                    html+='<div class="post-preview">\
                            <a href="/article/info/'+data.records.items[i].id+'">\
                            <h2 class="post-title">'+data.records.items[i].title+'</h2>\
                            </a>\
                            <h4  class="post-subtitle">';
                    if(data.records.items[i].tags.length > 0){
                        var tag,tags = data.records.items[i].tags.split(',');
                        $.each(tags,function(i,tag){
                            html+='<span  class="'+exports.calClass(tag)+'">'+tag+'</span>'
                        });
                    }
                    html+='</h4>\
                                <p class="post-meta">发布于'+data.records.items[i].updated_at+'</p>\
                            </div>\
                            <hr>'
                }
                $('._bloglist').append(html);
            },
            //无限翻页控件
            infiniteScrollList:function(){
                $('._bloglist').infinitescroll({
                    loading: {
                        finished: undefined,
                        finishedMsg: "<em>已经到达最后一页，无更多内容。</em>",
                        img: null,
                        msg: null,
                        msgText: "<em>载入下一页中s...</em>",
                        selector: null,
                        speed: 'fast',
                        start: undefined
                    },
                    //behavior: '/api/page=1/blog',
                    nextSelector: "._nav a:first",
                    navSelector: "._nav",
                    itemSelector: ".post",
                    //animate: true,
                    dataType: 'json',
                    appendCallback: false,
                    //bufferPx: 40,
                    errorCallback: function () {},
                    infid: undefined, //Instance ID
                    path: exports.pageUrl, // Can either be an array of URL parts
                    //(e.g. ["/page/", "/"]) or a function that accepts the page number and returns a URL
                    maxPage: exports.blogTotalPages||1// to manually control maximum page (when maxPage is undefined, maximum page limitation is not work)
                },function(data,opts){
                    exports.buildListPage(data);
                });
            },
            //ajax请求博客列表首页
            blogList: function (page){
                page=page||1;
                $.ajax({
                    url: '/api/page='+page+'/blog',
                    type: 'get',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        exports.buildListPage(data);
                        exports.infiniteScrollList();
                    }
                });
            },
            //博客详情页面
            blogInfo:function(id){
                id=id||1;
                $.ajax({
                    url: '/api/id='+id+'/blog',
                    type: 'get',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        var blog = data.records,
                            html=' <ul class="pager">\
                        <li class="next">\
                        <a href="/"> &larr;返回</a>\
                        </li>\
                        </ul>';
                        var converter = new showdown.Converter();
                        converter.setOption();
                        $('._blogInfo').html('<div class="markdown-body">'+converter.makeHtml(blog.content)+'</div>'+html);
                        $('pre code').each(function(i, block) {
                            hljs.highlightBlock(block);
                        });
                        $('._mainheading').html(blog.title);
                        $('._subheading').html('')


                    }
                });
            },
            logout:function(){
                $.ajax({
                    url: '/session/end',
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        window.location.href=window.location.origin;
                    },
                    error:function(data){
                        window.location.href=window.location.origin;
                    }
                });
            },
            tagClass :{
                a:"label label-default",
                b:"label label-primary",
                c:"label label-success",
                d:"label label-info",
                e:"label label-warning",
                f:"label label-danger"
            },
            calClass:function(tagName){
                switch (tagName.length%7){
                    case 1:return exports.tagClass.a;break;
                    case 2:return exports.tagClass.b;break;
                    case 3:return exports.tagClass.c;break;
                    case 4:return exports.tagClass.d;break;
                    case 5:return exports.tagClass.e;break;
                    case 6:return exports.tagClass.f;break;
                    default: return exports.tagClass.a;
                }
            }
        };
        return exports;
    });
