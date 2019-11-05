<?php

$cookie_name = "ticket";
// On génère quelque chose d'aléatoire
$ticket = session_id().microtime().rand(0,9999999999);
// on hash pour avoir quelque chose de propre qui aura toujours la même forme
$ticket = hash('sha512', $ticket);

// On enregistre des deux cotés
setcookie($cookie_name, $ticket, time() + (60 * 20)); // Expire au bout de 20 min
$_SESSION['ticket'] = $ticket;

?>

<!DOCTYPE html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?= $title ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Theme CSS -->
        <link href="public/css/freelancer.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    </head>

    <body id="page-top" class="index">

        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        Menu 
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="#page-top">Steve Essama</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <?php if (array_key_exists('success_connect', $_SESSION)): ?>
                    <div class="hidden-xs hidden-md hidden-lg" style="color:white; position:absolute; right: 14px; top: 5px;">
                        <?= $_SESSION['success_connect']; ?></div>
                    <form class="hidden-xs hidden-md hidden-lg" action="index.php?action=disconnected" method="post" style="position:fixed; right:15px;                             top:40px;">
                        <button style="color:red; margin-top:-8px" type="submit" class="btn btn-success btn-default" name="disconnect">Déconnexion</button>
                    </form>
                    <?php endif; ?>

                    <?php if (!array_key_exists('success_connect', $_SESSION)): ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden"><a href="#page-top"></a></li>
                        <li><a href="index.php">Accueil</a></li>
                        <li class="page-scroll"><a href="index.php?action=listposts"> Nos articles </a></li>
                        <li class="page_scroll"><a href="index.php?action=connection"> Espace membres </a></li>
                        <li class="page_scroll"><a href="index.php?action=connect_admin"> Espace administrateur </a></li>
                    </ul>
                    <?php endif; ?>

                    <?php if (array_key_exists('success_connect', $_SESSION)): ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden"><a href="#page-top"></a></li>
                        <li><a href="index.php">Accueil</a></li>
                        <li class="page-scroll"><a href="index.php?action=listposts"> Nos articles </a></li>
                        <li class="page_scroll"><a href="index.php"> Espace membres </a></li>
                        <li class="page_scroll"><a href="index.php?action=admin_space"> Espace administrateur </a></li>
                    </ul>
                    <?php endif; ?>
                </div>
                <!-- /.navbar-collapse -->

            </div>
            <!-- /.container-fluid -->
        </nav>
        
        <?= $content ?>

        <!-- Footer -->
        <footer class="text-center">
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-4">
                            <h3>Adresse</h3>
                            <p>
                                27 rue Arago, <br>
                                Villeurbanne, 69100
                            </p>
                        </div>
                        <div class="footer-col col-md-4">
                            <h3>Réseaux sociaux</h3>
                            <ul class="list-inline">
                                <li>
                                    <a href="https://openclassrooms.facebook.com/profile.php?id=100030215146732" class="btn-social btn-outline">
                                        <i class="fa fa-fw fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/in/essama-mgba-franck-steve-7a6227175/" class="btn-social btn-outline">
                                        <i class="fa fa-fw fa-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-col col-md-4">
                            <h3>Administration du site</h3>
                            <p>
                                <a href="index.php?action=connect_admin"> Accédez à l'espace administrateur </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-below">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            Copyright &copy; Blog Steve Essama 2019
                        </div>
                    </div>
                </div>
            </div>
        </footer>



        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
        <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
            <a class="btn btn-primary" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>


        <!-- jQuery -->
        <script src="public/vendor/jquery/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="public/js/jqBootstrapValidation.js"></script>
        <script src="public/js/contact_me.js"></script>

        <!-- Theme JavaScript -->
        <script src="public/js/freelancer.min.js"></script>

    </body>

</html>              

























































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































































