<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>

<?php if (array_key_exists('success_connect', $_SESSION)): ?>
<section class="section_connection">
    <div class="connect-sign hidden-sm"><?= $_SESSION['success_connect']; ?></div>
    <form action="index.php?action=disconnected" method="post">
        <button type="submit" class="btn btn-success btn-default button-disconnect hidden-sm"                                                                           name="disconnect">Déconnexion</button>
    </form>
</section>    
<?php endif; ?>


<?php if (!array_key_exists('success_connect', $_SESSION)): ?>
<section id="portfolio" class="list_post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_portfolio">Nos icônes</h2>
                <hr class="star-primary">
            </div>
        </div>


        <div class="row">
            <?php
            foreach($newsList->getListPosts() as $news) {
                ?>
                <div class="col-sm-6 col-md-4 col-lg-4 portfolio-item">
                    <a href="index.php?action=post&amp;id=<?= $news->getIdPost()?>&amp;titre=<?= $news->getTitreArticle()?>" class="portfolio-link">
                        <div class="caption">
                            <div class="caption-content">
                                <h6 class="hidden-sm hidden-md hidden-lg">
                                    <?= htmlspecialchars($news->getTitreArticle())?>
                                </h6>

                                <h3 class="hidden-xs hidden-md hidden-lg">
                                    <?= htmlspecialchars($news->getTitreArticle())?>
                                </h3>

                                <h4 class="hidden-xs hidden-sm">
                                    <?= htmlspecialchars($news->getTitreArticle())?>
                                </h4>

                                <p class="description_text">
                                    <?= htmlspecialchars($news->getDescriptifArticle())?>
                                </p>

                                <p class="titre">
                                    <?='Modifié le : ' . htmlspecialchars($news->getDateModification())?>
                                </p>
                            </div>
                        </div>
                        <img src="<?= htmlspecialchars($news->getImageArticle())?>" class="img-responsive" alt="image_article">
                    </a>
                </div>
                <?php
            }
            ?> 
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (array_key_exists('success_connect', $_SESSION)): ?>
<section id="portfolio" class="post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="titre_portfolio">Nos icônes</h2>
                <hr class="star-primary">
            </div>
        </div>


        <div class="row">
            <?php
            foreach($newsList->getListPosts() as $news) {
                ?>
                <div class="col-sm-6 col-md-4 col-lg-4 portfolio-item">
                    <a href="index.php?action=post&amp;id=<?= $news->getIdPost()?>&amp;titre=<?= $news->getTitreArticle()?>" class="portfolio-link">
                        <div class="caption">
                            <div class="caption-content">
                                <h6 class="hidden-sm hidden-md hidden-lg">
                                    <?= htmlspecialchars($news->getTitreArticle())?>
                                </h6>

                                <h3 class="hidden-xs hidden-md hidden-lg">
                                    <?= htmlspecialchars($news->getTitreArticle())?>
                                </h3>

                                <h4 class="hidden-xs hidden-sm">
                                    <?= htmlspecialchars($news->getTitreArticle())?>
                                </h4>

                                <p class="description_text">
                                    <?= htmlspecialchars($news->getDescriptifArticle())?>
                                </p>

                                <p class="titre">
                                    <?='Modifié le : ' . htmlspecialchars($news->getDateModification())?>
                                </p>
                            </div>
                        </div>
                        <img src="<?= htmlspecialchars($news->getImageArticle())?>" class="img-responsive" alt="image_article">
                    </a>
                </div>
                <?php
            }
            ?> 
        </div>
    </div>
</section>
<?php endif; ?>


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>         


