<?php
    class Compteur
    {
        private static $_compteur;

        public function __construct(){
            self::$_compteur+=1;
        }

        public static function affcompt(){
            echo self::$_compteur;
        }

    }

    $compt1=new Compteur();
    $compt2=new Compteur();
    $compt3=new Compteur();

    Compteur::affcompt();

