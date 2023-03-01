<?php
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);

// Very simple PHP application describing basic usage of the Auth_SSO lib

include('common.php');

include('config/sso.php');

include('lib/Auth_SSO.php');
include('lib/Auth_SSO_Persistence_Session.php');

// ošetření výjimek
try
{
  // Konstruktor
 $auth = new Auth_SSO($ssoconfig);
}
catch(Exception $e)
{
  // zobraz chybu a ukonči běh skriptu
  die($e->getMessage());
}


// Sem se program dostane, jen pokud je uzivatel prihlasen.

// Pokud prihlaseny uzivatel nema roli access,
// umoznime mu prihlaseni pod jinym uctem
if(! $auth->has_role('access'))
{
  /* EXAMPLE $auth->reauth(); */
}

// Vynucene prihlaseni
// druha cast podminky je nezbytna, protoze presmerovani ze SSO Gateway je
// vcetne get parametru - dostali bychom se do smycky.
if(isset($_GET['reauth']) && !$auth->is_just_loged_in())
{
  $auth->reauth();
}

// Strip ?ticket=...
if($auth->is_just_loged_in())
{
      Header("Location: " .
             preg_replace('/[?].+$/', '', $_SERVER['REQUEST_URI']),
             true, 303);
}

html::head();

if(isset($_GET['page']))
{
  if($_GET['page'] == 'userinfo')
  {
    if($auth->has_role('ucitel'))
    {
       echo "<h1>JE UCITEL!</h1>";
    }

    echo "<p>Tato stránka ukazuje i využití persistence, informace o uživateli
          jsou trasparentně přes objekt \$auth načteny ze session.</p>";
    echo "<h3>Informace o uživateli</h3><p>Výpis \$auth->get_user_details()</p><pre>";
    print_r($auth->get_user_details());
    echo "</pre>";
  }
}
else
{
  echo "<p><b>Ověřen uživatel: {$auth->get_name()} ({$auth->get_login()})</b></p>";
  echo "<p><a href='?reauth=1'>Vynutit opětovné přihlášení</a></p>";
  echo "<p><a href='index.php'>Index</a></p>";
}

html::foot();

?>


