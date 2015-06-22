<?php
/**
 * Created by PhpStorm.
 * User: dirfi
 * Date: 20/06/2015
 * Time: 14:37
 */
try{
    $db=new PDO('mysql:host=localhost;dbname=pootp1','root','');
}
catch (Exception $e){
    echo 'la base de donnees n\'existe pas: ';
}

$q=$db->prepare('SELECT * FROM personnages WHERE nom<>:nom');
$q->bindValue(':nom','Sosso',PDO::PARAM_STR);
$q->execute();
$tab=$q->fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($tab);
echo '</pre>';

/*$exec=$query->execute();
print_r($exec);

echo '<pre>';
print_r($query->fetch(PDO::FETCH_ASSOC));
echo '<pre>';
*/

/*$sth = $dbh->prepare("SELECT name, colour FROM fruit");
$sth->execute();

/* Fetch all of the remaining rows in the result set */
/*print("Fetch all of the remaining rows in the result set:\n");
$result = $sth->fetchAll();
print_r($result);*/