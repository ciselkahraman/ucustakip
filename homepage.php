<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container fluid m-3">
            <a class="navbar-brand" href="homepage.php"> <i class="fa-solid fa-plane"></i> Uçuş Programı</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="flights/read.php">Uçuşlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="crews/read.php">Ekipler</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="row mt-4 m-4">
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Uçuş Listesi</h5>
                    <p class="card-text">Planlanmış tüm uçuşları görüntüleyin.</p>
                    <a href="flights/read.php" class="btn btn-primary">Git</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Uçuş Ekle</h5>
                    <p class="card-text">Yeni bir uçuş planı oluşturun.</p>
                    <a href="flights/create.php" class="btn btn-primary">Git</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body m-4">
                    <h5 class="card-title">Ekip Yönetimi</h5>
                    <p class="card-text">Uçuş ekibini ekleyin veya düzenleyin.</p>
                    <a href="crews/read.php" class="btn btn-primary">Git</a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>