<?php $title = 'Mon blog'; ?>

    <?php ob_start(); ?>

        <!-- Contact Section -->
        <section id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Connectez vous </h2>
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
                                        Vous êtes désormais connecté
                                    </div>
                                    <?php endif; ?>

                                        <form action="index.php?action=connection" id="formInscription" method="post">
                                            <div class="row control-group">
                                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                                    <label for="pseudo">Votre pseudo</label>
                                                    <input required placeholder="Entrez votre pseudo" type="text" name="pseudo" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row control-group">
                                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                                    <label for="password">Votre mot de passe</label>
                                                    <input type="password" required placeholder="Entrez votre mot de passe" name="password" 
                                                    class="form-control">

                                                </div>
                                            </div>

                                            <br>
                                            <div id="success"></div>
                                            <div class="row">
                                                <div class="form-group col-xs-12">
                                                    <button type="submit" class="btn btn-success btn-lg" name="connection">Envoyer</button>
                                                </div>
                                            </div>

                                        </form>
                                        <p><a href="index.php?action=password_recovery">Cliquez ici si vous avez oublié votre mot de passe</a></p>
                                        <p> Si vous n'avez pas encore de compte, <a href="index.php?action=inscription">inscrivez vous.</a></p>
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