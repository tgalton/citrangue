<?php
declare(strict_types=1);

// METTRE LE BON LIEN LORSQUE LE SERVEUR DE LA BDD FONCTIONNERA

// function getPdo(): PDO
// {
//     $dsn = 'mysql:dbname=tomgalton_BDOtest;host=db.3wa.io;charset=UTF8';
//     $user = 'tomgalton';
//     $password = 'ec99b76eccf924f56e914edcbbcacbb9';
//     $connect = new PDO($dsn, $user, $password, 
//     [
//         // Affichage des exceptions
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         // Affichage des résultats en mode objet
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
//         // Affichage des résultats en tableau associatif
//         // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//     ]);
//     return $connect;
// }