<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'developpeur') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM Utilisateur WHERE id_utilisateur='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$query_teams = "SELECT e.nom, p.titre FROM Equipe e 
                JOIN Projet p ON e.id_projet = p.id_projet 
                JOIN Membre m ON e.id_equipe = m.id_equipe 
                WHERE m.id_utilisateur='$user_id'";
$result_teams = mysqli_query($conn, $query_teams);

$query_tasks = "SELECT * FROM Tache WHERE id_utilisateur='$user_id'";
$result_tasks = mysqli_query($conn, $query_tasks);

$query_documents = "SELECT d.nom, d.chemin_acces, p.titre FROM Document d 
                    JOIN Document_Projet dp ON d.id_document = dp.id_document 
                    JOIN Projet p ON dp.id_projet = p.id_projet 
                    JOIN Equipe e ON p.id_projet = e.id_projet 
                    JOIN Membre m ON e.id_equipe = m.id_equipe 
                    WHERE m.id_utilisateur='$user_id'";
$result_documents = mysqli_query($conn, $query_documents);
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
        
        <h3 class="mt-5">Vos Équipes</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom de l'Équipe</th>
                    <th>Projet Associé</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($team = mysqli_fetch_assoc($result_teams)): ?>
                    <tr>
                        <td><?php echo $team['nom']; ?></td>
                        <td><?php echo $team['titre']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="mt-5">Documents de Projet</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom du Document</th>
                    <th>Chemin d'Accès</th>
                    <th>Projet Associé</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($document = mysqli_fetch_assoc($result_documents)): ?>
                    <tr>
                        <td><?php echo $document['nom']; ?></td>
                        <td><a href="<?php echo $document['chemin_acces']; ?>" target="_blank">Ouvrir</a></td>
                        <td><?php echo $document['titre']; ?></td>
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
                    <th>Commentaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = mysqli_fetch_assoc($result_tasks)): ?>
                    <tr>
                        <td><?php echo $task['titre']; ?></td>
                        <td><?php echo $task['description']; ?></td>
                        <td><?php echo $task['date_debut']; ?></td>
                        <td><?php echo $task['date_fin']; ?></td>
                        <td>
                            <form action="update_task_status.php" method="POST">
                                <input type="hidden" name="id_tache" value="<?php echo $task['id_tache']; ?>">
                                <select name="statut" onchange="this.form.submit()">
                                    <option value="Non commencé" <?php if ($task['statut'] == 'Non commencé') echo 'selected'; ?>>Non commencé</option>
                                    <option value="En cours" <?php if ($task['statut'] == 'En cours') echo 'selected'; ?>>En cours</option>
                                    <option value="Terminé" <?php if ($task['statut'] == 'Terminé') echo 'selected'; ?>>Terminé</option>
                                </select>
                            </form>
                        </td>
                        <td><a href="comment_task.php?id=<?php echo $task['id_tache']; ?>" class="btn btn-primary">Commenter</a></td>
                        <td>
                            <a href="task.php?id=<?php echo $task['id_tache']; ?>" class="btn btn-primary">Voir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="mt-5">Progression des Tâches</h3>
        <canvas id="taskProgressChart"></canvas>
    </div>

    <script>
        $(document).ready(function() {
            var ctx = document.getElementById('taskProgressChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Non commencé', 'En cours', 'Terminé'],
                    datasets: [{
                        label: 'Progression des Tâches',
                        data: [
                            <?php
                            $count_non_commence = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Tache WHERE id_utilisateur='$user_id' AND statut='Non commencé'"))['count'];
                            $count_en_cours = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Tache WHERE id_utilisateur='$user_id' AND statut='En cours'"))['count'];
                            $count_termine = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Tache WHERE id_utilisateur='$user_id' AND statut='Terminé'"))['count'];
                            echo "$count_non_commence, $count_en_cours, $count_termine";
                            ?>
                        ],
                        backgroundColor: ['#dc3545', '#ffc107', '#28a745']
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
</body>
</html>
