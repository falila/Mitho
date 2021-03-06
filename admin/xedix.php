<?php 
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE);

ini_set('error_reporting', E_ALL);
/**

    Ce fichier permet de r�cup�rer des �lements XML depuis la base de donn�es XEDIX ROXOR du Poney.
    En foonction du contenu de la variable id de type GET on redirige vers la m�thode � appliquer. 

*/


/**

M�thode qui r�cup�re tous les utilisateurs
renvoit un arbre XML contenant tous les utilisateurs. 

*/
function getAllUsers(){
    header("Content-Type:text/xml");
    //echo file_get_contents("http://82.234.92.81:5225/cgi-bin/client?X2xsearch+7+login=Robin&pwd=854895+search="(id,titre,auteur,dateDerniereModif,etat,refSmf)<DANS>Conte"&display=XML); //on inteprete cot� client l'�cho comme un retour normal. 
    echo file_get_contents("http://localhost/Mitho/admin/personne.xml");
}


/**

M�thode qui r�cup�re tous les �lements publi�s
renvoit un arbre XML contenant tous les contenus publi�s. 

*/
function getAllPublished(){
    // C'est peut �tre compl�tement faux mais j'essaie
    header("Content-Type:text/xml");
    //echo file_get_contents("http://82.234.92.81:5225/cgi-bin/client?X2xsearch+7+login=Robin&pwd=854895+search="(id,titre,auteur,dateDerniereModif,etat,refSmf)<DANS>Conte"&display=XML); //on inteprete cot� client l'�cho comme un retour normal. 
    echo file_get_contents("http://localhost/Mitho/admin/contes.xml");
    //echo file_get_contents("http://82.234.92.81:5225/cgi-bin/client?X2XSearch+7+".$_SESSION['idSession']."+allrequest=");
    // Je veux r�cup�rer l'id l'auteur...
}
/**
    Recup�re un conte en particulier. En prenant l'id pass� en param $_GET['id']
*/
function getPublishedContent(){
    header("Content-Type:text/xml");
    echo file_get_contents("http://localhost/Mitho/admin/contes.xml");

}


/**
    M�thode d'authentification qui set l'id de session
*/
function auth(){
    $mdp = "";
    $login = "";

    if( !empty( $_GET['login'] ) ){  
 
        $login = $_GET['login'];
 
    } 

    if( !empty( $_GET['mdp'] ) ){  
 
        $mdp = $_GET['mdp'];
 
    } 

    header("Content-Type:text/xml");
    //echo "http://82.234.92.81:5225/cgi-bin/client?X2Admin+13++login=".$login."&pwd=".$mdp."<BR>";
    $return = file_get_contents("http://82.234.92.81:5225/cgi-bin/client?X2Admin+13++login=".$login."&pwd=".$mdp);
    //echo $return;
    $dom = new DomDocument();
    $dom->loadXML($return);
    $erreur = $dom->getElementsByTagName('erreur');
    foreach($erreur as $e){
        $result = $e->nodeValue;
    }

    if(sizeof($result) > 0){
        
        echo "<erreur>".$result."</erreur>";
    }else {
        
        echo $return;
        $session = $dom->getElementsByTagName('clefsession');
        foreach($session as $i){
            $idSession = $i->nodeValue;
        }
        
       // echo $idSession;

        $_SESSION['idSession'] = $idSession;
        $_SESSION['login'] = $login;


        //echo $_SESSION['idSession'];
        
    }
    


}


if(!isset($_GET['id'])){
    echo "stop";
}else {
    switch ($_GET['id']) {
        case 1:
            echo auth();
            break;
        case 2:
            echo getAllPublished();
            break;
        case 3:
            echo getAllUsers();
            break;
        case 4:
            echo getPublishedContent();
            break;    

        /*case 3:
            echo autre();
            break; etc ....*/ 
    }



    
}





?> 