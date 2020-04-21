<?php session_start(); ?>
<?php $this->title = 'Récupération du mot de passe'; ?>

<!-- Contact Section -->
<section id="contact" class="connection-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_form">Récupération du mot de passe </h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <?php if ($section == 'updatepassword') { 
                    ?>

                    <?php if (array_key_exists('errors', $_SESSION)): ?>
                    <div class="alert alert-danger">
                        <?= implode('<br>', $_SESSION['errors']); ?>
                    </div>
                    <?php endif; ?>
                
                    <form action="../public/index.php?action=recoverypass" id="form_recovery" method="post" class="col-xs-12">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="password">Votre nouveau mot de passe </label>
                            <input required placeholder="Entrez votre nouveau mot de passe" type="password" name="newpass" class="form-control">
                            <label for="password"> Confirmation du nouveau mot de passe </label>
                            <input required placeholder="Confirmez votre nouveau mot de passe" type="password" name="confirmpass" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="pass_submit">Valider</button>
                        </div>
                    </div>

                    </form>

                    <?php 
                }

                else { 
                
                    ?>

                    <?php if (array_key_exists('errors', $_SESSION)): ?>
                    <div class="alert alert-danger">
                        <?= implode('<br>', $_SESSION['errors']); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (array_key_exists('success', $_SESSION)): ?>
                    <div class="alert alert-success">
                        Vous avez reçu un lien pour rénitialiser votre mot de passe sur votre boite mail
                    </div>
                    <?php endif; ?>

                    <form action="index.php?action=recoverypass" id="form_recovery" method="post">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">Votre adresse email</label>
                            <input required placeholder="Entrez votre adresse email" type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="recoverysubmit">Envoyer</button>
                        </div>
                    </div>
                    </form>
                    <?php 
                } 
                ?>
            </div>
        </div>
    </div>
</section>


<?php
unset($_SESSION['success']);  
unset($_SESSION['errors']);  
?>