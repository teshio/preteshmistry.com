/*global angular, console*/
/*jslint regexp:true */

(function () {
    'use strict';

    var app = angular.module('mainApp', ['ngAnimate', 'ngSanitize', 'masonry']);

    app.filter('tweetText', function () {
        return function (text) {
            var base_url = 'http://twitter.com/', // identica: 'http://identi.ca/'
                hashtag_part = 'search?q=#'; // identica: 'tag/'
            // convert URLs into links
            text = text.replace(
                /(>|<a[^<>]+href=['"])?(https?:\/\/([\-a-z0-9]+\.)+[a-z]{2,5}(\/[\-a-z0-9!#()\/?&.,]*[^ !#?().,])?)/gi,
                function ($0, $1, $2) {
                    return ($1 ? $0 : '<a href="' + $2 + '" target="_blank">' + $2 + '</a>');
                }
            );
            // convert protocol-less URLs into links
            text = text.replace(
                /(:\/\/|>)?\b(([\-a-z0-9]+\.)+[a-z]{2,5}(\/[\-a-z0-9!#()\/?&.]*[^ !#?().,])?)/gi,
                function ($0, $1, $2) {
                    return ($1 ? $0 : '<a href="http://' + $2 + '">' + $2 + '</a>');
                }
            );
            // convert @mentions into follow links
            text = text.replace(
                /(:\/\/|>)?(@([_a-z0-9\-]+))/gi,
                function ($0, $1, $2, $3) {
                    return ($1 ? $0 : '<a href="' + base_url + $3 +
                            '" title="Follow ' + $3 + '" target="_blank">@' + $3 + '</a>');
                }
            );
            // convert #hashtags into tag search links
            text = text.replace(
                /(:\/\/[^ <]*|>)?(\#([_a-z0-9\-]+))/gi,
                function ($0, $1, $2, $3) {
                    return ($1 ? $0 : '<a href="' + base_url + hashtag_part + $3 +
                        '" title="Search tag: ' + $3 + '" target="_blank">#' +
                        $3 + '</a>');
                }
            );
            return text;
        };
    });

    app.directive('tooltip', function () {
        return {
            restrict: 'A',
            replace: 'true',
            link: function (scope, elem, attr) {
                var url = scope.t.user.url,
                    title = attr.title;
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
        $scope.tweetCount = 10;
        $scope.moreTweets = false;

        $scope.tweetDate = function (t) {
            return new Date(t.created_at);
        };

        $scope.getFullImage = function(img){
          return img.replace('_normal', '');
        };

        $scope.loadTweets = function () {
            $scope.tweets = [];
            $scope.loading = true;

            $http.get('/twitter.php', {
                params: {
                    q: $scope.searchQuery,
                    c: $scope.tweetCount
                }
            }).success(function (data) {
                $scope.tweets = data;
                //console.log(data);
                $scope.loading = false;
                $scope.moreTweets = data.statuses.length === $scope.tweetCount;
            });
        };

        $scope.deleteTweet = function (t) {
            var i = $scope.tweets.statuses.indexOf(t);
            $scope.tweets.statuses.splice(i, 1);
        };

        $scope.loadMore = function () {
            $scope.loading = true;
            $http.get('/twitter.php', {
                params: {
                    q: $scope.searchQuery,
                    c: $scope.tweetCount,
                    maxId: $scope.tweets.statuses[$scope.tweets.statuses.length - 1].id
                }
            }).success(function (data) {
                var i,
                    src = data.statuses,
                    dest = $scope.tweets.statuses;

                for (i = 0; i < src.length; i = i + 1) {
                    dest.push(src[i]);
                }

                $scope.moreTweets = data.statuses.length === $scope.tweetCount;
                $scope.loading = false;
            });
        };

        $scope.loadTweets();
    });

}());
