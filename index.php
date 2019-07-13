<?php 

require('controller_form.php');


if (isset($_GET['action']))
{
    
 if ($_GET['action'] == 'formsite')
 {
    formulaire_site();
     
 }

}
    
else
{
    
    
    header('Location: view_homepage.php');
    
}
    
    
