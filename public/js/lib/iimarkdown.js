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
            },
            isimmediately : true, //if transform text immediately
            selector:'',
            save:function(){
                $(iimarkdown.prototype.selector).blur();
                $(iimarkdown.prototype.selector).parent().removeClass('markdown-pen-view');
                $('.iiMarkdownContainer').hide();
            }
        },
        /**
         * init markdwonEditor
         * @param selector input element,jquery selector
         */
        init: function (selector) {
            iimarkdown.prototype.selector = selector;
            $(selector).addClass('markdown-textarea-view');
            $(selector).before('<div class="iiMarkdownContainer" style="display: none"><div class="markdown-body"><div class="markdown-body-view "></div></div><nav class="navbar navbar-inverse navbar-fixed-bottom markdown-toolbar-view">\
            <div class="container-fluid">\
            <div class="navbar-header">\
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">\
                    <span class="sr-only">Toggle navigation</span>\
                    <span class="icon-bar"></span>\
                    <span class="icon-bar"></span>\
                    <span class="icon-bar"></span>\
                </button>\
                <a class="navbar-brand">IIMarkdownEditor</a>\
            </div>\
                                                                     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">\
                                                                             <ul class="nav navbar-nav navbar-right">\
                                                                                 <li><a href="#">Link</a></li>\
                                                                                 <li><a class="_immedateflaga"><span  class="_immedateflag glyphicon glyphicon-pause" aria-hidden="true">停止同步</span></a></li>\
                                                                                 <li class="dropdown">\
                                                                                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>\
                                                                                     <ul class="dropdown-menu">\
                                                                                         <li><a href="#">Action</a></li>\
                                                                                         <li><a href="#">Another action</a></li>\
                                                                                         <li><a href="#">Something else here</a></li>\
                                                                                         <li role="separator" class="divider"></li>\
                                                                                         <li><a href="#">Separated link</a></li>\
                                                                                     </ul>\
                                                                                 </li>\
                                                                                 <li><a class="iimarkdown-btn-finish">完成</a></li>\
                                                                             </ul>\
                                                                         </div>\
                                                                     </div>\
            </nav></div>');
            $('.iimarkdown-btn-finish').bind('click',function(){
                iimarkdown.prototype.save();
            });
            $('._immedateflaga').bind('click',function(e){
                iimarkdown.updateImmediately();
            });
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
                    if (iimarkdown.prototype.doubleScorllHelper.increament > 3 || iimarkdown.prototype.doubleScorllHelper.increament < -3) {
                        $('.markdown-pen-view .markdown-textarea-view').scrollTop(
                            ($('.markdown-pen-view .markdown-textarea-view')[0].scrollHeight-$('.markdown-pen-view .markdown-textarea-view')[0].clientHeight) /
                            (e.target.scrollHeight - e.target.clientHeight) *
                            e.target.scrollTop);
                    }
                }
            });
            $(selector).bind('keyup', function (e) {
                //press ESC to exit editor
                if (e.keyCode == 27) {
                    iimarkdown.prototype.save();
                    return false;
                }
                //如果按键式ctrl+alt+p , 则切换【是否立即更新状态】
                if(e.ctrlKey&& e.altKey&& e.keyCode==80){
                    iimarkdown.updateImmediately();
                }
                //只有立即更新启用时，才调用更新。
                if(iimarkdown.prototype.isimmediately){
                    iimarkdown.updateMarkdownBody(selector);
                }
            }).bind('focus', function () {
                //add editor css ,show viewer
                $(this).parent().addClass('markdown-pen-view');
                $('.iiMarkdownContainer').show();
            }).bind('blur', function () {
                //remove editor css ,hide viewer
                //$(this).removeClass('markdown-pen-view');
                //$('.markdown-body-view').hide();
            }).bind('scroll', function (e) {
                if (e.target.scrollTop + e.target.clientHeight == e.target.scrollHeight) {
                    $('.markdown-body-view').scrollTop($('.markdown-body-view')[0].scrollHeight);
                } else {
                    $('.markdown-body-view').scrollTop(
                        ($('.markdown-body-view')[0].scrollHeight-$('.markdown-body-view')[0].clientHeight) /
                        (e.target.scrollHeight-e.target.clientHeight) *
                        e.target.scrollTop);
                }
            }).bind('keydown',function(e){
                //disable IE  ESC key default delete text action
                if (e.keyCode == 27) { e.   preventDefault();}
            });
            iimarkdown.updateMarkdownBody(selector);
        },
        updateMarkdownBody:function(selector){
            var converter = new showdown.Converter();
            converter.setFlavor('github');
            $(selector).parent().find('.markdown-body-view').html(converter.makeHtml($(selector).val()));
            //highlight the code
            $('pre code').each(function (i, block) {
                hljs.highlightBlock(block);
            });
        },
        //更新同步状态的显示
        updateImmediately:function(){
            iimarkdown.prototype.isimmediately = !iimarkdown.prototype.isimmediately;
            if(iimarkdown.prototype.isimmediately){
                $('._immedateflag').removeClass('glyphicon-play');
                $('._immedateflag').addClass('glyphicon-pause');
                $('._immedateflag').html('停止同步');
                iimarkdown.updateMarkdownBody(iimarkdown.prototype.selector);
            }else{
                $('._immedateflag').removeClass('glyphicon-pause');
                $('._immedateflag').addClass('glyphicon-play');
                $('._immedateflag').html('开始同步');
            }
        }

    };
    return iimarkdown;
});