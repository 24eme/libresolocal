<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mb-3">
        <h2 class="mt-4 mb-3"><?php echo $commerce->getName(); ?> <small class="text-secondary"><?php echo $commerce->getAddress(); ?></small></h2>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="informations_nav" data-toggle="tab" href="#informations_tab" role="tab" aria-controls="informations_tab" aria-selected="false">Informations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="pages_nav" data-toggle="tab" href="#pages_tab" role="tab" aria-controls="pages_tab" aria-selected="true">Pages <span class="badge badge-dark"><?php echo count($commerce->getPages()) ?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reviews_nav" data-toggle="tab" href="#reviews_tab" role="tab" aria-controls="reviews_tab" aria-selected="false">Avis <span class="badge badge-dark"><?php echo count($commerce->getReviews()) ?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="images_nav" data-toggle="tab" href="#images_tab" role="tab" aria-controls="images_tab" aria-selected="false">Images <span class="badge badge-dark"></span></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pages_tab" role="tabpanel" aria-labelledby="pages_nav">
                <?php foreach($commerce->getPages() as $page): ?>
                    <div class="card mt-2">
                      <div class="row no-gutters">
                        <div class="col-md-4">
                          <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents($page->getImageFile())); ?>" class="card-img" alt="">
                        </div>
                        <div class="col-md-4">
                          <div class="card-body">
                            <h5 class="card-title"><?php echo $page->getPlateform() ?></h5>
                            <p class="card-text"><?php echo $page->getName() ?></p>
                            <p class="card-text"><?php echo $page->getAddress() ?></p>
                            <p class="card-text"><a href=""><?php echo $page->getPhone() ?></a> <br />
                            <a href=""><?php echo $page->getWebsite() ?></a></p>
                            <p class="card-text"><?php echo $page->getScore() ?> <?php echo ($page->getReviewsCount()) ? $page->getReviewsCount() : 'aucun' ?> avis</p>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="card-body">
                            <h5 class="card-title">&nbsp;</h5>
                            <p class="card-text">
                                Lundi&nbsp;:&nbsp;<?php echo $page->getHour('lundi') ?><br />
                                Mardi&nbsp;:&nbsp;<?php echo $page->getHour('mardi') ?><br />
                                Mercredi&nbsp;:&nbsp;<?php echo $page->getHour('mercredi') ?><br />
                                Jeudi&nbsp;:&nbsp;<?php echo $page->getHour('jeudi') ?><br />
                                Vendredi&nbsp;:&nbsp;<?php echo $page->getHour('vendredi') ?><br />
                                Samedi&nbsp;:&nbsp;<?php echo $page->getHour('samedi') ?><br />
                                Dimanche&nbsp;:&nbsp;<?php echo $page->getHour('dimanche') ?>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="tab-pane fade show pt-3" id="reviews_tab" role="tabpanel" aria-labelledby="reviews_nav">
                <?php foreach($commerce->getReviews() as $review): ?>
                    <span class="text-secondary"><?php echo $review[3]; ?></span>&nbsp;<span class="badge badge-info"><?php //echo $page->getPlateform(); ?></span><span class="badge badge-warning float-right"><?php echo $review[4]; ?></span>
                    <p class="mt-2"><?php echo $review[6]; ?><br /><small><em><?php echo $review[5]; ?></em></small></p>

                    <hr />
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
