<?php
    class Personnage{
        private $_id;
        private $_nom;
        private $_forcePerso;
        private $_degats=0;
        private $_niveau=1;
        private $_experience=1;

        public function __construct(array $donnees){
            $this->hydrate($donnees);

        }

        public function hydrate(array $donnees){
            foreach($donnees as $cle=>$valeurs){
                $setter='set'.ucfirst($cle);
                if (method_exists($this,$setter)){
                    $this->$setter($valeurs);
                }

            }
        }
/*les getters et les setters*/
        public function id(){
            return $this->_id;
        }

        public function setId($id){
            $id=(int)$id;
            ($id>0)?$this->_id=$id:trigger_error('L\'id doit être supérieur à 0',E_USER_ERROR);
        }

        public function nom(){
            return $this->_nom;
        }

        public function setNom($nom){
             (is_string($nom))?$this->_nom=$nom:trigger_error('Le nom doit être composé de caractère',E_USER_ERROR);
        }

        public function forcePerso(){
            return $this->_forcePerso;
        }

        public function setForcePerso($force){
            $force=(int)$force;
            (($force>=1)&&($force<=100))?$this->_forcePerso=$force:trigger_error('La force doit être comprise entre 1 et 100',E_USER_ERROR);
        }

        public function degats(){
            return $this->_degats;
        }
        public function setDegats($degats){
            $degats=(int)$degats;
            (($degats>=0)&&($degats<=100))?$this->_degats=$degats:trigger_error('Les dégats doivent être compris entre 0 et 100',E_USER_ERROR);
        }

        public function niveau(){
            return $this->_niveau;
        }
        public function setNiveau($niveau){
            $niveau=(int)$niveau;
            (($niveau>=1)&&($niveau<=100))?$this->_niveau=$niveau:trigger_error('Le niveau doit être compris entre 1 et 100',E_USER_ERROR);
        }

        public function experience(){
            return $this->_experience;
        }

        public function setExperience($experience){
            $experience=(int)$experience;
            (($experience>=1)&&($experience<=100))?$this->_experience=$experience:trigger_error('L\'experience doit être comprise entre 1 et 100',E_USER_ERROR);
        }

    }



