<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les utilisateurs</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="bg-light">

<?= view('navbar'); ?>

<div class="container mt-5">
    <h2 class="text-center">Consultez la liste des Utilisateurs inscrits :</h2>

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
                <th>Nom d'utilisateur</th>
                <th>Rôle</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= view('footer'); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Initialisation de DataTables -->
<script>
$(document).ready(function () {
    $('#usersTable').DataTable({
        "paging": true,  // Active la pagination
        "searching": true,  // Active la recherche
        "ordering": true,  // Active le tri
        "info": true,  // Affiche le nombre d'éléments
        "responsive": true  // Rend la table responsive sur mobile
    });
});
</script>

</body>
</html>