<?php
include ("../includes/db.php");
$airports = $pdo->query("SELECT id, airportName, airportCode FROM airports ORDER BY airportName")->fetchAll(PDO::FETCH_ASSOC);
$aircrafts =$pdo->query("SELECT id, tailNumber, type FROM aircrafts ORDER BY tailNumber")->fetchAll(PDO::FETCH_ASSOC);
$crews = $pdo->query("SELECT id, name, surname, role FROM crews WHERE is_active = 1 ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flightNumber = $_POST["flightNumber"];
    $departureAirport = $_POST["departureAirport"];
    $arrivalAirport = $_POST["arrivalAirport"];
    $aircraft = $_POST["aircraft"];
    $departureDate = $_POST["departureDate"];
    $arrivalDate = $_POST["arrivalDate"];
    $crews = $_POST["crews"] ?? [];

    $errors = [];

    if(empty($flightNumber) || empty($departureAirport) || empty($arrivalAirport) || empty($captain) || empty($aircraft) || empty($arrivalDate)){
        $errors[] = "Tüm alanlar doldurulmalıdır.";
    }
    
    if(!preg_match("/^[A-Z0-9]{3,10}$/", $flightNumber)){
        $errors[] = "Uçuş numarası 3-10 karakter olmalı ve sadece büyük harf/rakam içermeli.";
    }

    if(strtotime($arrivalDate) <= strtotime($departureDate)){
        $errors[] = "Varış zamanı kalkıştan sonra olmalı.";
    }
    
    if($departureAirport === $arrivalAirport){
        $errors[] = "Kalkış ve varış havalimanı aynı olamaz.";
    }
    
    if(empty($errors)){
        $sql = "INSERT INTO flights (flightNumber, departureAirport, arrivalAirport, aircraft, departureDate, arrivalDate)
                VALUES (:flightNumber, :departureAirport, :arrivalAirport, :aircraft, :departureDate, :arrivalDate)";

        $stmt =$pdo->prepare($sql);

        $stmt->execute([
            ":flightNumber" => $flightNumber,
            ":departureAirport" => $departureAirport,
            ":arrivalAirport" => $arrivalAirport,
            ":aircraft" => $aircraft,
            ":departureDate" => $departureDate,
            ":arrivalDate" => $arrivalDate,
            ":crews" => $crews,
        ]);

        $flightId = $pdo->lastInsertId();

        if(!empty($crews)){
            $stmtCrew = $pdo->prepare("INSERT INTO flight_crews (flight_id, crew_id) VALUES (?,?)");
            foreach($crews as $crewId){
                $stmtCrew->execute([$flightId, $crewId]);
            }
        }

        echo "<p style='color:green;'>Uçuş başarıyla eklendi ✅</p>";
    } else{
        foreach($errors as $error){
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uçuş Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-8">
        <div class="card mt-3">
            <div class="card-body">
                <h2 class ="mb-3">Uçuş Ekle </h2>
                <form method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="flightNumber" class="form-label">Uçuş No</label>
                            <input type="text" class="form-control" id="flightNumber" name ="flightNumber" required pattern ="[A-Z0-9]{3,10}" title="3-10 karakter, sadece büyük harf ve rakam">
                        </div>
                        <div class="col-sm-6">
                            <label for="crews" class="form-label">Crew</label> 
                            <select id="crews" name="crews[]" class="form-select select2" multiple aria-label="Seçiniz" required>
                                <option value="">Seçiniz...</option>
                                <?php foreach($crews as $crew): ?>
                                <option value="<?= $crew['id'] ?>">
                                    <?= htmlspecialchars($crew['name'] . " " . $crew['surname'] . " (" . $crew['role'] . ")") ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="departureAirport" class="form-label">Kalkış Havalimanı</label> 
                            <select id="departureAirport" class="form-select" aria-label="Seçiniz"  name="departureAirport" required>
                                <option value="">Seçiniz...</option>
                                <?php foreach($airports as $airport): ?>
                                <option value="<?= $airport['id']?>">
                                    <?= htmlspecialchars($airport['airportCode'] . " - " . $airport['airportName'])?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="arrival" class="form-label">Varış Havalimanı</label> 
                            <select id="arrival" class="form-select" aria-label="Seçiniz"  name="arrivalAirport" required>
                                <option value="">Seçiniz...</option>
                                <?php foreach($airports as $airport): ?>
                                    <option value="<?= $airport['id']?>">
                                        <?= htmlspecialchars($airport['airportCode'] . " - " . $airport['airportName'])?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="aircraft" class="form-label">Uçak</label> 
                            <select id="aircraft" name="aircraft" class="form-select" aria-label="Seçiniz"  name="aircraft" required>
                                <option value="">Seçiniz...</option>
                                <?php foreach($aircrafts as $ac): ?>
                                    <option value="<?= $ac['id'] ?>">
                                        <?= htmlspecialchars($ac['tailNumber'] . " (" . $ac['type'] . ")") ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="aircraft" class="form-label">Kalkış Zaman</label> 
                            <input type="datetime-local" class="form-control" id="departureDate" name="departureDate" required>
                        </div>
                    
                        <div class="col-sm-4">
                            <label for="arrivalDate" class="form-label">Varış Zaman</label> 
                            <input type="datetime-local" class="form-control" id="arrivalDate" name="arrivalDate" required>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class ="btn btn-success">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>


<footer>
      <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script>


</footer>
</html>