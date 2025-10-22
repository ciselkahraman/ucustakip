<?php 
include("../includes/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $role = trim($_POST['role'] ?? '');

    $errors = [];

    if($name === ''){
        $errors[] = 'İsim boş olamaz.';
    }
    if($surname === ''){
        $errors[] =  'Soyisim boş olamaz.';
    }
    $validRoles = ['Captain', 'First Officer', 'Purser', 'Flight Attendant'];
    if(!in_array($role,$validRoles)){
        $errors[] = 'Geçersiz rol seçimi';
    }
    if (empty($errors)){
    $sql = "INSERT INTO crews (name, surname, role)
            VALUES (:name, :surname, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute([
        ":name" => $name,
        ":surname" => $surname,
        ":role" => $role

    ]);
    echo "<p style = 'color: green;'>Crew başarıyla eklendi ✅</p>";
    } else {
        foreach($errors as $err){
            echo "<p style='color:red' >$err</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Yeni Crew Ekle</title>
</head>
<body>
    <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h2 class="mb-4 text-center">Yeni Crew Ekle</h2>
            
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">İsim</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="surname" class="form-label">Soyisim</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select id="role" class="form-select" name="role" required>
                        <option value="">Seçiniz...</option>
                        <option value="Captain">Captain</option>
                        <option value="First Officer">First Officer</option>
                        <option value="Purser">Purser</option>
                        <option value="Flight Attendant">Flight Attendant</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

    
</body>
</html>
