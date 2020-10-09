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
            <form id="form-search" class="mt-4">
                <div class="input-group mb-3">
                    <input autofocus="autofocus" class="form-control form-control-lg" type="text" placeholder="Rechercher un commercant, par exemple : Boulangerie Au Bon Pain Marseille" name="q" id="input-search" value="<?php echo isset($_GET['q']) ? $_GET['q'] : null ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Chercher</button>
                    </div>
                </div>
            </form>
        <div id="resultat_container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="vue_ensemble_nav" data-toggle="tab" href="#vue_ensemble_tab" role="tab" aria-controls="vue_ensemble_tab" aria-selected="true">Sites <span class="badge badge-dark"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="avis_nav" data-toggle="tab" href="#avis_tab" role="tab" aria-controls="avis_tab" aria-selected="false">Avis <span class="badge badge-dark"></span></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="vue_ensemble_tab" role="tabpanel" aria-labelledby="vue_ensemble_nav"></div>
                <div class="tab-pane fade show pt-3" id="avis_tab" role="tabpanel" aria-labelledby="avis_nav">
                </div>
            </div>
            <div id="loader" class="card mt-2">
              <div class="row no-gutters">
                  <div class="card-body text-center">
                      <div class="spinner-border text-secondary" role="status">
                          <span class="sr-only">Loading...</span>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('#loader').hide();
        var search = function(term) {
            $("#main").html("");
            $('#loader').show();
            var nb2load = 0;
            jQuery.getJSON("/search.php", $('#form-search').serialize(), function(data) {
                nb2load = data.length;
                if(!nb2load) {
                    $('#loader').hide();
                    $('#loader')
                }
                for(k in data) {
                    jQuery.get("/page.php", data[k], function(html) {
                        $("#vue_ensemble_tab").append(html);
                        nb2load = nb2load - 1;
                        if(!nb2load) {
                            $('#loader').hide();
                        }
                        $('#vue_ensemble_nav .badge').text($('#vue_ensemble_tab .card').length);
                    });
                }
                for(k in data) {
                    jQuery.get("/avis.php", data[k], function(html) {
                        $("#avis_tab").append(html);
                        $('#avis_nav .badge').text($('#avis_tab p').length);
                    });
                }
            });
        }

        $('#form-search').on('submit', function() {
            history.pushState({}, $('#input-search').val(), "?q="+$('#input-search').val());
            search();
            return false;
        });

        if($('#input-search').val()) {
            search();
        }
    </script>
  </body>
</html>
