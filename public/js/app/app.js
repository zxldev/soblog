/**
 * Created by zxldev on 2015/11/2.
 */
define(['jquery', 'blog', 'bootstrap', 'cleanblog'], function ($, blog) {
    JQuery = $;
    $(document)
        .on('click', '._btn_end_session', function () {
            blog.logout();
        })
        .on('click', '._btn_start_session', function () {
            window.location.href = '/session/index?callback=' + encodeURIComponent(window.location.pathname + window.location.search);
        });
});