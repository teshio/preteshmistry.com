var main = {
    loadTweets: function () {
        $.getJSON('./twitter.php', {q: 'news'}, function (json) {

            var tweets = json.statuses;

            for (var i = 0; i < tweets.length; i++) {
                var t = tweets[i];
                var text = t.text;
                var html = '<div class="tweet" style="display:none;">{0}</div>'.format(text);
                
                $('#tweets').append(html);               
                
                //console.log();
            }
                $('.tweet').slideDown('slow');
            //console.log(json);

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

