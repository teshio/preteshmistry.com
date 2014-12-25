var main = {
    loadTweets: function () {
        $.getJSON('./twitter.php', {q: 'news'}, function (json) {

            var tweets = json.statuses;

            for (var i = 0; i < tweets.length; i++) {
                var t = tweets[i];
                var text = t.text;
                
                var r = Math.random();
                
                var user = '{0} - {1}'.format(t.user.screen_name, t.created_at);
                
                var html = '<div class="tweet" data-depth="{1}" style="display:none;">{0}<div class="user">{2}</div></div>'.format(
                    text, 
                    r,
                    user);
                
                $('#tweets').append(html);               
                
                //console.log();
            }
                $('.tweet').slideDown('slow');
            console.log(json);
            //var parallax = new Parallax($('#tweets').get(0));
        });
    }
};

if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
        });
    };
}

$(function () {
    main.loadTweets();
});

