<?php $title = htmlspecialchars($news->titre_article()); ?>

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


<!-- Portfolio Modals -->
    <div class="portfolio-modal" tabindex="-1">
        <div class="modal-content">
            <div class="close-modal">
                
                <a href="index.php?action=listposts">
                    <div class="lr">
                        <div class="rl"></div>
                    </div>
                </a>
            </div>
            
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">

                            <h2><?= htmlspecialchars($news->titre_article()) ?></h2>
                            <hr class="star-primary">
                            <p><?= htmlspecialchars($news->descriptif_article())?></p>
                            <img src="<?= htmlspecialchars($news->image_article()) ?>" class="img-responsive img-centered" alt="">
                            <p><?= nl2br(htmlspecialchars($news->contenu()))?></p>
                            <ul class="list-inline item-details">
                                <li>Auteur:
                                    <strong><?= htmlspecialchars($news->pseudo_auteur())?></strong>
                                </li>
                                <li>Date de mise à jour:
                                    <strong><?= htmlspecialchars($news->date_modification())?></strong>
                                </li>
                            </ul>
                            
                            
                         
                            <?php if(array_key_exists('errors', $_SESSION)): ?>
                            <div class="alert alert-danger">
                                <?= implode('<br>', $_SESSION['errors']); ?>
                            </div>
                            <?php endif; ?>
                            <h3>Laissez un commentaire </h3>
                            <form action="index.php?action=post&amp;id=<?= $news->id_post()?>&amp;titre=<?= $news->titre_article()?>" id="comment"                                       method="post">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 floating-label-form-group controls">
                                        <label for="pseudo_user">Votre pseudo</label>
                                        <input required placeholder="Entrez votre pseudo" type="text" name="pseudo" class="form-control">
                                    </div>
                                </div>

                                <div class="row control-group">
                                    <div class="form-group col-xs-12 floating-label-form-group controls">
                                        <label for="commentaire">Entrez votre commentaire</label>
                                        <textarea name="user_comment" class="form-control">Entrez votre commentaire</textarea>
                                    </div>
                                </div>

                                <br>
                                <div id="success"></div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit_comment">Envoyer</button>
                                    </div>
                                </div>

                            </form>
                            
                            
                            <?php
                                foreach($listComments as $comments)
                                {
                                ?>
                                    <h2><?= htmlspecialchars($comments->contenu_commentaire()) ?></h2>
                        
                                 <?php
                                }
                
                                ?> 
                        
                        
                        
                        
                        
                        
                        
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
    
<?php
    unset($_SESSION['success']);
    unset($_SESSION['errors']);
    unset($_SESSION['success_connect']);
?>    

                    
                
                
                
    
    