<!DOCTYPE html>
<html lang="en" ng-ap="wamApp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>What's Around Me</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!--- google font --->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,300,200&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>
<body>
<span ng-controller="searchTaxi"></span>
<!--- navbar --->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active homeLink"><a class="homeScrollLink"><i class="fa fa-home homeIcon"></i>&nbsp;Home<span class="sr-only">(current)</span></a></li>
                <li class="newsLink"><a class="newsScrollLink"><i class="fa fa-newspaper-o newsIcon"></i>&nbsp;News</a></li>
                <li class="eventsLink"><a class="eventsScrollLink"><i class="fa fa-info-circle eventsIcon"></i>&nbsp;Events</a></li>
                <li class="raodWorksLink"><a class="roadWorksScrollLink"><i class="fa fa-car roadWorksIcon"></i>&nbsp;Roadworks</a></li>
                <li class="weatherLink"><a class="weatherScrollLink"><i class="fa fa-cloud weatherIcon"></i>&nbsp;Weather</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!--- main banner --->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainBanner">
    <h1>W<span>hat's</span>&nbsp;A<span>round</span><br/>M<span>e</span></h1>
    <h2>Stay up to date with the latest happenings around you.</h2>
</div>

<!--- first section --->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 firstSection" >
    <div class="container">
        <h1 style="color: lightgray;">News within your location</h1>
    </div>

    <div id="NewsController" class="container">


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 newsSummaryHolder" id="articles" style="display:none">
            <div class="col-lg-8">
                <img class="news_image" src="images/newsTestImgs/1.jpg">
            </div>
            <div class="col-lg-4">
                <h3  class="news_title"></h3>
                <span><i class="fa fa-calendar"></i>&nbsp;<span class="news_author"></span></span>
            </div>
        </div>
        <!--
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 newsSummaryHolder">
                    <div class="col-lg-8">
                        <img src="images/newsTestImgs/3.jpg">
                    </div>
                    <div class="col-lg-4">
                        <h3 class="">Basin Reserve flyover appeal finishes</h3>
                        <span><i class="fa fa-calendar"></i>&nbsp;27th June 2015</span>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 newsSummaryHolder">
                    <div class="col-lg-8">
                        <img src="images/newsTestImgs/5.jpg">
                    </div>
                    <div class="col-lg-4">
                        <h3 class="">Yacht hits trouble in high seas</h3>
                        <span><i class="fa fa-calendar"></i>&nbsp;27th June 2015</span>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 newsSummaryHolder">
                    <div class="col-lg-8">
                        <img src="images/newsTestImgs/4.jpg">
                    </div>
                    <div class="col-lg-4">
                        <h3 class="">Joseph Parker stuns Bowie Tupou</h3>
                        <span><i class="fa fa-calendar"></i>&nbsp;27th June 2015</span>
                    </div>
                </div>
                !-->
    </div>
</div>



<!--- third section --->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 thirdSection" id="roadWorksHolder">
    <div class="container">
        <h1 style="color: white;">Roadworks Info</h1>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roadInfoHolder" id="roadWorksTemplate" style="display:none">
            <div class="container">
                <h2 style="color: darkgray;">Distance from where you are: <span class="distance" style="color: lightgray;">4kms</span></h2>
                <h2 style="color: darkgray;">Location: <span class="road_name" style="color: lightgray;">34 Somewhere Rd, Wellington</span></h2>
                <h3 style="color: darkgray;">Comments:</h3>
                <p style="color: lightgray;" class="road_comments">There is some roadworks maintenance on this road so just don't go there ok.</p>
            </div>

        </div>

        <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roadInfoHolder">
            <h2 style="color: darkgray;">Distance from where you are: <span style="color: lightgray;">4kms</span></h2>
            <h2 style="color: darkgray;">Location: <span style="color: lightgray;">34 Somewhere Rd, Wellington</span></h2>
            <h3 style="color: darkgray;">Comments:</h3>
            <p style="color: lightgray;">There is some roadworks maintenance on this road so just don't go there ok.</p>
        </div>-->
    </div>
    <!--<div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 style="color: lightgray;">Roadworks Info</h1>
            <h2>Select your region of preference</h2>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 roadWorksHolderControls">
                <h3 class="filter active" data-filter="all">All Cities</h3>
                <h3 class="filter" data-filter=".Northland">North Island</h3>
                <h3 class="filter" data-filter=".Southland">South Island</h3>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 roadWorksContainer">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mix Northland">
                    <div class="col-lg-12">
                        city 1
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mix Southland">
                    <div class="col-lg-12">
                        city 2
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 Northland">
                    <div class="col-lg-12">
                        city 3
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>

<!--- second section --->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 secondSection">
    <div class="container">
        <h1 style="color: white;">Local events around your area</h1>
        <div id="event_placement" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 eventsContainer">

            <div id="loopEventsContainer" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 loopEventsContainer" style="display:none">

                <div class="col-lg-12">
                    <img class="event_image" src="images/eventsTestImgs/1.jpg" width="100%">
                    <h2 class="event_name">Cats The Musical</h2>
                    <span class="event_venue">The Civic, Wellington</span>
                    <br/>
                    <span class="event_date"> Fri 11 Sep 7:30pm</span>
                    <span class="event_start"> Fri 11 Sep 7:30pm</span>
                    <span class="event_end"> Fri 11 Sep 7:30pm</span>
                </div>

            </div>

            <!--
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="col-lg-12">
                    <img src="images/eventsTestImgs/2.jpg" width="100%">
                    <h2>Lord of the Dance: Dangerous Games</h2>
                    <span>The Civic, Wellington</span>
                    <br/>
                    <span>Fri 11 Sep 7:30pm</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="col-lg-12">
                    <img src="images/eventsTestImgs/3.jpg" width="100%">
                    <h2>Lysistrata</h2>
                    <span>The Civic, Wellington</span>
                    <br/>
                    <span>Fri 11 Sep 7:30pm</span>
                </div>
            </div>
            !-->
        </div>
    </div>
</div>

<!--- fourth section --->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fourthSection">
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 weatherContainer">
            <div class="col-lg-3">
                <h1>Wellington</h1>
                <h2 style="color: lightgray;">06:20pm</h2>
                <h1><i class="fa fa-sun-o"></i>19&deg;C</h1>
            </div>
            <div class="col-lg-3" style="margin-top: 6%;">
                <h2 style="color: lightgray;">Rain</h2>
                <h2><i class="fa fa-umbrella"></i>&nbsp;85%</h2>
            </div>
            <div class="col-lg-6">
                <div class="col-lg-4">
                    <h3>Wed</h3>
                    <h4><i class="fa fa-cloud"></i></h4>
                    <h4>14&deg;C</h4>
                </div>
                <div class="col-lg-4">
                    <h3>Thurs</h3>
                    <h4><i class="fa fa-sun-o"></i></h4>
                    <h4>21&deg;C</h4>
                </div>
                <div class="col-lg-4">
                    <h3>Fri</h3>
                    <h4><i class="fa fa-sun-o"></i></h4>
                    <h4>29&deg;C</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!--- footer --->
<footer>
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footerContainer">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h3>WAM Copyright &copy; 2015</h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <i class="fa fa-facebook"></i>
                &nbsp;
                <i class="fa fa-twitter"></i>
                &nbsp;
                <i class="fa fa-youtube"></i>
            </div>
        </div>
    </div>
</footer>

<!--- scripts --->

<script src="js/jquery-1.9.1.min.js"></script>
<script src="app.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/mixItUp.js"></script>
<script src="js/custom.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        // Start mixitup
        $('#roadWorksHolder').mixItUp();
    });
</script>

</body>
</html>