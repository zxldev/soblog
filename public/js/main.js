/**
 * Created by zx on 2015/8/18.
 */
require.config({
    baseUrl: '/js/lib',
    paths: {
        cleanblog: '/js/app/cleanblog',
        blog: '/js/app/blog',
        jquery:'/js/lib/jquery.min',
        bootstrap:'/js/lib/bootstrap.min',
        showdown:'/js/lib/showdown',
        hljs:'/js/lib/highlight.min',
        iimarkdown:'/js/lib/iimarkdown',
        domready:'/js/lib/domReady'
    }
});

require(['jquery','blog'],function($,blog){
    $(document)
        .on('click', '._btn_end_session', function () {
            blog.logout();
        })

});



