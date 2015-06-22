<?php
    class PersonnagesManager{
        private $_db;


        /*le constructeur*/
        public function __construct($db){
            $this->setDb($db);
        }

        /*le setter*/
        public function setDb(PDO $db){
            $this->_db=$db;
        }

        /*Ajout d'un personnage*/
        public function add(Personnage $perso){
            /*cette méthode ajoutera un personnage dans la base*/
            /*préparer la requête paramétrée*/
            $query=$this->_db->prepare('INSERT INTO personnages (nom) VALUES (:nom)');
            /*assigner la valeur au paramètre*/
            $query->bindValue(':nom',$perso->nom());
            /*exécuter la requête*/
            $query->execute();

            /*hydratation du personne avec l'id créé*/
            $perso->hydrate([
                'id' => $this->_db->lastInsertId(),
                'degats' => 0,
            ]);
        }

        /*Suppression d'un personnage*/
        public function delete(Personnage $perso){
            /*cette méthode supprimera un personnage dans la base*/
            /*lancer la requête de suppression*/
            $this->_db->exec('DELETE FROM personnages WHERE id='.$perso->id());
        }

        /*Modification d'un personnage*/
        public function update(Personnage $perso){
            /*cette requête fera une mise modification des données*/
            /*préparer la requête paramétrée*/
            $query=$this->_db->prepare('UPDATE personnages SET degats=:degats WHERE id=:id');
            /*assigner les vaeurs aux paramètres*/
            $query->bindValue(':degats',$perso->degats(),PDO::PARAM_INT);
            $query->bindValue(':id',$perso->id(),PDO::PARAM_INT);
            /*exécuter la requête*/
            $query->execute();
        }

        public function exists($info)
        {
            if (is_int($info)) // On veut voir si tel personnage ayant pour id $info existe.
            {
                return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
            }

            // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.

            $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
            $q->execute([':nom' => $info]);

            return (bool) $q->fetchColumn();
        }


        public function get($info)
        {
            /*cette requête va récupérer les données en base*/
            if (is_int($info)){
                $q = $this->_db->query('SELECT * FROM personnages WHERE id=' . $info);
                return new Personnage($q->fetch(PDO::FETCH_ASSOC));

            }else{
                $q=$this->_db->prepare('SELECT * FROM personnages WHERE nom = :nom');
                $q->execute([':nom' => $info]);
                return new Personnage($q->fetch(PDO::FETCH_ASSOC));

            }

        }

        public function getList($nom)
        {
            $persos=[];
            // Retourne la liste des personnages dont le nom n'est pas $nom.
            $query=$this->_db->prepare('SELECT * FROM personnages WHERE nom <> :nom');
            $query->bindValue(':nom',$nom,PDO::PARAM_STR);
            $query->execute();            // Le résultat sera un tableau d'instances de Personnage.
            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $persos[] = new Personnage($donnees);
            }

            return $persos;

        }


        public function count()
        {
            // Exécute une requête COUNT() et retourne le nombre de résultats retourné.

            return $this->_db->query('SELECT COUNT(id) FROM personnages')->fetchColumn();
        }

    }