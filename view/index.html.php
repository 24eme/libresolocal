<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body class="bg-light">
      <div class="container text-center mt-5">
        <h1>Libre Solocal</h1>
        <form action="/search" method="GET">
            <div class="row">
                <div class="col"></div>
                <div class="input-group col-8 mt-5">
                    <input autofocus="autofocus" class="form-control form-control-lg" type="text" placeholder="Rechercher un commercant : Boulangerie Au Bon Pain Nantes" name="q" id="input-search" value="<?php echo isset($_GET['q']) ? $_GET['q'] : null ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Chercher</button>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </form>
    </div>
  </body>
</html>
