<!DOCTYPE html>
<html lang = "lv">
<head>
<meta charset="UTF-8">
<meta name="author" content="Kārlis Puriņš">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product List</title>
</head>
<body>
    <button onclick = "goToAddProduct()">ADD</button>
    <h1>Product List</h1>
    <?php


        class Product{
            private $sku;
            private $name;
            private $price;

            function __construct($sku, $name, $price){
                $this->sku = $sku;
                $this->name = $name;
                $this->price = $price;
            }

            function getSKU(){
                return $this->sku;
            }

            function getName(){
                return $this->name;
            }

            function getPrice(){
                return $this->price;
            }

            function setSKU($givenSku){
                $this->sku = $givenSku;
            }

            function setName($givenName){
                $this->name = $givenName;
            }

            function setPrice($givenPrice){
                $this->price = $givenPrice;
            }

            function toString(){
                $returnText = strval($this->sku)."<br>";
                $returnText .= strval($this->name)."<br>";
                $returnText .= strval($this->price)."<br>";
                return $returnText;
            }

        }

        class Book extends Product{
            private $weight;

            function __construct($sku, $name, $price, $weight){
                $this->sku = $sku;
                $this->name = $name;
                $this->price = $price;
                $this->weight = $weight;
            }

            function getSKU(){
                return $this->sku;
            }

            function getWeight(){
                return $this->weight;
            }

            function setWeight($givenWeight){
                $this->weight = $givenWeight;
            }

            function toString(){
                $returnText = strval($this->sku)."<br>";
                $returnText .= strval($this->name)."<br>";
                $returnText .= strval($this->price)."$ <br>";
                $returnText .= strval($this->weight)." KG <br>";
                return $returnText;
            }
        }

        class Dvd extends Product{
            private $size;

            function __construct($sku, $name, $price, $size){
                $this->sku = $sku;
                $this->name = $name;
                $this->price = $price;
                $this->size = $size;
            }

            function getSKU(){
                return $this->sku;
            }

            function getSize(){
                return $this->size;
            }

            function setSize($givenSize){
                $this->size = $givenSize; 
            }

            function toString(){
                $returnText = strval($this->sku)."<br>";
                $returnText .= strval($this->name)."<br>";
                $returnText .= strval($this->price)."$ <br>";
                $returnText .= strval($this->size)." MB <br>";
                return $returnText;
            }
        }

        class Furniture extends Product{
            private $dimensions;

            function __construct($sku, $name, $price, $dimensions){
                $this->sku = $sku;
                $this->name = $name;
                $this->price = $price;
                $this->dimensions = $dimensions;
            }

            function getSKU(){
                return $this->sku;
            }

            function getDimensions(){
                return $this->dimensions;
            }

            function setDimensions($givenDimensions){
                $this->dimensions = $givenDimensions; 
            }

            function toString(){
                $returnText = strval($this->sku)."<br>";
                $returnText .= strval($this->name)."<br>";
                $returnText .= strval($this->price)."$ <br>";
                $returnText .= strval($this->dimensions[0])." cm x "
                .strval($this->dimensions[1])." cm x "
                .strval($this->dimensions[2])." cm <br>";
                return $returnText;
            }
        }

        require __DIR__ . '/database_connection.php';
        $productArray[] = array();
        $result = selectTableData(); //Gets table data
        if($result){
            foreach($result as $row){
                $index = $row['index'];
                $sku = $row['sku'];
                $name = $row['name'];
                $price = $row['price'];
                $height = $row['height'];
                $width = $row['width'];
                $length = $row['length'];
                $weight = $row['weight'];
                $size = $row['size'];
                
                //it is book
                if($weight > 0){
                    $obj = new Book($sku, $name, $price, $weight);
                    array_push($productArray, $obj);  
                }else if($size > 0){ //it is dvd
                    $obj = new Dvd($sku, $name, $price, $size);
                    array_push($productArray, $obj);
                }else { //it is furniture
                    $obj = new Furniture($sku, $name, $price, array($height, $width, $length));
                    array_push($productArray, $obj); 
                }
                
            }
        }else{
            echo "No Record Found";
        }

        showProducts($productArray);

        //Wraps data into squares
        function showProducts($array){
            ?>    
            <form id="product_view_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="submit" value="MASS DELETE" id="delete-product-btn" name ="submitBtn"><br><br>
            <?php
            for($i=1; $i<count($array); $i++) {
                ?>
                    <div class="square">
                    <input type="checkbox" name="deletingCheckbox[]" class = "delete-checkbox" value = "<?php echo $array[$i] -> getSKU()?>"><br>
                        <br>
                        <?php
                        echo $array[$i]->toString();
                        ?>
                    </div><br>
                    <?php
            }
                
            ?>
            </form>
            <?php
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['submitBtn'])){
                if(empty($_POST['deletingCheckbox'])){
                    echo "Nothing checked";
                }else{
                    $chkarr = $_POST['deletingCheckbox'];
                    deleteDataFromTable($chkarr);
                }
            }
        }
    ?>

    <script>
        function goToAddProduct(){
            window.location.href = "add-product.php";
        }
    </script>

<style>

        
        .square {
        height: 15%;
        width: 15%;
        background-color: grey;
        border-style: solid;
        border-width: 10px;
        border-color: black;
        text-align: center;
        padding-bottom: 10px;
        }

        .productRow{
        }
        
</style>

 
</body>
</html> 