<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title><?= $title ?></title>
</head>
<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <a href="#" class="navbar-brand">Mon site</a>
           
    </nav>


     <div class="container mt-4">

        <?= $content ?>

     </div>


     <footer class="bg-light py-4 footer mt-auto">

       <div class="container">
            Page générée en ms
       </div>

     </footer>


  </body>
</html>