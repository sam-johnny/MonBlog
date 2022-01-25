<?php $linkNavBar = new \App\HTML\NavBar(); ?>

<!doctype html>
<html lang="fr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="/img/favicon.ico" />
    <title><?= isset($title) ? htmlentities($title) : 'Mon site' ?></title>

</head>

<body class="d-flex flex-column min-vh-100">
<!--Barre de navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Mon blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!--Navbar-->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?= $linkNavBar->link('/', 'Home'); ?>
                <?= $linkNavBar->link('/blog', 'Blog'); ?>
                <?= $linkNavBar->link('/contact', 'Contact'); ?>
            </ul>

            <!--Dropdown pour le role admin-->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if (isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin'): ?>
                    <div class="dropdown mx-3">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Admin
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <?= $linkNavBar->dropdown('/admin/posts', 'Gestion des articles'); ?>
                            <?= $linkNavBar->dropdown('/admin/categories', 'Gestion des catégories'); ?>
                            <?= $linkNavBar->dropdown('/admin/comments', 'Gestion des commentaires'); ?>
                            <?= $linkNavBar->dropdown('/admin/users', 'Gestion des utilisateurs'); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!--Bouton de connexion ou de déconnexion-->
                <?php if (!isset($_SESSION['auth'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm" href="/login">Se connecter</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-sm" href="/logout">Se déconnecter</a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
    </div>
</nav>

<div class="container">
    <!--Les sections dynamiques-->
    <?= $content ?>
</div>

<!--Footer-->
<footer class="bg-light text-center text-lg-start mt-auto">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Citation</h5>
                <p>
                    "Un bon site web est toujours en contruction!"
                </p>
            </div>
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0 text-center">
                <h5 class="text-uppercase">Pour me retrouver</h5>
                <a href="#!"><img src="https://img.icons8.com/ios/24/000000/facebook-circled--v2.png"/></a>
                <a href="#!"><img src="https://img.icons8.com/ios/24/000000/linkedin-circled--v3.png"/></i></a>
                <a href="#!"><img src="https://img.icons8.com/ios/24/000000/twitter-circled--v1.png"/></a>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3 bg-dark text-white">
        © 2022 Copyright: Mon blog
    </div>
</footer>


<!--Bootstrap Bundle with Popper-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
