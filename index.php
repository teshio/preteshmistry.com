<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Pretesh Mistry - Home</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' type='text/css'>
        <script src="components/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/parallax.js" type="text/javascript"></script>
        <script src="scripts/main.js" type="text/javascript"></script>
        <style type="text/css">
            .tweet{
                background-color: #555;
                font-family: 'Shadows Into Light', sans-serif;
                padding: 4px;
                color:white;
                margin:20px;
                border-radius:3px;
                border: 1px solid #888;
            }
            .profile-img{
                float:left;
            }
            .user{
                text-align: right;              
                font-size:10px;
            }
            
            .tweet:hover{
                background-color:#777;
            }
            
            body{
                background-color: black;
            }
            
            h1{
                color:white;
                font-family: 'Merienda One', sans-serif;
            }
        </style>
    </head>
    <body>
        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <h1>What's happening right now...</h1>
        
        <div id="tweets">            
        </div>
        
        

        
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-11994419-1', 'auto');
            ga('send', 'pageview');

        </script>
    </body>
</html>