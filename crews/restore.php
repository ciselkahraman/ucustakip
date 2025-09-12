<?php
include("../includes/db.php");

if (isset($_GET['id'])){
    $id = $_GET['id'];

    try{
        $sql = "UPDATE crews SET is_active = 1 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("Location: inactive.php?msg=restored");
            exit;
        } else{
            echo "Aktifleştirme işlemi başarısız oldu. ";
        }    
    } catch(PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "ID bulunamadı.";
}

?>

