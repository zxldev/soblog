# iiblog

##require
 * php
 * phalcon
 * xcache
 * redis




# iimarkdown
##require
 * jquery
 * showdown
 * hightlight
 * bootstrap

```javascript
$('').bind('scroll', function (e) {
                if (e.target.scrollTop + e.target.clientHeight == e.target.scrollHeight) {
                    $('.markdown-body-view').scrollTop($('.markdown-body-view')[0].scrollHeight);
                } else {
                    $('.markdown-body-view').scrollTop(
                        ($('.markdown-body-view')[0].scrollHeight-$('.markdown-body-view')[0].clientHeight) /
                        (e.target.scrollHeight-e.target.clientHeight) *
                        e.target.scrollTop);
                }
            })
```

##TODO list
  * iimarkdown editor toolbar
  * sina qq login
  * rss
  * a better way to dispaly blog
  * user login and comment
