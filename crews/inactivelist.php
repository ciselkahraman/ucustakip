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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>İnaktif Mürettebat Listesi</title>
</head>
<body>
    <h1>İnaktif Mürettebat Listesi</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>İsim</th>
            <th>Soyisim</th>
            <th>Görev</th>
            <th>İşlemler</th>
        </tr>

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
    </table>
    <div style ="text-align:left; margin-top:20px;">
            <a href = "read.php">Aktif Listeye Geri Dön</a>
    </div>
</body>
</html>