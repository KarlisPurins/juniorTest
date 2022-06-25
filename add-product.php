<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Junior Test</title>
</head>
<body>
    <h1>Hello</h1><br><br>

    <form id="product_form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku"><br><br>
        <label for="name">Name</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="price">Price ($)</label>
        <input type="text" id="price" name="price"><br><br>
        
        <!-- switcher picker -->
        <label for="switcher">Type</label>
        <select id = "productType" onchange="switcherPick()" name="typeSwitcher">
            <option value="1">DVD</option>
            <option value="2">Furniture</option>
            <option value="3">Book</option>
        </select><br><br>
        
        
        <!-- furniture form -->
        <div id="furniture_form" style="display: none;">
        <label for="height">Height (CM)</label>
        <input type="text" id="height" name="height"><br><br>
        <label for="width">Width (CM)</label>
        <input type="text" id="width" name="width"><br><br>
        <label for="length">Length (CM)</label>
        <input type="text" id="length" name="length"><br>
        <p style="padding-left: 20px;">Please, provide dimensions</p>
        
        </div>

        <!-- book form -->
        <div id="book_form" style="display: none;">
        <label for="weight">Weight (KG)</label>
        <input type="text" id="weight" name="weight"><br>
        <p style="padding-left: 20px;">Please, provide weight</p>
        
        </div>

        <!-- dvd form -->
        <div id="dvd_form" style="display: block;">
        <label for="size">Size (MB)</label>
        <input type="text" id="size" name="size"><br>
        <p style="padding-left: 20px;">Please, provide size</p>
        
        </div>                             

        <input type="submit" value="Save"><br><br>


        

    </form>

    <button onclick = "clickCancel()">Cancel</button><br>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $sku = $_POST['sku'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $height = $_POST['height'];
            $width = $_POST['width'];
            $length = $_POST['length'];
            $weight = $_POST['weight'];
            $size = $_POST['size'];
            $chosenType = $_POST['typeSwitcher'];
            $skuNamePriceNotEmpty = true;
            $furnitureParamsNotEmpty = true;
            $bookParamsNotEmpty = true;
            $dvdParamsNotEmpty = true;
            if (empty($sku)) {
                $skuNamePriceNotEmpty = false;
            }
            if (empty($name)) {
                $skuNamePriceNotEmpty = false;
            }
            if (empty($price)) {
                $skuNamePriceNotEmpty = false;
            }
            if (empty($height)) {
                $furnitureParamsNotEmpty = false;
            }
            if (empty($width)) {
                $furnitureParamsNotEmpty = false;
            }
            if (empty($length)) {
                $furnitureParamsNotEmpty = false;
            }
            if (empty($weight)) {
                $bookParamsNotEmpty = false;
            }
            if (empty($size)) {
                $dvdParamsNotEmpty = false;
            }
            require __DIR__ . '/database_connection.php';
            
                switch($chosenType){
                    case 1:
                        //Checks if input fields are empty
                        if(isEmpty($skuNamePriceNotEmpty, $dvdParamsNotEmpty)){
                            echo "Please, submit required data";
                        //Checks if input fields are filled correctly
                        }else if(!floatval($price) || !floatval($size)){
                            echo "Please, provide the data of indicated type";
                        }else{
                            //writes input data to database
                            addDataToTable($sku, $name, $price, $height, $width, $length, $weight, $size);
                        }
                        break;
                    case 2:
                        if(isEmpty($skuNamePriceNotEmpty, $furnitureParamsNotEmpty)){
                            echo "Please, submit required data";
                        }else if(!floatval($price) || !floatval($height) || !floatval($width) || !floatval($length)){
                            echo "Please, provide the data of indicated type";
                        }
                        else{
                            addDataToTable($sku, $name, $price, $height, $width, $length, $weight, $size);
                        }
                        break;
                    case 3:
                        if(isEmpty($skuNamePriceNotEmpty, $bookParamsNotEmpty)){
                            echo "Please, submit required data";
                        }else if(!floatval($price) || !floatval($weight)){
                            echo "Please, provide the data of indicated type";
                        }
                        else{
                            addDataToTable($sku, $name, $price, $height, $width, $length, $weight, $size);
                        }
                        break;
                }
        }


        function isEmpty($skuNamePriceNotEmpty, $productSpecificParamsNotEmpty){
            if($skuNamePriceNotEmpty){
                if($productSpecificParamsNotEmpty){
                    return false;
                }else{
                    return true;
                } 
            }else{
                return true;
            }

        }
    ?>
    
    
    <script>

        function switcherPick(){
            var select = document.getElementById("productType");
            var value = select.options[select.selectedIndex].value;
            console.log(value);
            var dvd_form = document.getElementById("dvd_form");
            var book_form = document.getElementById("book_form");
            var furniture_form = document.getElementById("furniture_form");
            switch (value){
                case "1":
                dvd_form.style.display = "block";
                book_form.style.display = "none";
                furniture_form.style.display = "none";
                    break;
                case "2":
                dvd_form.style.display = "none";
                book_form.style.display = "none";
                furniture_form.style.display = "block";
                    break;
                case "3":
                dvd_form.style.display = "none";
                book_form.style.display = "block";
                furniture_form.style.display = "none";
                    break;
                    default:
                    console.log("sumtinWenWong");
                        break;
            }
            console.log(value);
        }
        

        function clickCancel(){
            window.location.href = "index.php";
        }
    </script>
</body>
</html> 