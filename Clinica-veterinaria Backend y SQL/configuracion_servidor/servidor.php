<?php
    /* Constantes para la coneccion a la base de datos */ 
    const SERVIDOR = 'localhost';
    const NOMBRE_DB = 'clinica_veterinaria';
    const USUARIO = 'root';
    const PASS = '';

    const CONECCION = 'mysql:host='.SERVIDOR.';dbname='.NOMBRE_DB;

    /* Constantes y metodo de cifrado */ 
    const METODO = 'AES-256-CBC';
    const SECRET_KEY = 'LENGUAJESDEINTERNET@2021';
    const SECRET_IV = 'CLINICAVETERINARIA';