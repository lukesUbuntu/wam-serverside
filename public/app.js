$(document).ready(function(){



    function runApplication() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        //map.setCenter(new google.maps.LatLng(lat, lng));

        var current_location = {
            longitude : position.coords.longitude,
            latitude : position.coords.latitude
        }
        console.log("current_location",current_location);
        var $news_template = $("#articles");
        var $news_placement = $("#NewsController");
        var $events_placement = $("#event_placement");
        var $events_template = $("#loopEventsContainer");

        var $road_placement = $("#roadWorksHolder");
        var $road_template = $("#roadWorksTemplate");

        function getRoadWorks(){
            $.ajax({
                dataType: "jsonp",
                url : 'http://wam.nzhost.me/api/getRoadWorks',
                data: current_location,
                cache : true,
                success: function(response){

                    $.each(response.data,function(index,element){
                        console.log("element",element)

                        var $event = $road_template.clone();

                        $(".road_name",$event).text(element.properties.locationArea);

                        $(".distance",$event).text(element.distance);

                        $(".road_comments",$event).text(element.properties.eventComments);


                        $event.show();

                        $road_placement.append($event)
                        if (index > 4) return false;

                    })

                }
            });
        }


        function getEvents(){
            $.ajax({
                dataType: "jsonp",
                url : 'http://wam.nzhost.me/api/getEvents',
                data: current_location,
                cache : true,
                success: function(response){

                    $.each(response.data,function(index,element){
                        console.log("element",element)

                        var $event = $events_template.clone();
                        console.log("$events_template");

                        console.log("s",$events_template.html())



                        $(".event_image",$event).attr('src',element.thumbnail);
                        $(".event_name",$event).text(element.name);
                        $(".event_venue",$event).text(element.address);
                        $(".event_date",$event).text(element.datetime_summary);
                        $(".event_start",$event).text(element.event_start);
                        $(".event_end",$event).text(element.datetime_end);


                        $event.show();

                        $events_placement.append($event)
                        if (index > 4) return false;

                    })

                }
            });
        }

        function getNewsArticles(){
            $.ajax({
                dataType: "jsonp",
                url : 'http://wam.nzhost.me/api/getNews',
                data: current_location,
                cache : true,
                success: function(response){

                    $.each(response.data,function(index,element){
                        var $article = $news_template.clone();
                        $(".news_image",$article).attr('src',element.imageUrl);
                        $(".news_title",$article).text(element.name);
                        $(".news_author",$article).text(element.author);
                        $article.show();

                        $news_placement.append($article)
                        if (index > 6) return false;
                    })
                    console.log("response",response)
                }
            });
        }



        getNewsArticles();
        getRoadWorks();
        //grab details
        getEvents();



    }

    runApplication();
})