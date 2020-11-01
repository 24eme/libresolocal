<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $commerce->getName(); ?> - Libre Solocal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <div class="container mb-3">
        <h2 class="mt-4 mb-3"><?php echo $commerce->getName(); ?> <small class="text-secondary"><?php echo $commerce->getAddress(); ?></small></h2>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="informations_nav" data-toggle="tab" href="#informations_tab" role="tab" aria-controls="informations_tab" aria-selected="true">Informations <span class="badge badge-primary badge-pill"><?php echo count($commerce->getPages()) ?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reviews_nav" data-toggle="tab" href="#reviews_tab" role="tab" aria-controls="reviews_tab" aria-selected="false">Avis <span class="badge badge-primary badge-pill"><?php echo count($commerce->getReviews()) ?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="images_nav" data-toggle="tab" href="#images_tab" role="tab" aria-controls="images_tab" aria-selected="false">Images <span class="badge badge-primary badge-pill"></span></a>
            </li>
        </ul>
        <div class="tab-content bg-white border-left border-right border-bottom p-3">
            <div class="tab-pane show active" id="informations_tab" role="tabpanel" aria-labelledby="informations_nav">
                <ul class="list-group list-group-flush">
                <?php foreach($commerce->getPages() as $page): ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-4">
                                  <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents($page->getImageFile())); ?>" class="card-img" alt="">
                                </div>
                                <div class="col-md-4">

                                    <h6 style="opacity: 0.6;" class="pb-1 text-uppercase border-bottom"><?php echo $page->getPlateform() ?>
                                        <ul class="list-inline float-right small">
                                            <li class="list-inline-item"><a href="">Modifier</a></li>
                                            <li class="list-inline-item"><a target="_blank" href="<?php echo $page->getUrl() ?>">Voir</a></li>
                                        </ul>
                                    </h6>
                                    <h6 class="pt-2 mb-3"><strong><?php echo $page->getName() ?></strong></h6>
                                    <p><?php echo str_replace(",", "<br />", $page->getAddress()); ?></p>
                                    <p class="mb-2"><?php echo $page->getPhone() ?><br />
                                    <a href=""><?php echo $page->getWebsite() ?></a></p>
                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-striped table-sm small mb-0">
                                        <tr>
                                            <th class="text-center" colspan="2">Ouvertures</th>
                                        </tr>
                                        <tr>
                                            <th>Lundi</th>
                                            <td><?php echo $page->getHour('lundi') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mardi</th>
                                            <td><?php echo $page->getHour('mardi') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mercredi</th>
                                            <td><?php echo $page->getHour('mercredi') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jeudi</th>
                                            <td><?php echo $page->getHour('jeudi') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Vendredi</th>
                                            <td><?php echo $page->getHour('vendredi') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Samedi</th>
                                            <td><?php echo $page->getHour('samedi') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Dimanche</th>
                                            <td><?php echo $page->getHour('dimanche') ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="tab-pane" id="reviews_tab" role="tabpanel" aria-labelledby="reviews_nav">
                <div class="row">
                    <div class="col">
                        <ul class="list-group list-group-flush">
                        <?php foreach($commerce->getReviews() as $review): ?>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-10">
                                        <?php if($review->getContent()): ?>
                                            <p class="mb-2"><?php echo $review->getContent(); ?></p>
                                        <?php else: ?>
                                            <p class="mb-2 text-muted"><em>Aucun message</em></p>
                                        <?php endif; ?>
                                        <span class="blockquote-footer"><?php echo $review->getAuthor(); ?> sur <cite><?php echo $review->getPlateform(); ?></cite><?php if($review->getScore()): ?> qui a mis la note de <strong><?php echo $review->getScore() ?></strong><?php endif; ?></span>
                                    </div>
                                    <div class="col-2 text-right">
                                        <small class="text-muted"><?php echo $review->getDate()->format("F Y"); ?></small>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-3">
                        <?php foreach($commerce->getReviewsFacets() as $facetName => $facets): ?>
                        <h6 class="text-dark"><?php echo $facetName ?></h6>
                        <div class="list-group mb-3">
                            <?php foreach($facets as $name => $value): ?>
                                <a href="" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><small><?php echo $name ?></small> <span class="badge badge-secondary badge-pill"><?php echo $value ?></span></a>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="images_tab" role="tabpanel" aria-labelledby="images_nav">
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script><
    <script type="text/javascript">
        $(function(){
            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });
    </script>


  </body>
</html>
