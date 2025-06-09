<?php
require_once '../../includes/config.php';
require_once '../../includes/header.php';
checkAuth();

if (!isset($_GET['id'])) {
    header('Location: liste.php');
    exit();
}

$patient_id = $_GET['id'];

// Récupérer les informations du patient
$query = $db->prepare("SELECT * FROM patient WHERE idPatient = ?");
$query->execute([$patient_id]);
$patient = $query->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header('Location: liste.php');
    exit();
}

// Récupérer les consultations du patient
$query = $db->prepare("
    SELECT c.idConsultation, c.date, m.nom as medecin_nom, m.specialite 
    FROM consultation c
    JOIN medecin m ON c.idMedecin = m.idMedecin
    WHERE c.idPatient = ?
    ORDER BY c.date DESC
");
$query->execute([$patient_id]);
$consultations = $query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les ordonnances du patient
$query = $db->prepare("
    SELECT o.idOrdonnance, o.date, m.nom as medecin_nom 
    FROM ordonnance o
    JOIN medecin m ON o.idMedecin = m.idMedecin
    WHERE o.idPatient = ?
    ORDER BY o.date DESC
");
$query->execute([$patient_id]);
$ordonnances = $query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les analyses du patient
$query = $db->prepare("
    SELECT r.idResultat, r.typeAnalyse, c.date as consultation_date
    FROM resultatanalyse r
    JOIN consultation c ON r.idConsultation = c.idConsultation
    WHERE c.idPatient = ?
    ORDER BY c.date DESC
");
$query->execute([$patient_id]);
$analyses = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header">
    <h1>Dossier patient: <?= htmlspecialchars($patient['prenom'] . ' ' . htmlspecialchars($patient['nom']) ?></h1>
    <a href="liste.php" class="btn btn-primary">Retour à la liste</a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h2>Informations patient</h2>
            </div>
            <div class="card-body">
                <p><strong>Nom:</strong> <?= htmlspecialchars($patient['nom']) ?></p>
                <p><strong>Prénom:</strong> <?= htmlspecialchars($patient['prenom']) ?></p>
                <p><strong>Date de naissance:</strong> <?= date('d/m/Y', strtotime($patient['dateNaissance'])) ?></p>
                <p><strong>Âge:</strong> <?= calculateAge($patient['dateNaissance']) ?> ans</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Consultations</h2>
        <a href="../consultations/ajouter.php?patient_id=<?= $patient_id ?>" class="btn btn-primary">Nouvelle consultation</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Médecin</th>
                    <th>Spécialité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultations as $consultation): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($consultation['date'])) ?></td>
                    <td>Dr. <?= htmlspecialchars($consultation['medecin_nom']) ?></td>
                    <td><?= htmlspecialchars($consultation['specialite']) ?></td>
                    <td>
                        <a href="../consultations/details.php?id=<?= $consultation['idConsultation'] ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Ordonnances</h2>
        <a href="../ordonnances/creer.php?patient_id=<?= $patient_id ?>" class="btn btn-primary">Nouvelle ordonnance</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Médecin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordonnances as $ordonnance): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($ordonnance['date'])) ?></td>
                    <td>Dr. <?= htmlspecialchars($ordonnance['medecin_nom']) ?></td>
                    <td>
                        <a href="../ordonnances/details.php?id=<?= $ordonnance['idOrdonnance'] ?>" class="btn btn-primary">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Analyses</h2>
        <a href="../analyses/ajouter.php?patient_id=<?= $patient_id ?>" class="btn btn-primary">Ajouter une analyse</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Type d'analyse</th>
                    <th>Date de consultation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($analyses as $analyse): ?>
                <tr>
                    <td><?= htmlspecialchars($analyse['typeAnalyse']) ?></td>
                    <td><?= date('d/m/Y', strtotime($analyse['consultation_date'])) ?></td>
                    <td>
                        <a href="../analyses/details.php?id=<?= $analyse['idResultat'] ?>" class="btn btn-primary">Voir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>