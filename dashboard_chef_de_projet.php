<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'chef_de_projet') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM Utilisateur WHERE id_utilisateur='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$query_projects = "SELECT * FROM Projet WHERE id_utilisateur='$user_id' OR id_projet IN (SELECT id_projet FROM Equipe WHERE id_equipe IN (SELECT id_equipe FROM Membre WHERE id_utilisateur='$user_id'))";
$result_projects = mysqli_query($conn, $query_projects);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Chef de Projet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">CAPTECH</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">Bonjour, <?php echo $user['prenom']; ?> <?php echo $user['nom']; ?></h2>
        
        <!-- Notifications Section -->
        <div id="notifications" class="mb-4">
            <h3>Notifications</h3>
            <div class="list-group">
                <!-- Notifications would be dynamically loaded here -->
                <a href="#" class="list-group-item list-group-item-action">Notification 1</a>
                <a href="#" class="list-group-item list-group-item-action">Notification 2</a>
                <a href="#" class="list-group-item list-group-item-action">Notification 3</a>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="mb-4">
            <input type="text" id="search" class="form-control" placeholder="Rechercher des projets...">
        </div>

        <h3 class="mt-5">Vos Projets</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Budget</th>
                    <th>Membres</th>
                    <th>Tâches</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="projectTable">
                <?php while ($project = mysqli_fetch_assoc($result_projects)): ?>
                    <?php
                        $project_id = $project['id_projet'];
                        $query_members = "SELECT U.nom, U.prenom FROM Utilisateur U JOIN Membre M ON U.id_utilisateur = M.id_utilisateur WHERE M.id_equipe IN (SELECT id_equipe FROM Equipe WHERE id_projet='$project_id')";
                        $result_members = mysqli_query($conn, $query_members);
                        
                        $query_tasks = "SELECT titre, statut FROM Tache WHERE id_projet='$project_id'";
                        $result_tasks = mysqli_query($conn, $query_tasks);
                    ?>
                    <tr>
                        <td><?php echo $project['titre']; ?></td>
                        <td><?php echo $project['description']; ?></td>
                        <td><?php echo $project['date_de_debut']; ?></td>
                        <td><?php echo $project['date_fin_prevu']; ?></td>
                        <td><?php echo $project['budget']; ?></td>
                        <td>
                            <ul>
                                <?php while ($member = mysqli_fetch_assoc($result_members)): ?>
                                    <li><?php echo $member['prenom'] . ' ' . $member['nom']; ?></li>
                                <?php endwhile; ?>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <?php while ($task = mysqli_fetch_assoc($result_tasks)): ?>
                                    <li><?php echo $task['titre'] . ' (' . $task['statut'] . ')'; ?></li>
                                <?php endwhile; ?>
                            </ul>
                        </td>
                        <td>
                            <a href="project.php?id=<?php echo $project['id_projet']; ?>" class="btn btn-primary">Voir</a>
                            <a href="edit_project.php?id=<?php echo $project['id_projet']; ?>" class="btn btn-warning">Modifier</a>
                            <a href="delete_project.php?id=<?php echo $project['id_projet']; ?>" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <a href="create_project.php" class="btn btn-success">Créer un Nouveau Projet</a>

        <!-- Chart Section -->
        <div class="mt-5">
            <h3>Statistiques des Projets</h3>
            <canvas id="projectChart"></canvas>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Search functionality
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#projectTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Chart.js functionality
            var ctx = document.getElementById('projectChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Projet A', 'Projet B', 'Projet C'], // Replace with dynamic data
                    datasets: [{
                        label: 'Budget',
                        data: [10000, 15000, 20000], // Replace with dynamic data
                        backgroundColor: ['#007bff', '#28a745', '#dc3545'],
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
