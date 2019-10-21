<?php $title = 'Mon blog'; ?>
<<<<<<< HEAD

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

            <?php if(array_key_exists('success_connect', $_SESSION)): ?>
            <div class="hidden-xs hidden-md hidden-lg" style="color:white; position:absolute; right: 14px; top: 5px;">
                <?= $_SESSION['success_connect'];?></div>
            <form class="hidden-xs hidden-md hidden-lg" action="index.php?action=disconnected" method="post" style="position:fixed; right:15px; top:40px;">
                <button style="color:red; margin-top:-8px" type="submit" class="btn btn-success btn-default" name="disconnect">Déconnexion</button>
            </form>
            <?php endif; ?>

            <?php if(!array_key_exists('success_connect', $_SESSION)): ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden"><a href="#page-top"></a></li>
                <li><a href="index.php">Accueil</a></li>
                <li class="page-scroll"><a href="index.php?action=listposts"> Nos articles </a></li>
                <li class="page_scroll"><a href="index.php?action=connection"> Espace membres </a></li>
                <li class="page_scroll"><a href="index.php?action=connect_admin"> Espace administrateur </a></li>
            </ul>
            <?php endif; ?>

            <?php if(array_key_exists('success_connect', $_SESSION)): ?>
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



<?php if(array_key_exists('success_connect', $_SESSION)): ?>
<section class="section_connection">
    <div class="connect-sign hidden-sm" style="color:red;"><?= $_SESSION['success_connect']; ?></div>
    <form action="index.php?action=disconnected" method="post">
        <button style="color:white;height:35px" type="submit" class="btn btn-success btn-default button-disconnect hidden-sm"                                           name="disconnect">Déconnexion</button>
    </form>
</section>    
<?php endif; ?>


<!-- Header -->
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <img class="img-responsive" src="public/img/steve_essama.jpg" alt="webmaster">
                <div class="intro-text">
                    <span class="name">Steve Essama</span>
                    <hr class="star-light">
                    <span class="skills">Développeur d'applications web!</span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- About Section -->
<section class="success" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>A propos</h2>
                <hr class="star-light">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-lg-offset-2">
                <p>
                    Je soussigné Steve Essama, je suis agé de 27 ans, et je réalise des sites web en utilisant divers langages de développement, notamment                           le Php. Ce site est l'une de mes conceptions, visant à exposer mes talents et à partager des articles sur divers thèmes.
                </p>
            </div>
            <div class="col-lg-4">
                <p>
                    Ma passion pour l'informatique et mon désir de devenir développeur web professionel m'ont conduit à démarrer une formation,                                     sur Openclassroom, afin d'obtenir le titre professionel de développeur d'applications en Php Symfony.
                </p>
            </div>

            <div class="col-lg-8 col-lg-offset-2 text-center">
                <a href="public/cv_steve.pdf" class="btn btn-lg btn-outline"><i class="fa fa-download"></i> Voir mon cv </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Contactez moi</h2>
                <hr class="star-primary">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <?php if(array_key_exists('errors', $_SESSION)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $_SESSION['errors']); ?>
                </div>
                <?php endif; ?>

                <?php if(array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success">
                    Votre message à bien été transmis !
                </div>
                <?php endif; ?>

                <form action="index.php?action=sendmail" id="formContact" method="post">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="name">Votre nom</label>
                            <input required placeholder="Entrez votre nom" type="text" name="name" class="form-control" id="inputname" 
                            value="<?php echo isset($_session['inputs']['name'])? $_session['inputs']['name'] : ''; ?>">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">Votre adresse email</label>
                            <input required type="email" placeholder="Entrez votre adresse email" name="email" class="form-control" id="email"                                               value="<?php echo isset($_session['inputs']['email'])? $_session['inputs']['email'] : ''; ?>">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>

                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="message">Votre message</label>
                            <textarea id="inputmessage" name="message" class="form-control"><?php echo isset($_SESSION['inputs']['message'])?                                               $_SESSION['inputs']['message'] : ''; ?></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div><br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg">Envoyer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


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
                            <a href="https://openclassrooms.facebook.com/profile.php?id=100030215146732" class="btn-social btn-outline"><i class="fa fa-fw                                   fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/in/essama-mgba-franck-steve-7a6227175/" class="btn-social btn-outline"><i class="fa fa-fw fa-                                 linkedin"></i></a>
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


=======
<?php ob_start(); ?>
<!-- Navigation -->
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
			
            <?php if(array_key_exists('success_connect', $_SESSION)): ?>
                <div style="color:red; position:absolute; right: 14px; top: 5px;"><?= $_SESSION['success_connect']; ?></div>
                <form action="index.php?action=disconnected" method="post" style="position:fixed; right:15px; top:40px;">
                <button style="color:red; margin-top:-8px" type="submit" class="btn btn-success btn-default" name="disconnect">Déconnexion</button>
                </form>
                <?php endif; ?>
            
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden"><a href="#page-top"></a></li>
				<li><a href="index.php">Accueil</a></li>
				<li class="page-scroll"><a href="index.php?action=listposts"> Nos articles </a></li>
				<li class="page_scroll"><a href="index.php?action=connection"> Espace membres </a></li>
                <li class="page_scroll"><a href="index.php?action=connect_admin"> Espace administrateur </a></li>
            </ul>
		
        </div>
		<!-- /.navbar-collapse -->
	</div>
	    <!-- /.container-fluid -->
</nav>
<!-- Header -->
<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<img class="img-responsive" src="public/img/steve_essama.jpg" alt="">
				<div class="intro-text">
					<span class="name">Steve Essama</span>
					<hr class="star-light">
					<span class="skills">Développeur d'applications web!</span>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- About Section -->
<section class="success" id="about">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2>A propos</h2>
				<hr class="star-light">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-lg-offset-2">
				<p>
					 Je soussigné Steve Essama, je suis agé de 27 ans, et je réalise des sites web en utilisant divers langages de développement, notamment                          lePhp. Ce site est l'une de mes conceptions, visant à exposer mes talents et à partager des articles sur divers thèmes.
				</p>
			</div>
			<div class="col-lg-4">
				<p>
					 Ma passion pour l'informatique et mon désir de devenir développeur web professionel m'ont conduit à démarrer une formation,                                      surOpenclassroom, afin d'obtenir le titre professionel de développeur d'applications en Php Symfony.
				</p>
			</div>
			<div class="col-lg-8 col-lg-offset-2 text-center">
				<a href="public/cv_steve.pdf" class="btn btn-lg btn-outline"><i class="fa fa-download"></i> Voir mon cv </a>
			</div>
		</div>
	</div>
</section>
<!-- Contact Section -->
<section id="contact">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2>Contactez moi</h2>
				<hr class="star-primary">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<?php if(array_key_exists('errors', $_SESSION)): ?>
				<div class="alert alert-danger">
					<?= implode('<br>', $_SESSION['errors']); ?>
				</div>
				<?php endif; ?>
				<?php if(array_key_exists('success', $_SESSION)): ?>
				<div class="alert alert-success">
					 Votre message à bien été transmis !
				</div>
				<?php endif; ?>
				<form action="index.php?action=sendmail" id="formContact" method="post">
					<div class="row control-group">
						<div class="form-group col-xs-12 floating-label-form-group controls">
							<label for="name">Votre nom</label>
							<input required placeholder="Entrez votre nom" type="text" name="name" class="form-control" id="inputname" 
                            value="<?php echo isset($_session['inputs']['name'])? $_session['inputs']['name'] : ''; ?>">
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<div class="row control-group">
						<div class="form-group col-xs-12 floating-label-form-group controls">
							<label for="email">Votre adresse email</label>
							<input required type="email" placeholder="Entrez votre adresse email" name="email" class="form-control" id="email" 
                            value="<?php echo isset($_session['inputs']['email'])? $_session['inputs']['email'] : ''; ?>">
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<div class="row control-group">
						<div class="form-group col-xs-12 floating-label-form-group controls">
							<label for="message">Votre message</label>
							<textarea id="inputmessage" name="message" class="form-control">
                                <?php echo isset($_SESSION['inputs']['message'])? $_SESSION['inputs']['message'] : ''; ?></textarea>
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<br>
					<div id="success"></div>
					<div class="row">
						<div class="form-group col-xs-12">
							<button type="submit" class="btn btn-success btn-lg">Envoyer</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- Footer -->
<footer class="text-center">
	<div class="footer-above">
		<div class="container">
			<div class="row">
				<div class="footer-col col-md-4">
					<h3>Adresse</h3>
					<p>
						 27 rue Arago, 
						<br>
						 Villeurbanne, 69100
					</p>
				</div>
				<div class="footer-col col-md-4">
					<h3>Réseaux sociaux</h3>
					<ul class="list-inline">
						<li>
							<a href="https://openclassrooms.facebook.com/profile.php?id=100030215146732" class="btn-social btn-outline">
                                <i class="fa fa-fwfa-facebook"></i></a>
						</li>
						<li>
							<a href="https://www.linkedin.com/in/essama-mgba-franck-steve-7a6227175/" class="btn-social btn-outline">
                                <i class="fa fa-fw fa-linkedin"></i></a>
						</li>
					</ul>
				</div>
				<div class="footer-col col-md-4">
					<h3>About Freelancer</h3>
					<p>
				        Freelance is a free to use, open source Bootstrap theme created by 
						<a href="http://startbootstrap.com">Start Bootstrap</a>
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
>>>>>>> master
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
<<<<<<< HEAD


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
<?php  unset($_SESSION['inputs']);  
unset($_SESSION['success']);  
unset($_SESSION['errors']);  ?>
=======
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
<?php  unset($_SESSION['inputs']);  unset($_SESSION['success']);  unset($_SESSION['errors']);  ?>
>>>>>>> master
