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

$query = "DELETE FROM Projet WHERE id_projet='$project_id'";
if (mysqli_query($conn, $query)) {
    header("Location: dashboard_chef_de_projet.php");
    exit();
} else {
    echo "Erreur : " . mysqli_error($conn);
}
?>
