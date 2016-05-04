/**
 * Created by zx on 2015/8/18.
 */
require.config({
    baseUrl: '/js/lib',
    paths: {
        app: '/js/app/app',
        cleanblog: '/js/app/cleanblog',
        blog: '/js/app/blog',
        jquery:['http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min','/js/jquery'],
        showdown:'/js/lib/showdown',
        hljs:'/js/lib/highlight.min',
        iimarkdown:'/js/lib/iimarkdown',
        domready:'/js/domready',
        bootstrap:'/js/lib/bootstrap.min',
        tokenfield:['http://cdn.bootcss.com/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.min','/js/lib/bootstrap-tokenfield.min'],
        infintescroll:['http://apps.bdimg.com/libs/jquery.infinitescroll.js/2.0.2/jquery.infinitescroll','/js/lib/jquery.infinitescroll']
    }
});

require(['app']);



