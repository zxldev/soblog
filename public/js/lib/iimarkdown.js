/**
 * Created by zx on 2015/8/21.
 */
define('iimarkdown', ['jquery', 'showdown', 'hljs','webuploader'], function ($, showdown, hljs,WebUploader) {
    var iimarkdown =
    {
        prototype: {
            doubleScorllHelper: {//temp var to break chain reaction;
                lastScorll: 1, //last ScorllTop position;
                increament: 0 //compare the last, store the increament
            },
            isimmediately : true, //if transform text immediately
            selector:'',
            uploader:null,
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
                                                                                 <li><a><div class="_insert_pic"><span  class="glyphicon glyphicon-picture" aria-hidden="true">插入图片</span></div></a></li>\
                                                                                 <li><a class="_immedateflaga"><span  class="_immedateflag glyphicon glyphicon-pause" aria-hidden="true">停止同步</span></a></li>\
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
                if (iimarkdown.prototype.uploader == null){
                    iimarkdown.prototype.uploader = WebUploader.create({
                        // 文件接收服务端。
                        server: '/api/upload',
                        auto:true,
                        // 选择文件的按钮。可选。
                        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                        pick: '._insert_pic',

                        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                        resize: false
                    });
                    iimarkdown.prototype.uploader.on( 'uploadSuccess', function( file,response ) {
                        iimarkdown.insertAtCursor(document.getElementById("content"),"![]("+response.url+")\n");
                        iimarkdown.updateMarkdownBody(iimarkdown.prototype.selector);
                    });
                }
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
        },
        insertAtCursor: function (myField, myValue) {
            console.log(myField,myValue);
            //IE support
            if (document.selection) {
                myField.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                sel.select();
            }
            //MOZILLA/NETSCAPE support
            else if (myField.selectionStart || myField.selectionStart == '0') {
                var startPos = myField.selectionStart;
                var endPos = myField.selectionEnd;
                // save scrollTop before insert
                var restoreTop = myField.scrollTop;
                myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
                if (restoreTop > 0) {
                    // restore previous scrollTop
                    myField.scrollTop = restoreTop;
                }
                myField.focus();
                myField.selectionStart = startPos + myValue.length;
                myField.selectionEnd = startPos + myValue.length;
            } else {
                myField.value += myValue;
                myField.focus();
            }
        }

    };
    return iimarkdown;
});