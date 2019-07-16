<?php

session_start();

require 'model_form.php';

function formulaire_site()
{

$errors = [];


$validator = new validator_site($_POST);
$validator->check('name', 'required');
$validator->check('email', 'required');
$validator->check('email', 'email');
$validator->check('message', 'required');
$validator->check('name', is_string('name'));
$errors = $validator->errors();


if(!empty($errors))
{
    
    $_SESSION['errors'] = $errors;
    $_SESSION['input'] = $_POST;
    
    
    header('Location: view_homepage.php#contact');  
}

else
{
$_SESSION['success'] = 1;

$message = $_POST['message'];

$headers = 'FROM: adouessono@yahoo.fr';

mail('essonoadou@gmail.com', 'Formulaire de contact', $message, $headers);    
  
header('Location: view_homepage.php#contact'); 

}
}    