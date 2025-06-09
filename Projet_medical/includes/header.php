<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme Médicale - Médecin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-heartbeat"></i>
                <span>MediCare</span>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.php"><i class="fas fa-home"></i> Tableau de bord</a></li>
                    <li><a href="../patients/liste.php"><i class="fas fa-user-injured"></i> Patients</a></li>
                    <li><a href="../consultations/liste.php"><i class="fas fa-notes-medical"></i> Consultations</a></li>
                    <li><a href="../ordonnances/liste.php"><i class="fas fa-prescription"></i> Ordonnances</a></li>
                    <li><a href="../analyses/liste.php"><i class="fas fa-microscope"></i> Analyses</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="../login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </div>
        <div class="main-content">