<?php
//poo/Personnage.php
class Personnage
{
    private $_degats; // Les dégâts du personnage.
    private $_experience; // L'expérience du personnage.
    private $_force; // La force du personnage (plus elle est grande, plus l'attaque est puissante).

    const FORCE_PETITE=20;
    const FORCE_MOYENNE=50;
    const FORCE_GRANDE=80;

    public function __construct($force,$degats){

        $this->setForce($force);
        $this->setDegats($degats);
        $this->_experience=1;
    }
    public function gagnerExperience(){
        // On ajoute 1 à notre attribut $_experience.
        $this->_experience = $this->_experience + 1;
    }

    public function frapper(Personnage $perso){
        /*On augmente les degats du personnage*/
        $perso->_degats+=$this->_force;

    }

    public function afficherDegats(){
        echo $this->_degats;
    }
    /*Les getteers*/
    public function degats(){
        return $this->_degats;
    }

    public function experience(){
        return $this->_experience;
    }

    public function force(){
        return $this->_force;
    }

    /*Les setters*/
    public function setDegats($degats){
        if (!is_int($degats)){
            trigger_error('Le paramètre \'degats\' doit être un nombre', E_USER_ERROR);
        }
        return $this->_degats+=$degats;
    }

    public function setExperience($experience){
        if (!is_int($experience)){
            trigger_error('Le paramètre \'experience\' doit être un nombre', E_USER_ERROR);
        }
        return $this->_experience+=$experience;
    }

    public function setForce($force){
        if (in_array($force,[self::FORCE_PETITE,self::FORCE_MOYENNE,self::FORCE_GRANDE])){
            return $this->_force=$force;
        }
    }

}












