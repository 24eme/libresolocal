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
        <div class="mt-4">
            <form id="form-search">
                <div class="input-group mb-3">
                    <input autofocus="autofocus" class="form-control form-control-lg" type="text" placeholder="Rechercher un commercant, par exemple : Boulangerie Au Bon Pain Marseille" name="q" id="input-search" value="<?php echo isset($_GET['q']) ? $_GET['q'] : null ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Chercher</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="main">

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
                for(k in data) {
                    nb2load = data.length;
                    jQuery.get("/page.php", data[k], function(html) {
                        $("#main").append(html);
                        nb2load = nb2load - 1;
                        if(!nb2load) {
                            $('#loader').hide();
                        }
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