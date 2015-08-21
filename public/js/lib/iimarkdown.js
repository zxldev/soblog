/**
 * Created by zx on 2015/8/21.
 */
define('iimarkdown',['jquery','showdown','hljs'],function($,showdown,hljs){
    return{
        /**
         * init markdwonEditor
         * @param selector input element,jquery selector
         */
        init:function(selector){
            $(selector).bind('keyup',function(e){
                //press ESC to exit editor
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
                //highlight the code
                $('pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
            }).bind('focus',function(){
                //add editor css ,show viewer
                $(this).addClass('markdown-pen-view');
                $('.markdown-body-view').show();
            }).bind('blur',function(){
                //remove editor css ,hide viewer
                $(this).removeClass('markdown-pen-view');
                $('.markdown-body-view').hide();
            });
        }
    };
});