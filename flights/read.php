<?php
include ("../includes/db.php");

//tarih kısmı
$startDate = isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : date('Y-m-d');

$days = [];
for ($i = 0 ; $i < 7 ; $i++){
    $days[] = date('Y-m-d', strtotime("$startDate +$i days"));
}

$startDateTime = $days[0] . ' 00:00:00';
$endDateTime = $days[6] . ' 23:59:59';

//crew verileri çekme
$crews = $pdo
->query("SELECT id, name, surname, role FROM crews WHERE is_active = 1 ORDER BY name")
->fetchAll(PDO::FETCH_ASSOC);

//flights verileri çekme
$sql = "SELECT f.*, a1.airportCode AS depCode, a2.airportCode AS arrCode
        FROM flights f
        JOIN airports a1 ON a1.id = f.departureAirport
        JOIN airports a2 ON a2.id = f.arrivalAirport
        WHERE f.departureDate BETWEEN :start AND :end
        ORDER BY f.departureDate";
$stmt= $pdo->prepare($sql);
$stmt->execute([
    ':start' => $startDateTime,
    ':end' => $endDateTime
]);
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);


//crewleri gruplama 
$crewFlights= [];
foreach($flights as $f){
    $day = date('Y-m-d', strtotime($f['departureDate']));
    $crewFlights[$f['captain']][$day][] = $f;
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <title>Uçuş Tablosu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="container mt-8">
    <div class="card">
  <div class="card-body">
<div class ="d-flex justify-content-between">
      <h2 class ="mb-3">Uçuş Tablosu <i class="fa-solid fa-plane"></i></h2>
    <form method ="get" class ="mb-3 d-flex gap-2">
        <label class ="col-form-label" >Başlangıç Tarihi: </label>
        <input type="date" name = "date" class ="form-control w-auto" value="<?= htmlspecialchars($startDate) ?>">
        <button type = "submit" class ="btn btn-primary">Göster</button>
    </form>
</div>
    <table class="table table-hover table-bordered align-middle">
    <thead>
      <tr>
        <th>Crews</th>
        <?php foreach ($days as $d): ?>
            <th><?= date('d M', strtotime($d)) ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    
    <tbody>
    <?php foreach ($crews as $c): ?> 
      <?php //uçuşu olanları listele
      $hasFlight = false;
      foreach ($days as $d){
        if(isset($crewFlights[$c['id']][$d])){
          $hasFlight = true;
          break;
        }
      }
      if(!$hasFlight) continue; //uçuşu olmayanı listeleme
      ?>

      <tr>
        <td><?= $c['name'] . " " . $c['surname'] . " " ."(" . $c['role'] . ")"?></td>
        <?php foreach($days as $d): ?>
          <td>
            <?php 
            if(isset($crewFlights[$c['id']][$d])){
              foreach($crewFlights[$c['id']][$d] as $f){
                echo $f['flightNumber'] . " ({$f['depCode']} → {$f['arrCode']})<br>";
              }
            }else{
              echo "-";
            }
            ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>
</div>
</body>
</div>
</div>
</html>
