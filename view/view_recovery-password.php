<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>


<?php if (array_key_exists('success_connect', $_SESSION)): ?>

<section class="section_connection">
    <div class="connect-sign hidden-sm"><?= $_SESSION['success_connect']; ?></div>
    <form action="index.php?action=disconnected" method="post">
        <button type="submit" class="btn btn-success btn-default button-disconnect hidden-sm" name="disconnect">Déconnexion</button>
    </form>
</section>
<?php endif; ?>


<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Récupération du mot de passe </h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <?php if ($section == 'update_password') { 
                    ?>

                    <?php if (array_key_exists('errors', $_SESSION)): ?>
                    <div class="alert alert-danger">
                        <?= implode('<br>', $_SESSION['errors']); ?>
                    </div>
                    <?php endif; ?>
                
                    <?php if (array_key_exists('success', $_SESSION)): ?>
                    <div class="alert alert-success">
                        Votre mot de passe a été mis à jour
                    </div>
                    <?php endif; ?>

                    <form action="index.php?action=recovery_pass" id="form_recovery" method="post">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="password">Votre nouveau mot de passe </label>
                            <input required placeholder="Entrez votre nouveau mot de passe" type="password" name="new_pass" class="form-control">
                            <label for="password"> Confirmation du nouveau mot de passe </label>
                            <input required placeholder="Confirmez votre nouveau mot de passe" type="password" name="confirm_pass" class="form-control">
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

                    <form action="index.php?action=recovery_pass" id="form_recovery" method="post">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="email">Votre adresse email</label>
                            <input required placeholder="Entrez votre adresse email" type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <br>

                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg" name="recovery_submit">Envoyer</button>
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


<?php $content = ob_get_clean();?>
<?php require('template.php');?>

<?php
unset($_SESSION['success']);  
unset($_SESSION['errors']);  
?>