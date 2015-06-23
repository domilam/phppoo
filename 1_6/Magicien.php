<?php
/**
 * Created by PhpStorm.
 * User: dirfi
 * Date: 23/06/2015
 * Time: 09:09
 */

class Magicien extends Personnage_V2{

    public function recevoirDegats(){
        $degats=$this->degats(); /*on recupère les dégats*/

//        on met à jour la valeur de l'atout en fonction des dégats
        if ($degats>=0){
            if ($degats<=25){
                $this->setAtout(4);
            }elseif ($degats<=50){
                $this->setAtout(3);
            }elseif ($degats<=75){
                $this->setAtout(2);
            }elseif ($degats<=90) {
                $this->setAtout(1);
            }else $this->setAtout(0);
        }

//        on endort le personnage frappé
        $this->setTimeEndormi(($this->atout()*6)*3600);

        return $this->timeEndormi();

    }

    public function lancerUnSort(Personnage_V2 $perso)
    {
        if ($this->id()==$perso->id()){
            return static::CEST_MOI;
        }elseif ($this->atout()==0){return static::PAS_DE_MAGIE;}
        /*on indique au personnage frappé qu'il doit recevoir des dégats*/
        return $perso->recevoirDegats();
    }

}