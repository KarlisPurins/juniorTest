<?php
    function selectTableData(){
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbName = "juniortest";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM products");
            $stmt->execute();
          
            //set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
            $conn = null;
    }


    function addDataToTable($sku, $name, $price, $height = NULL, $width = NULL, $length = NULL, $weight = NULL, $size = NULL){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbName = "juniortest";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO products (sku, name, price, height, width, length, weight, size) 
            VALUES ('$sku', '$name', '$price', '$height', '$width', '$length', '$weight', '$size')");
            $stmt->execute();
          
          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $conn = null;
          header("Location: index.php");
    }


    function deleteDataFromTable($indexArray = NULL){
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbName = "juniortest";

      $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      foreach ($indexArray as $sku){
        try {
          $stmt = $conn->prepare("DELETE FROM products WHERE sku = '$sku';");
          $stmt->execute();
        
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
      }
      header("Location: index.php");
        $conn = null;
  }
?>