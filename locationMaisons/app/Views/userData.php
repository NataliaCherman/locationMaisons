<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informations utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?= view('navBar'); ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Mes Informations :</h1>

    <?php if (session()->has('idUtilisateur')): ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <form action="<?= base_url('userData') ?>" method="post" enctype="multipart/form-data">

                        <div class="mb-3 text-center">
                            <label class="form-label">Photo de profil :</label>
                            <div class="d-flex flex-column align-items-center">
                                <?php if (!empty($user['photo'])): ?>
                                    <img src="<?= base_url($user['photo']); ?>" alt="Photo de profil" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                                    <button type="button" class="btn btn-danger btn-sm mt-2">Supprimer</button>
                                <?php else: ?>
                                    <p class="text-muted">Aucune photo disponible</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="photo" class="form-label">Changer la photo :</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom :</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= esc($user['nom']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom :</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= esc($user['prenom']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']); ?>" required>
                        </div>

                        <!--Mot de Passe => récupérer mot de passe et afficher partiellement-->
                        <div class="mb-3">
                            <label for="motDePasse" class="form-label">Nouveau mot de passe :</label>
                            <input type="password" class="form-control" id="motDePasse" name="motDePasse">
                        </div>

                        <!--Anonymiser option redirection pour anonymiser-->
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-danger">Vous devez être connecté pour voir vos informations.</p>
    <?php endif; ?>
</div>

<?= view('footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>