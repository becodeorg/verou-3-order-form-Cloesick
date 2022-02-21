<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions
session_start();

if (!empty($_POST)) {
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["street"] = $_POST["street"];
    $_SESSION["streetnumber"] = $_POST["streetnumber"];
    $_SESSION["city"] = $_POST["city"];
    $_SESSION["zipcode"] = $_POST["zipcode"];
}

function pre_r( $array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function whatIsHappening() {
    // echo '<h2>$_GET</h2>';
    // pre_r($_GET);
    // echo '<h2>$_POST</h2>';
    // pre_r($_POST);
    // echo '<h2>$_COOKIE</h2>';
    // pre_r($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    pre_r($_SESSION);
}

// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'IcedTea', 'price'=> 2, 'image'=>img],
    ['name' => 'ColaCoca', 'price'=> 2, 'image'=>img],
    ['name' => 'LemonJuice', 'price'=> 2, 'image'=>img],
    ['name' => 'StrawberryJuice', 'price'=> 2, 'image'=>img],
];

$totalValue = 0;

//byNicolas Add function in order to make the outputted line more readable
function orderderInfo( $products ){
    echo '<h3>Order Info:<h3></br/>';
        foreach($_POST["products"]as $key=>value){
            print($products[$key]["name"]."<br/>");
        }
}
$totalValue = 0;

// Use this function when you need to need an overview of these variables
function totalPrice($products) {
    echo "<h3>Total:</h3><br/>";
        foreach($_POST["products"]as $key =>$value){
            $price = ($products[$key]["price"]."<br/>);
            global $totalValue;
            $totalValue += (float)$price;
        }
        return "Total: $totalValue  <br/>";
}

//Variables and set to empty values.
$email=$street=$streetNumber=$city=$zipcode = "";
function validate(){
    // This function will send a list of invalid fields back $invalidFields=[];
    if(empty($_POST["email"])){
        array_push($invalidFields, "email");
    }
    if(empty($_POST["street"])){
        array_push($invalidFields, "street");
    }
    if(empty($_POST["streetNumber"])){
        array_push($invalidFields, "streetNumber");
    }
    if(empty($_POST["city"])){
        array_push($invalidFields, "city");
    }
    if(empty($_POST["zipcode"])){
        array_push($invalidFields, "zipcode");
    }
    if(empty($_POST["products"])){
        array_push($invalidFields, "products");
    }
// pre_r($imvalidFields);
// return the adjusted array including by all invalid fields
return $invalidFields;
 }

//determine value input
 function test_input($data){
     $data = trim($data);
     $data = striplashes($data);
     $data = htmlspecialchars($data);
     return $data;
 }

function handleForm($products)
{   
    // TODO: form related tasks (step 1)
    echo"<br/>"
    // Validation (step 2)
    $invalidFields = validate();

    $email=test_input($_pPOST["email"]);

    if (!empty($invalidFields)) {
        $message = 'div class="alert alert-danger text-center" role="alert">';
        foreach ($invalidFields as $field){
            if($field === "products"){
        $message .= "Please select at least one product! <br/>"
        // TODO: handle errors
    } else {
        $message .= "Please enter your $field <br/>";
    }
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $message .= "invalid email format";
}
$message .= '</div>';
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $message ='div class="alert alert-danger text-center" role="alert">
        imvalid email forrmat
            </div>';
}else{
// TODO: handle successful submission
$message="<div class='alert alert-info text-center' role='alert'>
    <h2>your order has been successfully received</h2>";
        foreach($_POST as $x => $field){
            // pre_r($_POST);
            // pre_r($x);
            //pre_r($field);
            if(is_array($field)){
                $message .= "<br><h4>Your order: </h4>">
                $message .= yourProducts ($products);
            }else{
                //setcookie($x, $field, time() + (60*60*60), "/");
                $message .= "Your $x: <i>$field</i> <br>";
            }
        }
        $message .= "</div>";
    }
    return $message;
}

function yourProducts($products){
    $orderProductList = '';
    foreach($_POST['products'] as $i){
        $orderedProductList .= "*" . $products[$i]['name'] ."<br>";
    }
    return $orderedProductList;
}

function calculateTotalPrice($products){
    $totoalPrice=0;
    if(!empty($_POST['products'])){
        foreach($_POST['products'] as $i) {
            $totalPrice += $products[$i]['price'];
        }
    }
    return $totalPrice;
}

// TODO: replace this if by an actual check
$formSubmitted = !empty($_POST);
if ($formSubmitted) {
   $message = handleForm($products);
}

require 'form-view.php';