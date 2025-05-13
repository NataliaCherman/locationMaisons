//Initialisation de DataTables du fichier "allUsers"
$(document).ready(function () {
    $('#usersTable').DataTable({
        "paging": true,  // Active la pagination
        "searching": true,  // Active la recherche
        "ordering": true,  // Active le tri
        "info": true,  // Affiche le nombre d'éléments
        "responsive": true  // Rend la table responsive sur mobile
    });
});