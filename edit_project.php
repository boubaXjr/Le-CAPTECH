<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'chef_de_projet') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de projet non défini ou invalide.";
    exit();
}

$project_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_de_debut = $_POST['date_de_debut'];
    $date_fin_prevu = $_POST['date_fin_prevu'];
    $budget = $_POST['budget'];

    $query = "UPDATE Projet SET titre='$titre', description='$description', date_de_debut='$date_de_debut', date_fin_prevu='$date_fin_prevu', budget='$budget' WHERE id_projet='$project_id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard_chef_de_projet.php");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

$query = "SELECT * FROM Projet WHERE id_projet='$project_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Erreur de requête : " . mysqli_error($conn);
    exit();
}

$project = mysqli_fetch_assoc($result);

if (!$project) {
    echo "Projet non trouvé.";
    exit();
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
        <a class="navbar-brand" href="#">CAPTECH</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
                                <li class="nav-item"><a class="nav-link" href="dashboard_chef_de_projet.php">Retour</a></li>

            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">Modifier le Projet</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?php echo $project['titre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $project['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_de_debut">Date de Début</label>
                <input type="date" class="form-control" id="date_de_debut" name="date_de_debut" value="<?php echo $project['date_de_debut']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date_fin_prevu">Date de Fin Prévue</label>
                <input type="date" class="form-control" id="date_fin_prevu" name="date_fin_prevu" value="<?php echo $project['date_fin_prevu']; ?>" required>
            </div>
            <div class="form-group">
                <label for="budget">Budget</label>
                <input type="number" step="0.01" class="form-control" id="budget" name="budget" value="<?php echo $project['budget']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Modifier</button>
        </form>
    </div>
</body>
</html>
