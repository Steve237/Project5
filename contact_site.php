<?php

require 'include_form.php';

$errors = [];


$validator = new validator_site($_POST);
$validator->check('name', 'required');
$validator->check('email', 'required');
$validator->check('email', 'email');
$validator->check('message', 'required');
$errors = $validator->errors();


if(!empty($errors))
{
    
    $_SESSION['errors'] = $errors;
    $_SESSION['input'] = $_POST;
    
    
    header('Location: index1.php');  
}

else
{
$_SESSION['success'] = 1;

$message = $_POST['message'];

$headers = 'FROM: adouessono@yahoo.fr';

mail('essonoadou@gmail.com', 'Formulaire de contact', $message, $headers);    
    
}