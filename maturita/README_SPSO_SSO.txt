# Klientská PHP knihovna pro práci s autentizačním systémem SPŠ Ostrov (SSO)

PHP knihovna Auth_SSO umožňuje jednoduché napojení PHP aplikace na jednotný
systém autentizace v síti SPŠ Ostrov - SSO systém.

Upozornění: kód knihovny a ukázkové aplikace je velmi starý (2008), řada použitých
postupů a konstrukcí je zastaralá, nehodící je jako inspirace pro nové projekty.

Webová aplikace může využít ověřování uživatele síťovým jménem a heslem,
přičemž s heslem pracuje výhradně SSO Gateway a aplikace k němu vůbec nemá
přístup. Tento systém lze tedy využít i pro nedůvěryhodné aplikace, jejichž
kompromitace pak neohrozí nic dalšího.

## Konfigurace

Konfigurace je knihovně předávána jako asociativní pole, viz vzorový komentovaný
soubor config/sso.php

PRO SPRÁVNOU FUNKCI JE NUTNÉ JEŠTĚ PŘED PRVNÍM POUŽITÍM NASTAVIT PARAMETR:

  ['persistence-config']['path']

## Autorizační funkce

Pro jednodušší případy použití obsahuje Auth_SSO také základní podporu pro
autorizaci (oprávnění uživatelů a jejich skupin ke různým funkcionalitám)
ve formě systému rolí. Aplikace tyto funkce nemusí využívat.

V konfiguraci je definována možina rolí a způsob mapování uživatelů na role.
Každý uživatel může mít i několik rolí. Lze definovat přiřazení:
 - login > role
 - skupina > role
pro každou roli.

## Základní informace a způsob použití:

 - Pro začátek je vytvořená jednoduchá vzorová aplikace - soubory index.php a common.php.

 - Celá knihovna je obalena ve třídě Auth_SSO.

 - Konstruktoru se předává konfigurace a tento následně pracuje podle algoritmu:
    - Pokud je skript volán přesměrováním z SSO Gateway, ověří předaný ticket
      a pokud je platný, uloží získaná data do session.
    - Je-li definována třída pro persistenci a je platná session uživatele,
      načti data ze session.
    - Jinak - nepřihlášený uživatel - přesměruj na SSO Gateway.

   $auth = new Auth_SSO($config);

   (chybové stavy jsou ošetřeny výjimkou)

 - Pokud nedošlo k přesměrován na Gateway, můžeme na instanci Auth_SSO
   využít následující API:

   // login uživatele
   $auth->get_login()

   // plné jméno uživatele
   $auth->get_name()

   // podrobné informace
   // - členství ve skupinách: $res['group']
   // - e-mailové adresy: $res['mail']
   $auth->get_user_details()

   // vrací true, pokud má přihlášený uživatel přiřazenou danou roli
   $auth->has_role('some_role')

   // vrací true, pokud právě došlo k ověření přes SSO Gateway,
   $auth->is_just_loged_in()

   // vynucení opětovného přihlášení
   $auth->reauth()

## Poznámky:

Rozhodnete-li se použít dodanou třídu pro perzistenci přihlášení,
nemusíte sami v aplikaci inicializovat session (funkce session_start),
konstruktor Auth_SSO toto zajistí. Podle konfigurace navíc nastaví jméno
session a platnou URL pro cookie (toto nezapomeňte v konfiguraci upravit,
jde o zabezpečení proti krádeži session).
