<?php

// DB_HOST: Tietokannan host-osoite
define('DB_HOST', 'localhost');

// DB_NAME: Tietokannan nimi.
define('DB_NAME', 'phpkesa');

// DB_USER: Tietokannan äyttäjätunnus. Vaatii SELECT-, UPDATE-, DELETE- ja INSERT-kyselyoikeudet em. tietokantaan.
define('DB_USER', 'phpkesa');

// DB_PASS: Tietokannan salasana
define('DB_PASS', 'phpkesa');

// MODE: client vs. admin
define('MODE', 'client' );

// Sovelluksen juurikansio
define('ROOT', '/php/');

// Absoluuttinen url (älä vaihda tätä)
define('PATH', ROOT.MODE);