<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informations utilisateur</title>
    <link rel="stylesheet" href="<?= base_url('/public/assets/css/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?= view('navBar'); ?>

<div class="container mt-5 mb-5">
    <h1 class="section-heading">Mes Informations :</h1>

    <?php if (session()->has('idUtilisateur')): ?>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg p-4">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success text-center">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger text-center">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>


                    <form action="<?= base_url('userData') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <!-- Colonne gauche : photo -->
                            <div class="col-md-4 text-center border-end">
                                <label class="form-label">Photo de profil :</label>
                                <div class="d-flex flex-column align-items-center">
                                    <?php
                                        $photoExists = !empty($user['photo']) && file_exists(FCPATH . $user['photo']);
                                        $photoPath = $photoExists
                                            ? base_url($user['photo'])
                                            : base_url('uploads/users/defaut.png');
                                    ?>

                                    <img src="<?= $photoPath ?>" alt="Photo de profil" class="img-thumbnail mb-3" style="max-width: 250px; max-height: 250px;">

                                    <?php if ($photoExists): ?>
                                        <a href="<?= base_url('deleteUserPhoto') ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')">Supprimer la photo</a>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-4 w-100">
                                    <label for="photo" class="form-label">Changer la photo :</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                            </div>

                            <!-- Colonne droite : informations -->
                            <div class="col-md-8 ps-4">
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

                                <div class="mb-3">
                                    <label for="motDePasse" class="form-label">Nouveau mot de passe :</label>
                                    <input type="password" class="form-control" id="motDePasse" name="motDePasse">
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                </div>
                            </div>
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
</body>
</html>