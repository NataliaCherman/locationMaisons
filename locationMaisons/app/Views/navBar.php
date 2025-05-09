<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>"><img src="<?= base_url('images/logo.png') ?>" alt="Logo" height="40" class="me-2"></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/vitrineGuesthouses') ?>">Catalogue</a>
                </li>

                <?php if (session()->has('idUtilisateur')): ?>
                    <li class="nav-item">
                <!--Modifier nom dashboard-->
                        <a class="nav-link" href="<?= base_url('/personalArea') ?>">Tableau de bord</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/userData') ?>">Gestion du profil</a>
                    </li>

                    <?php if (session()->get('role') === 'Administrateur'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/allUsers') ?>">Tous les utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/allGuesthouses') ?>">Toutes les maisons</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/createGuesthouse') ?>">Créer une maison</a>
                        </li>
                    <!--Ajouter : modifier une maison-->
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/se_deconnecter') ?>">Déconnexion</a>
                    </li>
  
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary text-white mx-1" href="<?= base_url('/login') ?>">Connexion</a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-success text-white mx-1" href="<?= base_url('/creer_compte') ?>">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>