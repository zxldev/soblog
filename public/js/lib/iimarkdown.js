/**
 * Created by zx on 2015/8/21.
 */
define('iimarkdown',['jquery','showdown'],function($,showdown){
    return{
        init:function(selector){
            $(selector).bind('keyup',function(e){
                if(e.keyCode==27){
                    $(this).blur();
                    return;
                }
                var converter = new showdown.Converter();
                var has = $(selector).parent().find('.markdown-body-view');
                if(has.length){
                    has.html(converter.makeHtml($(selector).val()));
                }else{
                    $(selector).parent().append('<div class="markdown-body-view">'+converter.makeHtml($(selector).val())+'</div>');
                }
                $('pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
            }).bind('focus',function(){
                $(this).addClass('markdown-pen-view');
                $('.markdown-body-view').show();
            }).bind('blur',function(){
                $(this).removeClass('markdown-pen-view');
                $('.markdown-body-view').hide();
            });

        }
    };
})