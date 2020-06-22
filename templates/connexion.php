<?php 

if (array_key_exists('success_connect', $_SESSION)) {

header('Location: ../public/index.php');
}

?>

<?php $this->title = 'Connexion à l\'espace membre'; ?>

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

                <?php if (array_key_exists('activation', $_SESSION)): ?>
                <div class="alert alert-danger">
                    Vous aviez déjà confirmé votre inscription, connectez vous.
                </div>
                <?php endif; ?>

                <?php if (array_key_exists('confirmation', $_SESSION)): ?>
                <div class="alert alert-success">
                    Votre compte est désormais activé, vous pouvez vous connecter
                </div>
                <?php endif; ?>    

                <?php if (array_key_exists('erroractivation', $_SESSION)): ?>
                <div class="alert alert-danger">
                    Erreur d'activation, le lien n'est pas valide.
                </div>
                <?php endif; ?>   

                <?php if (array_key_exists('success', $_SESSION)): ?>
                <div class="alert alert-success">
                    Votre mot de passe a été mis à jour, vous pouvez vous connecter.
                </div>
                <?php endif; ?>   


               <form action="../public/index.php?action=connexion" id="formConnexion" method="post" class="col-xs-12">
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

                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="connection">Envoyer</button>
                        </div>
                    </div>

                </form>
                <p><a href="../public/index.php?action=recoverypass">Cliquez ici si vous avez oublié votre mot de passe</a></p>
                <p> Si vous n'avez pas encore de compte, <a href="../public/index.php?action=inscription">inscrivez vous.</a></p>
            </div>
        </div>
    </div>
</section>

<?php
unset($_SESSION['success']);
unset($_SESSION['errors']);
unset($_SESSION['activation']);
unset($_SESSION['confirmation']);
unset($_SESSION['erroractivation']);
unset($_SESSION['success_connect1']);
?>