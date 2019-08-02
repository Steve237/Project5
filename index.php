<?php 

require 'controller/controller.php';

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

elseif ($_GET['action'] == 'addComment') 
 {
if (isset($_GET['id']) && $_GET['id'] > 0) 
{
if (!empty($_POST['author']) && !empty($_POST['comment'])) 
{
addComment($_GET['id'], $_POST['author'], $_POST['comment']);
}

}
 
}
    
}
    
else
{
    
header('Location: ./view/view_homepage.php');
    
}
    