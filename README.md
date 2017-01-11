# iiblog

## require
 * php
 * phalcon
 * redis
 * composer

## install
1. install all requirements above
2. copy ```/app/config/config.example.php``` to ```/app/config/config.php``` and complete the config in ```/app/config/config.php```
3. run composer ```composer update```




# iimarkdown
## require
 * jquery
 * showdown
 * hightlight
 * bootstrap
 * tokenfield

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
- [ ] iimarkdown editor toolbar
- [ ] sina qq login
- [ ] rss
- [ ] better way to dispaly blog
- [x] user login and comment
- [ ] tags[tokenfield]
