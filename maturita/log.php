<?php
class Log{
public static function loginSSO(){
session_start();
include('config/sso.php');
include('lib/Auth_SSO.php');
include('lib/Auth_SSO_Persistence_Session.php');
self::connectDB();    
$auth = new Auth_SSO($ssoconfig);  
 $login = $auth->get_login();   
 $celeJmeno = explode(" ",$auth->get_name());
   $jmeno = $celeJmeno[0];  
 $prijmeni = $celeJmeno[1];  
 $detailPole = $auth->get_user_details(); 
   //rozdělení stringu na obor, vypocet rocniku a skupinu  
  $info = $detailPole["ou_simple"][0];   
 $split = str_split($info);  
 //obor     
$obor;  
 $oborPismenko = $split[3]; 
  $oborVyber = Db::queryAll("SELECT Obor FROM Obor Where Obor LIKE '$oborPismenko%'");  
  foreach($oborVyber as $row) {   
  $obor = $row['Obor'];   
   echo $obor;  
 }    
//vypocet rocniku   
 $rocnik;   
//potřebné datumy pro výpočet    
$today = date("m.y");   
 $year = date("y");  
  $rokNastupu = $split[1].$split[2]; 
   $zacatekRocnikuStary = date("m.y", mktime(0, 0, 0, 7, 1, date("y")-1)); 
   $konecRoku = date("m.y", mktime(0, 0, 0, 1, 0, date("y")));  
  //podmínky   
 /*    $delkaStudia; 
  $query = Db::queryAll("SELECT Delka_studia FROM Obor Where Obor = '$obor'");
   foreach($query as $row){   
  $delkaStudia = $row["Delka_studia"];   
      }   
if($today >= $zacatekRocnikuStary && $today <= $konecRoku){ 
    if($year - $rokNastupu + 1 >= $delkaStudia) 
      $rocnik = $delkaStudia;     
 else       
  $rocnik = $year - $rokNastupu +1;  
  }   
 else{    
 if($rocnik = $year - $rokNastupu >= $delkaStudia)
       $rocnik = $delkaStudia;  
   else      
  $rocnik = $year - $rokNastupu;  
  }   
*/    
//skupina   
 $skupinaPismenko = $split[0];  
 //user/admin     $userAdmin = ""; 
   $userAdminSelect = Db::queryAll("SELECT * FROM Users WHERE Login = '$login' && user_admin = 'admin'"); 
  foreach($userAdminSelect as $admin){  
    $userAdmin = $admin["user_admin"]; 
  }      
 //generování universálního kódu po přihlášení     $universalCode = md5(rand());
   //informace o uživateli předávané na indexUser.php  
  $_SESSION["login"] = $login;  
  $_SESSION["jmeno"] = $jmeno; 
  $_SESSION["prijmeni"] = $prijmeni; 
  $_SESSION["prava"] = $detailPole["group"][0];  
  $_SESSION["obor"] = $obor;   
 //$_SESSION["rocnik"] = $rocnik;  
  $_SESSION["skupina"] = $skupinaPismenko;  
  $_SESSION["universalCode"] = $universalCode;
   $result = Db::queryAll("SELECT Login FROM Users WHERE Jmeno = '$jmeno' & Prijmeni = '$prijmeni' & Login = '$login'"); 
   $resultLogin;  
  foreach($result as $loginItem){
      $resultLogin = $loginItem["Login"]; 
   }    
//podmínky přihlášení    
//pokud uživatel existuje, přihlaš ho   
 if($resultLogin == $_SESSION["login"]){ 
    if($userAdmin == "admin"){    
   header("location: admin.php?code=$universalCode");   
  }    
  else{    
    header("location: indexUser.php?user=$login&code=$universalCode"); 
     }         
  }   
 //pokud uživatel neexistuje, ať zadá email    
 else{     
 header("location: indexUser.php?email");   
       } 
}
}
?>