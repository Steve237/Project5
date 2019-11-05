<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

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
            <form class="hidden-xs hidden-md hidden-lg" action="index.php?action=disconnected" method="post" style="position:fixed; right:15px; top:40px;">
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



<?php if (array_key_exists('success_connect', $_SESSION)): ?>

<section class="section_connection">
    <div class="connect-sign hidden-sm" style="color:red;"><?= $_SESSION['success_connect']; ?></div>
    <form action="index.php?action=disconnected" method="post">
        <button style="color:white;height:35px" type="submit" class="btn btn-success btn-default button-disconnect hidden-sm"                                           name="disconnect">Déconnexion</button>
    </form>
</section>    
<?php endif; ?>



<section id="portfolio" class="list_post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_portfolio">Nos icônes</h2>
                <hr class="star-primary">
            </div>
        </div>


        <div class="row">
            <?php
            foreach($newsList->getListPosts() as $news)
            {
            ?>
            <div class="col-sm-6 col-md-4 col-lg-4 portfolio-item">
                <a href="index.php?action=post&amp;id=<?= $news->getIdPost()?>&amp;titre=<?= $news->getTitreArticle()?>" class="portfolio-link">
                    <div class="caption">
                        <div class="caption-content">
                            <h6 class="hidden-sm hidden-md hidden-lg">
                                <?= htmlspecialchars($news->getTitreArticle())?>
                            </h6>

                            <h3 class="hidden-xs hidden-md hidden-lg">
                                <?= htmlspecialchars($news->getTitreArticle())?>
                            </h3>

                            <h4 class="hidden-xs hidden-sm">
                                <?= htmlspecialchars($news->getTitreArticle())?>
                            </h4>

                            <p class="description_text">
                                <?= htmlspecialchars($news->getDescriptifArticle())?>
                            </p>

                            <p class="titre">
                                <?='Modifié le : ' . htmlspecialchars($news->getDateModification())?>
                            </p>
                        </div>
                    </div>
                    <img src="<?= htmlspecialchars($news->getImageArticle())?>" class="img-responsive" alt="image_article">

                </a>
            </div>
            <?php
            }
            ?> 
        </div>
    </div>
</section>



<!-- Footer -->
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
<div class="scroll-top page-scroll hidden-sm hidden-lg hidden-md">
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

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>         


