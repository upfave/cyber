<?php
require_once '../../includes/config.php';
require_once '../../includes/header.php';
checkAuth();

// Récupérer la liste des patients
$query = $db->query("SELECT * FROM patient ORDER BY nom, prenom");
$patients = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header">
    <h1>Liste des patients</h1>
    <a href="ajouter.php" class="btn btn-primary">Ajouter un patient</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de naissance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= htmlspecialchars($patient['nom']) ?></td>
                    <td><?= htmlspecialchars($patient['prenom']) ?></td>
                    <td><?= date('d/m/Y', strtotime($patient['dateNaissance'])) ?></td>
                    <td>
                        <a href="dossier.php?id=<?= $patient['idPatient'] ?>" class="btn btn-primary">Dossier</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>