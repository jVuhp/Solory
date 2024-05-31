<?php
define('INSTALL_MODE', 1); // (https://docs.devbybit.com/blackout-license-software/installation)
define('DATABASE_CONFIG', 0); 
define('DEBUGG', 0); 

// ============================================================ //
//                    DATABASE CONFIGURATION                    //
// ============================================================ //

define('DB_TYPE', 'JSON');// OPTIONS: MYSQL / JSON
define('DB_HOST', 'localhost');
define('DB_PORT', 3306); //MYSQL: 3306 / REDIS: 6379
define('DB_DATA', 'devbybit_solory');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Manuel21051986_33!');


// ============================================================ //
//                     SOROLY CONFIGURATION                     //
// ============================================================ //

define('URI', 'https://soroly.devbybit.com');

define('LICENSE_KEY', 'PUT_YOUR_KEY');

define('SECRET_KEY', '3T71Y5RFNAY00NP6KIU8ISGK51GIJ09U');
define('SOFTWARE', 'Soroly');
define('SOFTWARE_ICON', 'https://templated.devbybit.com/img/blackout/blackout-logo-wb1.png');

// ============================================================ //
//                   GOOGLE CONFIGURATION                       //
// ============================================================ //
define('GOOGLE_CLIENT_ID', '1077436088003-o2bd9cg7p5df4n4ua10u5ha26taplf9l.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');


?>
<?php
/*
A TERMINAR:
- TERMINAR LAS ACCIONES DE EDITAR Y ELIMNAR EN USER/GROUP
- HACER EL ADD Y REMOVE GROUP DEL USER
- HACER EL API
- HACER LA VISTA/EDIT/DELETE/ADD DE PERMISOS Y USUARIOS EN GROUP
*/
?>