<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les utilisateurs</title>
    <link rel="stylesheet" href="<?= base_url('/public/assets/css/style.css') ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
     
    <script src="<?= base_url('/public/assets/js/script.js') ?>"></script>
</head>
<body class="bg-light">

<?= view('navbar'); ?>

<div class="container mt-5">
    <h1 class="section-heading">Consultez la liste des Utilisateurs inscrits :</h1>

     <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table id="usersTable" class="table table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>Photo de profil</th>
                <th>Nom d'utilisateur</th>
                <th>Rôle</th>
                <th>Modifier</th>
                <th>Anonymiser</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php if (!empty($user['photo'])): ?>
                            <img src="<?= base_url($user['photo']) ?>" alt="Photo de profil" width="100">
                        <?php else: ?>
                            <img src="<?= base_url('uploads/users/defaut.png') ?>" alt="Photo par défaut" width="100">
                        <?php endif; ?>
                    </td>
                    <td><?= esc($user['nom']) . ' ' . esc($user['prenom']) ?></td>
                    <td><?= esc($user['role']) ?></td>
                    <td>
                        <form action="<?= base_url('update_role') ?>" method="post" class="d-flex justify-content-center">
                            <input type="hidden" name="idUtilisateur" value="<?= esc($user['idUtilisateur']) ?>">
                            <select name="role" class="form-select w-auto">
                                <option value="Utilisateur" <?= $user['role'] === 'Utilisateur' ? 'selected' : '' ?>>Utilisateur</option>
                                <option value="Administrateur" <?= $user['role'] === 'Administrateur' ? 'selected' : '' ?>>Administrateur</option>
                            </select>
                            <button type="submit" class="btn btn-primary ms-2">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form action="<?= base_url('allUsers') ?>" method="post">
                            <input type="hidden" name="idUtilisateur" value="<?= esc($user['idUtilisateur']) ?>">
                            <button type="submit" class="btn btn-warning">Anonymiser</button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex flex-column align-items-center gap-2">
                            <!-- Statut de l'utilisateur -->
                            <span class="badge <?= $user['status'] === 'bloqué' ? 'bg-danger' : 'bg-success' ?>">
                                <?= ucfirst(esc($user['status'])) ?>
                            </span>

                            <!-- Boutons d'action -->
                            <div class="d-flex gap-2">
                                <?php if ($user['status'] === 'bloqué'): ?>
                                    <form action="<?= base_url('debloquer_utilisateur') ?>" method="post">
                                        <input type="hidden" name="idUtilisateur" value="<?= esc($user['idUtilisateur']) ?>">
                                        <button type="submit" class="btn btn-sm btn-success">Débloquer</button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?= base_url('bloquer_utilisateur') ?>" method="post">
                                        <input type="hidden" name="idUtilisateur" value="<?= esc($user['idUtilisateur']) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Bloquer</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= view('footer'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>