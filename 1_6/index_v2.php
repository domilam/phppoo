<?php

/*on enregistre notre autoload*/
function chargerClass($classe){
    require $classe.'.php';
}
spl_autoload_register('chargerClass');
session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.


if (isset($_GET['deconnexion'])) /*on détruit la session si déconnexion*/
{
    session_destroy();
    header('Location: index_v2.php');
    exit();
}


if (isset($_SESSION['perso'])) // Si la session perso existe, on restaure l'objet.
{
    $perso = $_SESSION['perso'];
}


/*on accède à la base de donnée*/
try{
    $db=new PDO('mysql:host=localhost;dbname=pootp1','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
}
catch(exception $e){
    echo 'la base n\'existe pas';
}

/*on créè un personnage Manager*/
$manager=new PersonnagesManager_V2($db);

if (isset($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
{
    $perso = new Personnage_V2(['nom' => $_POST['nom']]); // On crée un nouveau personnage.

    if (!$perso->nomValide())
    {
        $message = 'Le nom choisi est invalide.';
        unset($perso);
    }
    elseif ($manager->exists($perso->nom()))
    {
        $message = 'Le nom du personnage est déjà pris.';
        unset($perso);
    }
    else
    {
        $manager->add($perso);
    }
}

elseif (isset($_POST['utiliser']) && isset($_POST['nom'])) // Si on a voulu utiliser un personnage.
{
    if ($manager->exists($_POST['nom'])) // Si celui-ci existe.
    {
        $perso = $manager->get($_POST['nom']);
    }
    else
    {
        $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
    }
}
elseif (isset($_GET['frapper'])) // Si on a cliqué sur un personnage pour le frapper.
{
    if (!isset($perso))
    {
        $message = 'Merci de créer un personnage ou de vous identifier.';
    }

    else
    {
        if (!$manager->exists((int) $_GET['frapper']))
        {
            $message = 'Le personnage que vous voulez frapper n\'existe pas !';
        }

        else
        {
            $persoAFrapper = $manager->get((int) $_GET['frapper']);

            $retour = $perso->frapper($persoAFrapper); // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.

            switch ($retour)
            {
                case Personnage_V2::CEST_MOI :
                    $message = 'Mais... pourquoi voulez-vous vous frapper ???';
                    break;

                case Personnage_V2::FRAPPE :
                    $message = 'Le personnage a bien été frappé !';

                    $manager->update($perso);
                    $manager->update($persoAFrapper);

                    break;

                case Personnage_V2::TUE :
                    $message = 'Vous avez tué ce personnage !';

                    $manager->update($perso);
                    $manager->delete($persoAFrapper);

                    break;
            }
        }
    }
}


?>

    <!DOCTYPE html>
    <html>
    <head lang="fr">
        <meta charset="UTF-8">
        <title>Jeu de combat</title>
    </head>
    <body>
    <p>Nombre de personnage : <?=$manager->count() ?></p>

    <?php
    if (isset($message)) // On a un message à afficher ?
    {
        echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
    }

    if (isset($perso)) // Si on utilise un personnage (nouveau ou pas).
    {
        ?>
        <p><a href="?deconnexion=1">Déconnexion</a></p>
        <fieldset>
            <legend>Mes informations</legend>
            <p>
                Nom : <?= htmlspecialchars($perso->nom()) ?><br />
                Dégâts : <?= $perso->degats() ?>
            </p>
        </fieldset>

        <fieldset>
            <legend>Qui frapper ?</legend>
            <p>
                <?php
                $persos = $manager->getList($perso->nom());

                if (empty($persos))
                {
                    echo 'Personne à frapper !';
                }

                else
                {
                    foreach ($persos as $unPerso)
                        echo '<a href="?frapper=', $unPerso->id(), '">', htmlspecialchars($unPerso->nom()), '</a> (dégâts : ', $unPerso->degats(), ')<br />';
                }

                ?>
            </p>
        </fieldset>
    <?php
    }
    else
    {
        ?>
        <form method="post" action>
            <p>
                <label for="nom">Tapez le nom du personnage : </label><input type="text" name="nom" id="nom">
                <input type="submit" value="Créer le personnage" name="creer">
                <input type="submit" value="Utiliser le personnage" name="utiliser">
            </p>


        </form>
    <?php
    }
    ?></body>
    </html>
<?php
if (isset($perso)) // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
{
    $_SESSION['perso'] = $perso;
}