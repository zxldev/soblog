/**
 * Created by zx on 2015/8/18.
 */
require.config({
    baseUrl: '/js/lib',
    paths: {
        cleanblog: '../app/cleanblog',
        index: '/js/app/index',
        jquery:'/js/lib/jquery.min',
        bootstrap:'/js/lib/bootstrap.min'
    }
});

require(['bootstrap','cleanblog'],function(bootstrap,cleanblog){

});

