<?php
session_start();
include('config.php');

// Rediriger si l'utilisateur n'est pas connecté ou s'il n'est pas un responsable d'équipe
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'responsable_equipe') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté
echo "UserID: $user_id"; // Debug: Affiche l'ID de l'utilisateur

// Récupération des informations de l'utilisateur
$query_user = "SELECT * FROM Utilisateur WHERE id_utilisateur = '$user_id'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);

// Récupération des projets gérés par le responsable d'équipe
$query_projects = "SELECT * FROM Projet WHERE id_responsable = '$user_id'";
$result_projects = mysqli_query($conn, $query_projects);
if (!$result_projects) {
    die('Erreur SQL Projet : ' . mysqli_error($conn));
}

// Récupération des tâches pour les projets gérés par le responsable d'équipe
$query_tasks = "SELECT t.* FROM Tache t JOIN Projet p ON t.id_projet = p.id_projet WHERE p.id_responsable = '$user_id'";
$result_tasks = mysqli_query($conn, $query_tasks);
if (!$result_tasks) {
    die('Erreur SQL Tâche : ' . mysqli_error($conn));
}

// Récupération des budgets pour les projets gérés par le responsable d'équipe
$query_budgets = "SELECT b.*, p.titre AS projet_titre FROM Budget b JOIN Projet p ON b.id_projet = p.id_projet WHERE p.id_responsable = '$user_id'";
$result_budgets = mysqli_query($conn, $query_budgets);
if (!$result_budgets) {
    die('Erreur SQL Budget : ' . mysqli_error($conn));
}
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
        <h2 class="text-center">Bonjour, <?php echo $user['prenom'] . ' ' . $user['nom']; ?></h2>

        <h3 class="mt-5">Vos Projets</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date de Début</th>
                    <th>Date Fin Prévue</th>
                    <th>Budget</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($project = mysqli_fetch_assoc($result_projects)): ?>
                    <tr>
                        <td><?php echo $project['titre']; ?></td>
                        <td><?php echo $project['description']; ?></td>
                        <td><?php echo $project['date_de_debut']; ?></td>
                        <td><?php echo $project['date_fin_prevu']; ?></td>
                        <td><?php echo $project['budget']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="mt-5">Vos Tâches</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = mysqli_fetch_assoc($result_tasks)): ?>
                    <tr>
                        <td><?php echo $task['titre']; ?></td>
                        <td><?php echo $task['description']; ?></td>
                        <td><?php echo $task['date_debut']; ?></td>
                        <td><?php echo $task['date_fin']; ?></td>
                        <td><?php echo $task['statut']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="mt-5">Budgets des Projets</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Projet</th>
                    <th>Montant</th>
                    <th>Date d'Allocation</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($budget = mysqli_fetch_assoc($result_budgets)): ?>
                    <tr>
                        <td><?php echo $budget['projet_titre']; ?></td>
                        <td><?php echo $budget['montant']; ?></td>
                        <td><?php echo $budget['date_allocation']; ?></td>
                        <td><?php echo $budget['etat']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
