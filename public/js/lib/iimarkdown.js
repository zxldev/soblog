/**
 * Created by zx on 2015/8/21.
 */
define('iimarkdown', ['jquery', 'showdown', 'hljs'], function ($, showdown, hljs) {
    var iimarkdown =
    {
        prototype: {
            doubleScorllHelper: {//temp var to break chain reaction;
                lastScorll: 1, //last ScorllTop position;
                increament: 0 //compare the last, store the increament
            }
        },
        /**
         * init markdwonEditor
         * @param selector input element,jquery selector
         */
        init: function (selector) {
            $(selector).addClass('markdown-textarea-view');
            $(selector).before('<div class="markdown-body-view" style="display: none"></div><nav class="navbar navbar-inverse navbar-fixed-bottom markdown-toolbar-view"></nav>');
            $('.markdown-body-view').bind('scroll', function (e) {
                iimarkdown.prototype.doubleScorllHelper.increament = e.target.scrollTop - iimarkdown.prototype.doubleScorllHelper.lastScorll;
                iimarkdown.prototype.doubleScorllHelper.lastScorll = e.target.scrollTop;
                if (e.target.scrollTop + e.target.clientHeight == e.target.scrollHeight) {
                    $('.markdown-pen-view .markdown-textarea-view').scrollTop($('.markdown-pen-view .markdown-textarea-view')[0].scrollHeight);
                } else {
                    //if the increament > 2 ,
                    // means user operation,do
                    // then,
                    // chain reaction,do nothing
                    if (iimarkdown.prototype.doubleScorllHelper.increament > 2 || iimarkdown.prototype.doubleScorllHelper.increament < -2) {
                        $('.markdown-pen-view .markdown-textarea-view').scrollTop(
                            $('.markdown-pen-view .markdown-textarea-view')[0].scrollHeight /
                            e.target.scrollHeight *
                            e.target.scrollTop);
                    }
                }
            });
            $(selector).bind('keyup', function (e) {
                //press ESC to exit editor
                if (e.keyCode == 27) {
                    $(this).blur();
                    $(this).parent().removeClass('markdown-pen-view');
                    $('.markdown-body-view').hide();
                    return;
                }
                var converter = new showdown.Converter();
debugger;
                $(selector).parent().find('.markdown-body-view').html(converter.makeHtml($(selector).val()));
                //highlight the code
                $('pre code').each(function (i, block) {
                    hljs.highlightBlock(block);
                });
            }).bind('focus', function () {
                //add editor css ,show viewer
                $(this).parent().addClass('markdown-pen-view');
                $('.markdown-body-view').show();
            }).bind('blur', function () {
                //remove editor css ,hide viewer
                //$(this).removeClass('markdown-pen-view');
                //$('.markdown-body-view').hide();
            }).bind('scroll', function (e) {
                if (e.target.scrollTop + e.target.clientHeight == e.target.scrollHeight) {
                    $('.markdown-body-view').scrollTop($('.markdown-body-view')[0].scrollHeight);
                } else {
                    $('.markdown-body-view').scrollTop(
                        $('.markdown-body-view')[0].scrollHeight /
                        e.target.scrollHeight *
                        e.target.scrollTop);
                }
            });
        }
    };
    return iimarkdown;
});