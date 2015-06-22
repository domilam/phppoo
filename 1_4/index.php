<?php
function chargerClass($classe){
    require $classe.'.php';
}

spl_autoload_register('chargerClass');

$perso = new Personnage([
  'nom' => 'Victor',
  'forcePerso' => 5,
  'degats' => 0,
  'niveau' => 1,
  'experience' => 1
]);

$db = new PDO('mysql:host=localhost;dbname=tests', 'root', '');
echo 'base ouverte';
$manager = new PersonnagesManager($db);
echo 'manager créé';
echo $perso->nom();
$manager->add($perso);
