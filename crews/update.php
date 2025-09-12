<?php
include("../includes/db.php");

if (!isset($_GET['id'])){
    echo "ID bulunamadı.";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $role = $_POST['role'];

    try{
        $sql = "UPDATE crews SET name = :name, surname = :surname, role= :role WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("Location: read.php?msg=updated");
            exit;
        } else{
            echo "Güncelleme başarısız oldu.";
        }
    } catch(PDOException $e){
        echo "Hata: " . $e->getMessage();
    }
}

try {
    $sql = "SELECT * FROM crews WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $crew = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$crew){
        echo "Kayıt bulunamadı.";
        exit;
    }
} catch (PDOException $e ) {
    echo "Hata: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Güncelleme</title>
</head>
<body>
    <h2>Crew Güncelleme</h2>

    <form method="POST">
        <label>Ad: </label>
        <input type="text" name="name" value="<?=htmlspecialchars($crew['name'])?>"required></label><br><br>

        <label>Soyad: </label>
        <input type="text" name="surname" value="<?=htmlspecialchars($crew['surname'])?>"required></label><br><br>

        <label>Rol: </label>
        <select name="role" required>
            <option value="">Seçiniz...</option>
            <option value="Captain" <?= ($crew['role'] == 'Captain') ? 'selected': ''?>>Captain</option>
            <option value="First Officer" <?= ($crew['role'] == 'First Officer') ? 'selected': ''?>>First Officer</option>
            <option value="Purser" <?= ($crew['role'] == 'Purser') ? 'selected': ''?>>Purser</option>
            <option value="Flight Attendant" <?= ($crew['role'] == 'Flight Attendant') ? 'selected': ''?>>Flight Attendant</option>
        </select><br><br>

        <button type ="submit">Kaydet</button>
    </form>
</body>
</html>
