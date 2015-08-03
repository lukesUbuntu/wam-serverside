// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js

/**
 * Created by Maen Terawasi on 29/07/2015.
 */
(function(){
    console.log("running app.js")
    var app = angular.module('wamApp', [ ]);

    app.factory('testService', function($http) {
        var testService = function(){
            var promise = $http.get('https://api.github.com/users?since=135').then(function(response){
                //console.log(response.data);
                return response.data;
            })
            return promise;
        }
        return testService;
    })

    /*--- creating store controller ---*/
    app.controller('searchTaxi', function ($scope,testService) {
        /*--- set property of this controller to equals gem variable ---*/
        console.log("running")
        testService().then(function(response){
            console.log("returned data",response)
            $scope.products = response;
        })
    });



    /*--- gem variable ---*/
    /*var gems = [
     {
     name: "Dodecahedron",
     price: 2.95,
     description: "This is a cool gem!",
     canPurchase: true,
     soldOut: true,
     image: "img/3.jpg",
     descriptions: "This was made using diamonds.",
     specifications: "1 Diameter in length and 3 km in width.. thats all.",
     reviews: "..."
     },
     {
     name: "Pentagonal Gem",
     price: 5.95,
     description: "This is a cool gem!",
     canPurchase: true,
     soldOut: true,
     image: "img/2.jpg",
     descriptions: "This was made using diamonds.",
     specifications: "1 Diameter in length and 3 km in width.. thats all.",
     reviews: "..."
     }
     ];*/

    console.log("finisjed app.js")
})();
