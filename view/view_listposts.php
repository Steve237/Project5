<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">Steve Essama</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a href="index.php">Accueil</a>
                    </li>
                    
                    <li class="page-scroll">
                    <a href="index.php?action=listposts"> Nos articles </a>
                    </li>
                    
                    <li class="page-scroll">
                        <a href="index.php?action=connection">Espace d'administration</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

  
    <section id="portfolio">
      <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="titre_portfolio">Nos icônes</h2>
                    <hr class="star-primary">
                </div>
            </div>
            
            
        <div class="row">
                <?php
                      foreach($news_list->getListPosts() as $news)
                {
                ?>
                   
               
            <div class="col-sm-4 portfolio-item">
                    <a href="index.php?action=post&amp;id=<?= $news->id_post()?> " class="portfolio-link">
                        <div class="caption">
                            <div class="caption-content">
                                <h3>
                                <?= htmlspecialchars($news->titre_article())?>
                                </h3>
                                <p>
                                <?= htmlspecialchars($news->descriptif_article())?>
                                </p>
                             <p>
                                <?='Modifié le : ' . htmlspecialchars($news->date_modification())?>
                            </p>
                         </div>
                        </div>
                        <img src="<?= htmlspecialchars($news->image_article())?>" class="img-responsive" alt="">
                        
                    </a>
            </div>
      
                <?php
                  }
                
                ?> 
        </div>
      </div>
    </section>
                
  
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

  <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Adresse</h3>
                        <p>27 rue Arago,
                            <br>Villeurbanne, 69100</p>
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
                        <h3>About Freelancer</h3>
                        <p>Freelance is a free to use, open source Bootstrap theme created by <a href="http://startbootstrap.com">Start Bootstrap</a>.</p>
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
                
                
                
                
                