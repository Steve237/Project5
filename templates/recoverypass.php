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
                
                <?php if (array_key_exists('errors', $_SESSION)): ?>
                    <div class="alert alert-danger">
                        <?= implode('<br>', $_SESSION['errors']); ?>
                    </div>
                <?php endif; ?>

                <?php if (array_key_exists('sendrecovery', $_SESSION)): ?>
                    <div class="alert alert-success">
                        Vous avez reçu un lien pour rénitialiser votre mot de passe sur votre boite mail
                    </div>
                <?php endif; ?>

                <form action="../public/index.php?action=recoverypass" id="form_recovery" method="post">
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
            </div>
        </div>
    </div>
</section>


<?php
unset($_SESSION['sendrecovery']);  
unset($_SESSION['errors']);  
?>