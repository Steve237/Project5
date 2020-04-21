<?php session_start();?>
<?php $this->title = 'Inscription'; ?>

<!-- Contact Section -->
<section id="contact" class="connection-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_form">Inscrivez vous </h2>
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
                    Vous êtes désormais inscrit, <a href="index.php?action=connection">connectez vous</a>!
                </div>
                <?php endif; ?>

                <form action="../public/index.php?action=inscription" id="formInscription" method="post" class="col-xs-12">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="pseudo">Votre pseudo</label>
                            <input required placeholder="Entrez votre pseudo" type="text" name="pseudo" class="form-control">
                        </div>
                    </div>

                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">Votre adresse email</label>
                            <input required type="email" placeholder="Entrez votre adresse email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="password">Votre mot de passe</label>
                            <input required type="password" placeholder="Entrez votre mot de passe" name="password" class="form-control">
                        </div>
                    </div>

                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="password2">Confirmez votre mot de passe</label>
                            <input required type="password" placeholder="Entrez votre mot de passe" name="password_confirm" class="form-control">
                        </div>
                    </div><br>

                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="inscription">Envoyer</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<?php
unset($_SESSION['success']);
unset($_SESSION['errors']);
?>