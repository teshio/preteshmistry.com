<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pretesh Mistry - Home</title>
        <link rel="icon" type="image/png" href="/images/favicon.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.min.css">       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.3.0/animate.min.css">
        <style>
            
            .tweets{
                padding: 10px;
            }

            .tweet-sizer{
                width: 30%;
            }
            .tweet{
                width: 95%;
                padding:10px;
                background-color:#444;
                border-radius: 3px;
                margin: 5px;
            }
            
            .tweet.ng-leave{
                animation: fadeOut 2s;
            }
            @media screen and (min-width: 768px  ) {
                .tweet { width: 30%; }
            }
            @media screen and (min-width: 992px ) {
                .tweet { width: 30%; }
            }
            
            @media screen and (min-width: 1200px) {
                .tweet { width: 18%; }
            }


        </style>


        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body ng-app="mainApp" ng-controller="mainCtrl">

        <nav class="navbar navbar-default navbar-static-top">
            <div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="" ng-click="loadTweets()">What's happening right now!</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                </div><!--/.navbar-collapse -->
            </div>
        </nav>

        <div class="container-fluid">
            <button class="btn btn-primary" ng-click="loadTweets()">Refresh</button>
        </div>

        <div class="tweets">
            <div class="tweet-sizer"></div>
            <div class="tweet" ng-repeat="t in tweets.statuses">

                <div class="container-fluid">

                    <div class="row-fluid">
                        
                        <div class="media">
                            
                            <div class="media-left">
                                <p>
                                <img class="media-object" ng-src="{{t.user.profile_image_url}}" />                                                                
                                    
                                </p>
                            </div>
                                                        <div class="media-body">
                            <p class="" ng-bind-html="twitterLinks(t.text)"></p>
                            </div>

                        </div>
                        
                        
                        <div class="col-xs-2">
                        </div>
                        <div class="col-xs-10">
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="col-xs-12 text-right">
                            <p class="small">
                                <span class="text-info">{{t.user.screen_name}}</span>
                                &nbsp;|&nbsp;
                                <span class="text-success">{{ tweetDate(t) }}</span>

                            </p>    
                        </div>
                    </div>

                    <div class="row-fluid">

                        <img ng-repeat="mediaImage in t.entities.media" class="img-responsive" ng-src="{{mediaImage.media_url}}" />
                    </div>
                </div>
            </div>                

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.1/angular-animate.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.min.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.3.1/masonry.pkgd.min.js"></script>        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.1/angular-sanitize.min.js"></script>
        <script type="text/javascript">
                                    var app = angular.module('mainApp', ['ngAnimate', 'ngSanitize']);
                                    app.controller('mainCtrl', function ($scope, $http, $timeout) {
                                        $scope.test = 'sdf';
                                        $scope.tweets = [];

                                        $scope.tweetsMason = {};
                                        
                                        $scope.tweetDate = function(t)
                                        {
                                            var dt = new Date(t.created_at);
                                            return dt.toDateString();
                                        };



                                        $scope.loadTweets = function (repack) {
                                            $scope.tweets = [];

                                            $http.get('/twitter.php?q=worldnews').success(function (data) {
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


                                                }, 0);

                                            });
                                        };
                                        $scope.loadTweets(true);

                                        $scope.twitterLinks = function (text)
                                        {
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
                                        }
                                    });
        </script>
    </body>
</html>