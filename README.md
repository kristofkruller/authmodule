# Telepítési útmutató
Ez a dokumentáció segít beállítani és futtatni a projektet egy helyi fejlesztési környezetben. Kérjük, kövesse az alábbi lépéseket.

## Git repo lehúzása 
git clone [https://github.com/kristofkruller/authmodule.git]
composer install

## Composer Telepítése
Telepítsd a Composert, amely szükséges a harmadik féltől származó könyvtárak kezeléséhez:
Composer Letöltése: [https://getcomposer.org/download/]

## XAMPP Telepítése
Töltsd le és telepítsd a XAMPP-ot az alábbi hivatalos oldalról: [https://www.apachefriends.org/hu/index.html]

## Portok Beállítása
Állítsd be a következő portokat a XAMPP-ban:

- HTTP: 9113
- SSL: 9114
- Adatbázis: 9115
Ezt megteheted az XAMPP vezérlőpultján keresztül, és frissítened kell a kapcsolódó konfigurációs fájlokat (`httpd.conf`, `httpd-ssl.conf`, `my.ini`).

## phpMyAdmin Konfiguráció
Cseréld le a XAMPP/phpMyAdmin `config.inc.php` fájlt a `setup/config.inc.php` fájllal.

## MailerSend Integráció
Integráld a MailerSend szolgáltatást az általad választott e-mail domainnel (teszthez ajánlott: `mail.com`). A MailerSend segítségével e-maileket küldhetsz a PHP alkalmazásából.
Kövesd a MailerSend PHP SDK telepítési útmutatóját: [https://developers.mailersend.com/guides/sdk/sending-emails-with-mailersend-and-php.html#prerequisites]

# Projekt struktúra

# Env
Szükséges környezeti változók melyeket a rootban egy .env fileban kell elhelyezni.
MAIL_API_KEY=
SENDER_MAIL=
Az api key a mailersendből generált api key.
A sender mail pedig amin keresztül az emailek kiküldésre kerülnek. 
Szükséges hozzájuk domain és dns beállítás is. 