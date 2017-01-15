'use strict';

var app = angular.module('MySite', ['ngRoute', 'angular-loading-bar', 'ngAnimate', 'infinite-scroll']);
app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider.when('/', {templateUrl: baseUrl + 'bundles/app/partials/index/index.html', controller: 'Index'});
        $routeProvider.when('/Portfolio', {templateUrl: baseUrl + 'bundles/app/partials/Portfolio/index.html', controller: 'Portfolio'});
        $routeProvider.when('/isi/:id/:title', {templateUrl: baseUrl + 'bundles/app/partials/Isi/index.html', controller: 'Isi'});
        $routeProvider.when('/showisi/:id', {templateUrl: baseUrl + 'bundles/app/partials/Isi/show.html', controller: 'ShowIsi'});
        $routeProvider.when('/services/:id', {templateUrl: baseUrl + 'bundles/app/partials/Services/index.html', controller: 'Services'});
        $routeProvider.when('/seo', {templateUrl: baseUrl + "bundles/app/partials/Seo/index.html", controller: 'Seo'});
        $routeProvider.when('/news', {templateUrl: baseUrl + "bundles/app/partials/News/index.html", controller: 'News'});
        $routeProvider.otherwise({redirectTo: '/'});
    }]);

app.controller('Index', function ($scope, $http, portfolioService) {
    $('html, body').stop().animate({
        scrollTop: $('body').offset().top - 90
    }, 0);
    $scope.news = {};

    $scope.data = portfolioService.getPortfolio(4);

    $http.get(baseUrl + "Default/news/-1/0/3/id/desc").success(function (response) {
        $scope.news = response.news;
    });

    $scope.ShowImg = function (id) {
        try {
            return portfolioService.ShowImg($scope.data.portfolioImg, id);
        } catch (e) {
        }
    }

    $scope.ShowPortfolio = function (portfolio) {
        $scope.PortfolioInfo = portfolio;
        $('.ShowPortfolio').modal('show');
    }

    $scope.ShowNews = function (item) {
        $scope.NewsInfo = item;
        $('.ShowNews').modal("show");
    };
});


app.controller('Isi', function ($scope, $http, $routeParams, portfolioService) {
    $('html, body').stop().animate({
        scrollTop: $('body').offset().top - 90
    }, 0);
    $scope.ISI = {};
    $scope.title = $routeParams.title;

    $scope.data = portfolioService.getPortfolio(-1);

    $scope.ShowImg = function (id) {
        try {
            return portfolioService.ShowImg($scope.data.portfolioImg, id);
        } catch (e) {
        }
    }
    
    $scope.ShowPortfolio = function (portfolio) {
        $scope.PortfolioInfo = portfolio;
        $('.ShowPortfolio').modal('show');
    }

    $scope.ShowIsiImg = function (img) {
        if (img != undefined)
            return img;
        return "/bundles/public/img/isi.jpg";
    }
    
    $scope.ShowHtmlContent = function(className,data){
     console.log("Class Name is : "+className+" data is : "+data);
    $('.'+className).html(data);    
    }
    
    $scope.ShowIsi = function (isi) {
        $scope.IsiInfo = isi;
        $('.ShowIsi').modal("show");
    }
    var after = 0;
    $scope.busyScroll = false;
    $scope.showMessage = "اطلاعاتی جهت نمایش موجود نمی باشد";
    $scope.entities = [];
    $scope.ISI = {};
    $scope.idImage = [];
    $scope.filter = $scope.inputsearch;
    $scope.loadMore = function () {
        if ($scope.busyScroll)
        {
            return false;
        }
        if ($scope.filter == undefined)
            $scope.filter = -1;
        //(baseUrl + "Default/isi/" + $routeParams.id
        $scope.busyScroll = true;
        var url = baseUrl + "Default/isi/" + $routeParams.id + "/" + $scope.filter + "/" + after + "/3/id/desc";
        $http.get(url, {cache: true}).success(function (data) {
            var items = 0;
            if (data.isi != undefined)
                items = data.isi.length;
            if (items > 0)
            {
                $('.msg').fadeOut();
                if ($scope.ISI.length == undefined) {
                    $scope.ISI = data.isi;
                    after=items;
                } else {
                    for (var i = 0; i < items; i++) {
                        $scope.ISI.push(data.isi[i]);
                        after++;
                    }
                }
                if (items === 3)
                    $scope.busyScroll = false;
                else
                    $('.msg').fadeIn();
            } else {
                $('.msg').fadeIn();
            }
        });
    };
    var filterTextTimeout;
    $scope.search = function () {
        $scope.filter = $scope.inputsearch;
        if ($scope.filter == '') {
            $scope.filter = -1;
        }
        var route = baseUrl + "Default/isi/" + $routeParams.id + "/" + $scope.filter + "/0/3/id/desc";
        if (filterTextTimeout) {
            clearTimeout(filterTextTimeout);
        }
        filterTextTimeout = setTimeout(function () {
            $http.get(route).success(function (response) {
                console.log(response);
                if (response.msg != undefined) {
                    $('.msg').fadeIn();
                } else {
                    $scope.ISI = response.isi;
                }
            }).error(function (r) {
                console.log('مشکل در برقراری ارتباط با سرور با پشتیبانی تماس بگیرید');
            });
        }, 2000);
    };
});

app.controller('ShowIsi',function ($scope,$http,$routeParams){
    var id = $routeParams.id;
    $http.get(baseUrl+"Default/ShowIsi/"+id).success(function(data){
        $scope.data = data.isi;
        $scope.allIsi = data.allIsi;
    }).error(function(){
        console.log("error");
    });
     $scope.ShowImg = function (img) {
        if (img != undefined)
            return img;
        return "/bundles/public/img/isi.jpg";
    }
    $scope.ShowContent = function (data){
        $('.showdata').html(data);
    }
});

app.controller("News", function ($scope, $http) {
    $('html, body').stop().animate({
        scrollTop: $('body').offset().top - 90
    }, 0);
    $scope.ShowNews = function (item) {
        $scope.NewsInfo = item;
        $('.ShowNews').modal("show");
    };

    var after = 0;
    $scope.busyScroll = false;
    $scope.showMessage = "اطلاعاتی جهت نمایش موجود نمی باشد";
    $scope.entities = [];
    $scope.news = {};
    $scope.idImage = [];
    $scope.filter = $scope.inputsearch;
    $scope.loadMore = function () {
        if ($scope.busyScroll)
        {
            return false;
        }
        if ($scope.filter == undefined)
            $scope.filter = -1;
        //(baseUrl + "Default/isi/" + $routeParams.id
        $scope.busyScroll = true;
        var url = baseUrl + "Default/news/" + $scope.filter + "/" + after + "/3/id/desc";
        $http.get(url, {cache: true}).success(function (data) {
            var items = 0;
            if (data.news != undefined)
                items = data.news.length;
            if (items > 0)
            {
                $('.msg').fadeOut();
                if ($scope.news.length == undefined) {
                    $scope.news = data.news;
                    after=items;
                } else {
                    for (var i = 0; i < items; i++) {
                        $scope.news.push(data.news[i]);
                        after++;
                    }
                }
                if (items === 3)
                    $scope.busyScroll = false;
                else
                    $('.msg').fadeIn();
            } else {
                $('.msg').fadeIn();
            }
        });
    };
    var filterTextTimeout;
    $scope.search = function () {
        $scope.filter = $scope.inputsearch;
        if ($scope.filter == '') {
            return false;
        }
        var route = baseUrl + "Default/news/" + $scope.filter + "/0/3/id/desc";
        if (filterTextTimeout) {
            clearTimeout(filterTextTimeout);
        }
        filterTextTimeout = setTimeout(function () {
            $http.get(route).success(function (response) {
                console.log(response);
                if (response.msg != undefined) {
                    $('.msg').fadeIn();
                } else {
                    $scope.news = response.news;
                }
            }).error(function (r) {
                console.log('مشکل در برقراری ارتباط با سرور با پشتیبانی تماس بگیرید');
            });
        }, 2000);
    };
});

app.controller("Footer", function ($scope, $http) {
    $scope.SendContact = function () {
        if ($scope.contact == undefined) {
            return false;
        }
        if ($scope.contact.name == undefined || $scope.contact.mobile == undefined || $scope.contact.email == undefined) {
            $scope.modal("فیلد های ارسال پیام نمی تواند خالی باشد");
        }
        $scope.contact.csrf = csrf;
        $http({
            "method": "post",
            "url": baseUrl + "Default/Contact",
            "data": $scope.contact
        }).success(function (response) {
            $scope.modal(response);
            $scope.SendsData = $scope.contact;
            $scope.DisableBtn = true;
        }).error(function (response) {
            $scope.modal("در حال حاضر سرور مشغول است زمانی دیگر امتحان کنید با شرکت تماس حاصل نمائید")
        })
    }
    $scope.modal = function (msg) {
        $scope.modalmsg = msg;
        $('.MessageModal').modal("show");
    }

    $http.get(baseUrl + "Default/Services").success(function (response) {
        $scope.Services = response;
    });
});

//$offset, $limit, $attr, $asc
app.factory("portfolioService", function ($http) {
    var data = {};
    return {
        getPortfolio: function (count) {
            var url = "Default/portfolio/0/4/id/desc";
            $http.get(baseUrl + url).success(function (response) {
                data.portfolio = response.portfolio;
                data.portfolioImg = response.portfolioImg;
            });
            return data;
        },
        ShowImg: function (d, id) {
            var img = '';
            for (var i = 0; i < d.length; i++) {
                if (d[i].portfolio_id == id) {
                    img = d[i].file;
                    break;
                }
            }
            if (img != '')
                return img;
            return "/bundles/public/img/4.jpg";
        }
    };
});



app.filter('nl2br', function () {
    return function (text) {
        return text ? text.replace(/\n/g, '<br/>') : '';
    };
})
        ;
app.filter('cut', function () {
    return function (value, wordwise, max, tail) {
        if (!value)
            return '';

        max = parseInt(max, 10);
        if (!max)
            return value;
        if (value.length <= max)
            return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
                value = value.substr(0, lastspace);
            }
        }
        return value + (tail || ' …');
    };
});

//darash Comment
//This For set text checkbox
app.filter('boolean', function () {
    return function (value) {
        if (value) {
            return 'فعال';
        } else {
            return 'غیر فعال';
        }
    };
});

//darash Comment  
// This Filter For Remove Tag HTML  
app.filter('htmlToPlaintext', function () {
    return function (text) {
        return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
}).filter('Rial', function () {
    return function (dateString) {
        return dateString + 'ریال';
    };
}).filter('ConvertedToDateShamsi', function () {
    return function (dateString) {
        if (dateString != null)
        {
            return moment(dateString, 'YYYY-M-D HH:mm:ss').format('jYYYY/jM/jD');
        } else {
            return "تاریخ ندارد";
        }
    };
});
