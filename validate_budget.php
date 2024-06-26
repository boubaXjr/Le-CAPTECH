<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'responsable_equipe') {
    header("Location: login.php");
    exit();
}

$budget_id = $_GET['id'];

$query = "UPDATE Budget SET etat='Validé' WHERE id_budget='$budget_id'";
mysqli_query($conn, $query);

header("Location: dashboard_responsable_equipe.php");
exit();
?>
