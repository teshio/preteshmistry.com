var app = angular.module('mainApp', ['ngAnimate', 'ngSanitize']);


app.filter('tweetText', function () {
    return function (text) {
        var base_url = 'http://twitter.com/';	// identica: 'http://identi.ca/'
        var hashtag_part = 'search?q=#';		// identica: 'tag/'
        // convert URLs into links
        text = text.replace(
                /(>|<a[^<>]+href=['"])?(https?:\/\/([-a-z0-9]+\.)+[a-z]{2,5}(\/[-a-z0-9!#()\/?&.,]*[^ !#?().,])?)/gi,
                function ($0, $1, $2) {
                    return ($1 ? $0 : '<a href="' + $2 + '" target="_blank">' + $2 + '</a>');
                });
        // convert protocol-less URLs into links		
        text = text.replace(
                /(:\/\/|>)?\b(([-a-z0-9]+\.)+[a-z]{2,5}(\/[-a-z0-9!#()\/?&.]*[^ !#?().,])?)/gi,
                function ($0, $1, $2) {
                    return ($1 ? $0 : '<a href="http://' + $2 + '">' + $2 + '</a>');
                });
        // convert @mentions into follow links
        text = text.replace(
                /(:\/\/|>)?(@([_a-z0-9\-]+))/gi,
                function ($0, $1, $2, $3) {
                    return ($1 ? $0 : '<a href="' + base_url + $3
                            + '" title="Follow ' + $3 + '" target="_blank">@' + $3
                            + '</a>');
                });
        // convert #hashtags into tag search links
        text = text.replace(
                /(:\/\/[^ <]*|>)?(\#([_a-z0-9\-]+))/gi,
                function ($0, $1, $2, $3) {
                    return ($1 ? $0 : '<a href="' + base_url + hashtag_part + $3
                            + '" title="Search tag: ' + $3 + '" target="_blank">#' + $3
                            + '</a>');
                });
        return text;
    };
});

app.directive('tooltip', function () {
    return {
        restrict: 'A',
        replace: 'true',
        link: function (scope, elem, attr) {
            var url = scope.t.user.url;
            var title = attr.title;
            if (url !== null) {
                title = attr.title + ' <a target="_blank" href="' + url + '">' + scope.t.user.screen_name + '</a>';
            }
            //console.log(scope.t);
            elem.attr('title', title);
            elem.tooltip({
                html: true
            });
        }
    };
});


app.controller('mainCtrl', function ($scope, $http, $timeout) {

    $scope.tweets = [];
    $scope.loading = false;
    $scope.searchQuery = 'world news';
    $scope.tweetsMason = {};
    $scope.tweetDate = function (t)
    {
        var dt = new Date(t.created_at);
        return dt.toDateString();
    };

    $scope.loadTweets = function (repack) {
        $scope.tweets = [];
        $scope.loading = true;

        $http.get('/twitter.php', {params: {q: $scope.searchQuery}}).success(function (data) {
            $scope.tweets = data;
            $timeout(function () {

                if (!repack) {
                    $scope.tweetsMason.masonry('destroy');
                }
                var grid = $('.tweets').masonry({
                    itemSelector: '.tweet',
                    percentPosition: true,
                });


                grid.imagesLoaded().progress(function () {
                    grid.masonry('layout');
                });
                $scope.tweetsMason = grid;

                $scope.loading = false;


            }, 0);

        });
    };
    $scope.loadTweets(true);
});