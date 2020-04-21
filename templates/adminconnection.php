<?php session_start(); ?>

<?php $title = "Connexion à l'espace administrateur"; ?>

<!-- Contact Section -->
<section id="contact" class="connection-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_form">Connectez vous </h2>
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

                <form action="../public/index.php?action=adminconnection" id="form_admin" method="post" class="col-xs-12">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">Votre adresse email</label>
                            <input required placeholder="Entrez votre adresse email" type="text" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="password">Votre mot de passe</label>
                            <input type="password" required placeholder="Entrez votre mot de passe" name="password" class="form-control">
                        </div>
                    </div><br>

                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="connectadmin">Envoyer</button>
                        </div>
                    </div>
                </form>
                <p><a href="index.php?action=recovery_pass">Cliquez ici si vous avez oublié votre mot de passe</a></p>

            </div>
        </div>
    </div>
</section>

<?php
unset($_SESSION['success']);
unset($_SESSION['errors']);
unset($_SESSION['success_connect1']);
?>