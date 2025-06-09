<?php
require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
checkAuth();

if (!isset($_GET['patient_id'])) {
    header('Location: ../patients/liste.php');
    exit();
}

$patient_id = $_GET['patient_id'];

// Récupérer les informations du patient
$query = $db->prepare("SELECT * FROM patient WHERE idPatient = ?");
$query->execute([$patient_id]);
$patient = $query->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    header('Location: ../patients/liste.php');
    exit();
}

// Récupérer la liste des médicaments
$medicaments = $db->query("SELECT * FROM medicament ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Créer l'ordonnance
    $query = $db->prepare("INSERT INTO ordonnance (date, idMedecin, idPatient) VALUES (NOW(), ?, ?)");
    $query->execute([$_SESSION['medecin_id'], $patient_id]);
    $ordonnance_id = $db->lastInsertId();
    
    // Ajouter les médicaments
    foreach ($_POST['medicaments'] as $medicament) {
        if (!empty($medicament['id']) && !empty($medicament['quantite']) && !empty($medicament['duree'])) {
            $query = $db->prepare("INSERT INTO ordonnance_medicament (idOrdonnance, idMedicament, quantite, duree) VALUES (?, ?, ?, ?)");
            $query->execute([
                $ordonnance_id,
                $medicament['id'],
                $medicament['quantite'],
                $medicament['duree']
            ]);
        }
    }
    
    $_SESSION['success'] = "Ordonnance créée avec succès";
    header("Location: details.php?id=$ordonnance_id");
    exit();
}
?>

<div class="header">
    <h1>Nouvelle ordonnance pour <?= htmlspecialchars($patient['prenom'] . ' ' . htmlspecialchars($patient['nom'])) ?></h1>
    <a href="../patients/dossier.php?id=<?= $patient_id ?>" class="btn btn-primary">Retour au dossier</a>
</div>

<div class="card">
    <form method="POST">
        <div class="card-body">
            <div id="medicaments-container">
                <div class="medicament-item card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Médicament</label>
                                    <select name="medicaments[0][id]" class="form-control" required>
                                        <option value="">Sélectionner un médicament</option>
                                        <?php foreach ($medicaments as $medicament): ?>
                                        <option value="<?= $medicament['idMedicament'] ?>"><?= htmlspecialchars($medicament['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quantité</label>
                                    <input type="text" name="medicaments[0][quantite]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Durée</label>
                                    <input type="text" name="medicaments[0][duree]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-medicament" style="margin-top: 30px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="button" id="add-medicament" class="btn btn-secondary mb-3">
                <i class="fas fa-plus"></i> Ajouter un médicament
            </button>
            
            <div class="form-group">
                <button type="submit" class="btn btn-success">Enregistrer l'ordonnance</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let medicamentIndex = 1;
    
    // Ajouter un médicament
    document.getElementById('add-medicament').addEventListener('click', function() {
        const container = document.getElementById('medicaments-container');
        const newItem = document.createElement('div');
        newItem.className = 'medicament-item card mb-3';
        newItem.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Médicament</label>
                            <select name="medicaments[${medicamentIndex}][id]" class="form-control" required>
                                <option value="">Sélectionner un médicament</option>
                                <?php foreach ($medicaments as $medicament): ?>
                                <option value="<?= $medicament['idMedicament'] ?>"><?= htmlspecialchars($medicament['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Quantité</label>
                            <input type="text" name="medicaments[${medicamentIndex}][quantite]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Durée</label>
                            <input type="text" name="medicaments[${medicamentIndex}][duree]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-medicament" style="margin-top: 30px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        medicamentIndex++;
    });
    
    // Supprimer un médicament
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-medicament') || e.target.closest('.remove-medicament')) {
            const btn = e.target.classList.contains('remove-medicament') ? e.target : e.target.closest('.remove-medicament');
            const item = btn.closest('.medicament-item');
            item.remove();
        }
    });
});
</script>

<?php include '../../includes/footer.php'; ?>