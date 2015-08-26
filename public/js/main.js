/**
 * Created by zx on 2015/8/18.
 */
require.config({
    baseUrl: '/js/lib',
    paths: {
        cleanblog: '/js/app/cleanblog',
        blog: '/js/app/blog',
        jquery:['http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min','/js/lib/jquery.min'],
        showdown:'/js/lib/showdown',
        hljs:['http://apps.bdimg.com/libs/highlight.js/8.6/highlight.min','/js/lib/highlight.min'],
        iimarkdown:'/js/lib/iimarkdown',
        domready:'/js/domready'
    }
});

require(['jquery','blog','bootstrap','cleanblog'],function($,blog,bootstrap,cleanblog){
    $(document)
        .on('click', '._btn_end_session', function () {
            blog.logout();
        })

});



