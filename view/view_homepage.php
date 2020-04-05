<?php $title = 'Mon blog'; ?>

<?php ob_start();?>

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
                <?php if (array_key_exists('errors', $_SESSION)): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', $_SESSION['errors']); ?>
                </div>
                <?php endif; ?>

                <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success">
                    Votre message à bien été transmis !
                </div>
                <?php endif; ?>

                <form action="index.php?action=sendmail" id="formContact" method="post">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="name">Votre nom</label>
                            <input required placeholder="Entrez votre nom" type="text" name="name" class="form-control" id="inputname">
                            
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">Votre adresse email</label>
                            <input required type="email" placeholder="Entrez votre adresse email" name="email" class="form-control" id="email">
                            
                        </div>
                    </div>

                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="message">Votre message</label>
                            <textarea id="inputmessage" name="message" class="form-control"></textarea>
                            
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


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>


<?php  
unset($_SESSION['success']);  
unset($_SESSION['errors']); 
?>