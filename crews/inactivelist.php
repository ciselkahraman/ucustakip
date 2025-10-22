<?php
include ("../includes/db.php");
$stmt = $pdo->query("SELECT * FROM crews WHERE is_active = 0");
$crews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>İnaktif Mürettebat Listesi</title>
</head>
<body>
    <div class ="container mt-3">
        <h2>İnaktif Mürettebat Listesi</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>İsim</th>
                    <th>Soyisim</th>
                    <th>Görev</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($crews as $crew): ?>
                    <tr>
                        <td><?= htmlspecialchars($crew['id'])?></td>
                        <td><?= htmlspecialchars($crew['name'])?></td>
                        <td><?= htmlspecialchars($crew['surname'])?></td>
                        <td><?= htmlspecialchars($crew['role'])?></td>
                        <td>
                            <a class="btn btn-success btn-sm" href="restore.php?id=<?=$crew['id']?>">Geri Getir</a> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <div style ="text-align:right; margin-top:20px;">
            <a href = "read.php" class ="btn btn-primary">Aktif Listeye Geri Dön</a>
        </div>
    </div>
</body>
</html>