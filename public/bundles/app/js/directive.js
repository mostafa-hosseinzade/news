
app.directive('mostvisit', function ($http) {
    return {
        restrict: 'E',
        scope: false,
        templateUrl: baseUrl + 'bundles/app/partials/index/mostVisit.html',
        controller : function($scope){
            $http.get(base_url+"Default/data/mostvisit").success(function(response){
                $scope.mostvisit = response;
            })
        }
    }
});

app.directive('mostlike', function ($http) {
    return {
        restrict: 'E',
        scope: false,
        templateUrl: baseUrl + 'bundles/app/partials/index/mostLike.html',
        controller: function ($scope) {
            $http.get(base_url + "Default/data/mostlike").success(function (response) {
                $scope.mostlike = response;
            });
        }
    }
});

app.directive('slider', function ($http) {
    return {
        restrict: 'E',
        scope: false,
        templateUrl: baseUrl + 'bundles/app/partials/index/slider.html',
        controller:function($scope){
            $http.get(base_url+"Default/data/slider").success(function(response){
                $scope.slider = response;
            })
        }
    }
});

app.directive('about', function () {
    return {
        restrict: 'E',
        scope: false,
        templateUrl: baseUrl + 'bundles/app/partials/index/about.html'
    }
});
app.directive('footer', function () {
    return {
        restrict: 'E',
        scope: false,
        templateUrl: baseUrl + 'bundles/app/partials/index/footer.html'
    }
});



app.factory('paginationCreateArray', function () {
    return {
        array: function (arr, CountItems, constPageItems, current) {
            arr = new Array();

            var CountPaginate = Math.floor(CountItems / constPageItems);
            var CountPaginateRemane = CountItems % constPageItems;

            if (CountPaginateRemane === 0)
            {
                CountPaginate--;
            }

            var difference = CountPaginate - current;
            var low_range = current - 1;
            var high_range = current + 3;

            if (CountPaginate < 10)
            {  // kamtar az 10
                for (var i = 0; i < CountPaginate; i++) {
                    arr[i] = i + 1;
                }
            } else {
                if (current > 8 && current <= CountPaginate - 8)
                {
                    // vasat
                    arr[0] = 1;
                    arr[1] = 0;
                    var j = 2;
                    for (var i = current - 2; i < current + 4; i++) {
                        arr[j] = i;
                        j++;
                    }
                    arr[8] = 0;
                    arr[9] = CountPaginate;
                } else if (current > CountPaginate - 8)
                {
                    //last
                    arr[0] = 1;
                    arr[1] = 0;
                    var j = 2;
                    for (var i = CountPaginate - 7; i <= CountPaginate; i++) {
                        arr[j] = i;
                        j++;
                    }
                } else {
                    //first
                    for (var i = 0; i <= 7; i++) {
                        arr[i] = i + 1;
                    }
                    arr[8] = 0;
                    arr[9] = CountPaginate;
                }
            }
            return arr;
        }
    };
})