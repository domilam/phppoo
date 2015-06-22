<?php

    function chargerClass($classe){
        require $classe.'.php';
    }

    spl_autoload_register('chargerClass');

    $perso1=new Personnage(Personnage::FORCE_PETITE,40);
    $perso2=new Personnage(Personnage::FORCE_MOYENNE,100);

    $perso1->frapper($perso2);
    $perso1->gagnerExperience();

    $perso2->frapper($perso1);
    $perso2->gagnerExperience();

    $perso1->afficherDegats();
    $perso2->afficherDegats();

