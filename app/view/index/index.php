<html ng-app="MySite">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="/bundles/app/css/bootstrap.css">
        <link rel="stylesheet" href="/bundles/public/css/custom.css">
        <!--<link href="/bundles/public/fonts/css/font-awesome.min.css" rel="stylesheet">-->
        <link rel="stylesheet" href="/bundles/public/css/loading-bar.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;subset=latin">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
        <link rel="stylesheet" href="/assets/bootstrap-material-design-font/css/material.css">
        <link rel="stylesheet" href="/assets/et-line-font-plugin/style.css">
        <link rel="stylesheet" href="/assets/tether/tether.min.css">
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/dropdown/css/style.css">
        <link rel="stylesheet" href="/assets/socicon/css/styles.css">
        <link rel="stylesheet" href="/assets/bootstrap/css/animate.css">
        <link rel="stylesheet" href="/assets/theme/css/style.css">
        <link rel="stylesheet" href="/assets/mobirise-gallery/style.css">
        <link rel="stylesheet" href="/assets/mobirise/css/mbr-additional.css" type="text/css">
        <link rel="stylesheet" href="/bundles/public/css/font-awesome.min.css">
    </head>
    <body>
        <!-- header menu -->
        <!--        <nav class="navbar navbar-inverse navbar-fixed-top">
                    <button type="button" class="navbar-toggle collapsed btn btn-primary" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <center>
                            <ul class="nav navbar-nav">
                                <li>
                                    <a class="menuitem active-menu" style="cursor: pointer" href="#/"><b>صفحه اصلی</b></a>
                                </li>
        
                                <li>
                                    <a class="menuitem" href="#/seo"><b>سئو</b></span></a>
                                </li>
                                <li >
                                    <a class="menuitem" href="#/Portfolio"><b>نمونه کارها</b></span></a>
                                </li>
                                <li>
                                    <a class="menuitem" href="#/news"><b>اخبار سایت</b></span></a>
                                </li>
                                <li class="dropdown">
                                    <a style="cursor: pointer" class="dropdown-toggle menuitem" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><b>مقاله ها </b> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav pull-left">
                                <li><a href="#/">Site Ofogh</a></li>
                            </ul>
                        </center>
                    </div>
                    <img src="/bundles/public/img/shadow.png" width="100%">
                </nav>-->

        <section id="menu-0">

            <nav style="background-color: rgba(0,0,0,0.6) !important" class="navbar navbar-dropdown bg-color transparent navbar-fixed-top">
                <div class="container">

                    <div class="mbr-table">
                        <div class="mbr-table-cell">

                            <div class="navbar-brand">
                                <a href="https://mobirise.com" class="navbar-logo"><img src="assets/images/logo.png" alt="Mobirise"></a>
                                <a class="navbar-caption" href="https://mobirise.com">MOBIRISE</a>
                            </div>

                        </div>
                        <div class="mbr-table-cell">

                            <button class="navbar-toggler pull-xs-right hidden-md-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                                <div class="hamburger-icon"></div>
                            </button>

                            <ul class="nav-dropdown collapse pull-xs-right nav navbar-nav navbar-toggleable-sm" id="exCollapsingNavbar">
                                <?php foreach ($data['parents'] as $key => $value): ?>                       
                                    <li class="nav-item dropdown">
                                        <a class="nav-link link dropdown-toggle"
                                           data-toggle="dropdown-submenu" 
                                           href="#/"><?= $value['title'] ?></a>
                                        <div class="dropdown-menu">
                                            <?php foreach ($value['child'] as $child): ?>
                                            <a class="dropdown-item" href="#/isi/<?= $child['id'] ?>/<?= $child['title'] ?>"><?= $child['title'] ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                              <li class="nav-item"><a class="nav-link link" href="#/">صفحه اصلی</a></li>
                            </ul>
                            <button hidden="" class="navbar-toggler navbar-close" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                                <div class="close-icon"></div>
                            </button>

                        </div>
                    </div>

                </div>
            </nav>

        </section>

        <div class="main" id="test2">
            <div ng-view></div>
            <div class="clearfix"></div>
        </div>
         <footer ng-controller="Footer"></footer>
        <script>
            var base_url = '<?php echo base_url ?>';
        </script>
        <script src="/bundles/public/angular/jquery.js"></script>
        <script src="/bundles/admin/js/angular.min.js"></script>
        <script src="/bundles/public/js/angular-route.min.js"></script>
        <script src="/bundles/public/angular/angular-animate-1.6.min.js"></script>
        <script src="/bundles/public/js/angular/angular-resource.min.js"></script>
        <script src="/bundles/public/angular/ui-bootstrap-tpls-2.5.0.min.js"></script>
        <script src="/bundles/public/js/loading-bar.js"></script> 
        <script src="/bundles/public/js/bootstrap.min.js"></script>
        <script src="/bundles/public/js/angular/ng-infinite-scroll.min.js"></script>
        <script src="/bundles/app/js/controller.js"></script>
        <script src="/bundles/app/js/directive.js"></script>


        <script src="/assets/tether/tether.min.js"></script>
        <script src="/assets/smooth-scroll/SmoothScroll.js"></script>
        <script src="/assets/dropdown/js/script.min.js"></script>
        <script src="/assets/touchSwipe/jquery.touchSwipe.min.js"></script>
        <script src="/assets/bootstrap-carousel-swipe/bootstrap-carousel-swipe.js"></script>
        <script src="/assets/masonry/masonry.pkgd.min.js"></script>
        <script src="/assets/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script src="/assets/viewport/jquery.viewportchecker.js"></script>
        
        <script src="assets/mobirise-gallery/player.min.js"></script>
  <script src="assets/mobirise-gallery/script.js"></script>
  
        <script src="/assets/theme/js/script.js"></script>
        <script src="/assets/mobirise-gallery/script.js"></script>
        
        

        <script>
            var baseUrl = "http://localhost:8000/";
            var csrf = "<?php echo csrf; ?>";
            $('.menuitem').on("click", function () {
                $('.menuitem').removeClass("active-menu");
                $(this).addClass("active-menu");
            })

        </script>
    </body>
</html>
