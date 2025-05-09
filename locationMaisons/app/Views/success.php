<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succès - Création de Compte</title>
    <!-- Lien vers Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Bootstrap JS et Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Container principal -->
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row text-center">
        <div class="col-12">
            <!-- Card de confirmation -->
            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    <!-- Icône de succès -->
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 0 8 16 8 8 0 0 0 16 8zM7.146 11.146a.5.5 0 0 1-.708 0L3.5 8.707 4.207 8l2.939 2.939L11.854 5.854a.5.5 0 0 1 .708.708L7.146 11.146z"/>
                        </svg>
                    </div>
                    <!-- Message de succès -->
                    <h3 class="card-title">Félicitations !</h3>
                    <p class="card-text">Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter et accéder à votre espace personnel.</p>
                    <!-- Bouton pour rediriger l'utilisateur -->
                    <a href="<?= base_url('/login')?>" class="btn btn-primary">Se connecter</a>
                    <a href="../locationMaisons" class="btn btn-link">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>