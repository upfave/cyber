<?php
require_once '../includes/config.php';
require_once '../includes/header.php';
checkAuth();

// Récupérer les statistiques
$patients_count = $db->query("SELECT COUNT(*) FROM patient")->fetchColumn();
$consultations_count = $db->query("SELECT COUNT(*) FROM consultation WHERE idMedecin = {$_SESSION['medecin_id']}")->fetchColumn();
$ordonnances_count = $db->query("SELECT COUNT(*) FROM ordonnance WHERE idMedecin = {$_SESSION['medecin_id']}")->fetchColumn();

// Dernières consultations
$query = $db->prepare("
    SELECT c.idConsultation, c.date, p.nom, p.prenom 
    FROM consultation c
    JOIN patient p ON c.idPatient = p.idPatient
    WHERE c.idMedecin = :medecin_id
    ORDER BY c.date DESC
    LIMIT 5
");
$query->execute([':medecin_id' => $_SESSION['medecin_id']]);
$consultations = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header">
    <h1>Tableau de bord</h1>
    <div class="user-info">
        <span>Bienvenue, Dr. <?= $_SESSION['medecin_nom'] ?></span>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>Patients</h3>
                <p class="stat-number"><?= $patients_count ?></p>
                <a href="patients/liste.php" class="btn btn-primary">Voir tous</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>Consultations</h3>
                <p class="stat-number"><?= $consultations_count ?></p>
                <a href="consultations/liste.php" class="btn btn-primary">Voir toutes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>Ordonnances</h3>
                <p class="stat-number"><?= $ordonnances_count ?></p>
                <a href="ordonnances/liste.php" class="btn btn-primary">Voir toutes</a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Dernières consultations</h2>
        <a href="consultations/ajouter.php" class="btn btn-primary">Nouvelle consultation</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $consultation): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($consultation['date'])) ?></td>
                    <td><?= htmlspecialchars($consultation['prenom'] . ' ' . $consultation['nom']) ?></td>
                    <td>
                        <a href="consultations/details.php?id=<?= $consultation['idConsultation'] ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>