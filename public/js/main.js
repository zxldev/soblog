/**
 * Created by zx on 2015/8/18.
 */
require.config({
    baseUrl: '/js/lib',
    waitSeconds: 100,
    paths: {
        app: '/js/app/app',
        cleanblog: '/js/app/cleanblog',
        blog: '/js/app/blog',
        userconfig:'/js/app/user',
        jquery:['http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min','/js/jquery'],
        showdown:'/js/lib/showdown',
        hljs:'/js/lib/highlight.min',
        iimarkdown:'/js/lib/iimarkdown',
        domready:'/js/domready',
        bootstrap:'/js/lib/bootstrap.min',
        qrcode:'//cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min',
        tokenfield:['http://cdn.bootcss.com/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.min','/js/lib/bootstrap-tokenfield.min'],
        infintescroll:['http://apps.bdimg.com/libs/jquery.infinitescroll.js/2.0.2/jquery.infinitescroll','/js/lib/jquery.infinitescroll'],
        alertify:['http://cdn.bootcss.com/AlertifyJS/1.8.0/alertify']
    }
});

require(['app']);



