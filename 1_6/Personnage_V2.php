<?php
    class Personnage_V2{
        private $_id;
        private $_nom;
        private $_degats;
        private $_experience; // L'expérience du personnage.

        const CEST_MOI=1;
        const FRAPPE=2;
        const TUE=3;

        public function gagnerExperience(){
            // On ajoute 1 à notre attribut $_experience.
            $this->_experience = $this->_experience + 1;
        }

        public function frapper(Personnage_V2 $perso){
            /*on vérifie qu'on ne se frappe pas soit même, sinon on renverra une valeur indiquant qu'on se frappe*/
            if ($this->_id==$perso->id()){
                return self::CEST_MOI;
            }
            /*on indique au personnage frappé qu'il doit recevoir des dégats*/
            return $perso->recevoirDegats();

        }

        public function recevoirDegats(){
            /*on va augmenter les dégats du personnage qui a été frappé, de 5*/
            $this->_degats+=5;

            /*on verifie si on est arrivé à 100, si oui on retourne une valeur disant que le personnage est tué*/
            /*sinon on indique que le personnage a bien été frappé*/
            return ($this->_degats>100)?self::TUE:self::FRAPPE;
        }

        /*le constructeur*/
        public function __construct(array $donnees){
            $this->hydrate($donnees);
        }


        /*hydratation de l'objet*/
        public function hydrate(array $donnees){
            foreach($donnees as $key=>$value){
                $method='set'.ucfirst($key);
                if (method_exists($this,$method)){
                    $this->$method($value);
                }
            }
        }

        /*les getters  et setters*/
        public function id(){
            return $this->_id;
        }

        public function setId($id){
            $id=(int)$id;
            return ($id>0)?$this->_id=$id:trigger_error('L\'id doit être >0', E_USER_ERROR);
        }

        public function nom(){
            return $this->_nom;
        }

        public function setNom($nom){
            (is_string($nom))?$this->_nom=$nom:trigger_error('le nom doit être composé de caractère',E_USER_ERROR);
        }

        public function degats(){
            return $this->_degats;

        }

        public function setDegats($degats){
            $degats=(int)$degats;
            (($degats>=0)&&($degats<=100))?$this->_degats=$degats:trigger_error('Les degats doivent etre compris entre 0 et 100',E_USER_ERROR);
        }

        public function nomValide(){
            return !empty($this->_nom);
        }

    }