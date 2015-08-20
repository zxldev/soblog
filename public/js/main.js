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
        hljs:'/js/lib/highlight.min'
    }
});

require(['bootstrap','cleanblog','showdown'],function(bootstrap,cleanblog,showdown){
});

