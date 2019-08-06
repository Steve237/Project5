<?php 

// Definition du chemin absolu
define("ABSOLUTE_PATH", dirname(__FILE__));


require ABSOLUTE_PATH.'/controller/controller.php';

if (isset($_GET['action']))
{
    
if ($_GET['action'] == 'listposts') 
{
listPosts();

}
    
elseif ($_GET['action'] == 'post') 
{
if (isset($_GET['id']) && $_GET['id'] > 0) 
{
post();

} 
    
}
    
    
elseif ($_GET['action'] == 'sendmail')
{
    sendMail();
     
}


}
    
else
{
    
homePage();
    
}
    