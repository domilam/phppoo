<?php
/**
 * Created by PhpStorm.
 * User: dirfi
 * Date: 23/06/2015
 * Time: 07:27
 */

class Guerrier extends Personnage_V2 {

    public function recevoirDegats(){

        $degats= $this->degats(); /*on récupère les dégats*/

        /*on met à jour l'atout en fonction des dégats*/
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
        /*on augmente les dégats*/
        $degats+=5-$this->atout();
        $this->setDegats($degats);

        return ($degats>100)?static::TUE:static::FRAPPE; /*on retourne tué ou frappé*/

    }

} 