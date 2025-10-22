<?php
include ("../includes/db.php");
$stmt = $pdo->query("SELECT * FROM crews WHERE is_active = 1");
$crews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Mürettebat Listesi</title>
</head>
<body>
    <div class="container mt-3">

        <h2>Mürettebat Listesi <i class="fa-solid fa-people-group"></i></h2>
        <table class="table table-striped">
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
                            <a class="btn btn-warning" href="update.php?id=<?=$crew['id']?>">Güncelle</a>
                            <a class="btn btn-danger" href="delete.php?id=<?=$crew['id']?>" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        <div style ="text-align:right; margin-top:20px;">
            <a href="create.php" class="btn btn-success">Yeni Mürettebat Ekle</a>
        </div>
    </div>
</body>
</html>