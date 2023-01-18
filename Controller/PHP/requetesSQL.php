<?php
    //import par rapport au fichier qui lit ce code php
    require "./database.php";
    // require "./Session.php";

    /**
      comprendre les fonctions => cequonvachercherDepuisoù_Condition
                                        1            2         3
      1 = param du SELECT
      2 = table visée
      3 = condition WHERE (optionnel)
     */

    function titreJour(){
        global $pdo;
        $requete = $pdo->prepare('SELECT titre FROM jour;');
        $requete->execute(['']);
        $exists = $requete->fetchAll(PDO::FETCH_COLUMN);
        return $exists;
    }
    function titreSalle(){
        global $pdo;
        $requete = $pdo->prepare('SELECT titre FROM salle;');
        $requete->execute(['']);
        return $requete->fetchAll(PDO::FETCH_COLUMN);
    }
    function titreSalleDernierJour(){
        global $pdo;
        $idDernierJour = maxID();
        $requete_titres_salles = $pdo->prepare('SELECT titre FROM salle WHERE id_jour = ?;');
        $requete_titres_salles->execute(["$idDernierJour"]);
        return $requete_titres_salles->fetchAll(PDO::FETCH_COLUMN);
    }
    function maxID(){
        global $pdo;
        $requete_id_max = $pdo->prepare('SELECT max(id) FROM jour;');
        $requete_id_max->execute(['']);
        return $requete_id_max->fetchColumn();
    }
    function explosionTitre($titre, $jour){
        $titre_jour_suivant = explode("-", $titre);
        $titre_jour_suivant[1] = $jour;
        return "$titre_jour_suivant[0]-$titre_jour_suivant[1]";
    }
    function idJour_Titre($chiffre){
        global $pdo;
        $requete_jour_moins_un = $pdo->prepare('SELECT id FROM jour WHERE titre = ?;');
        $requete_jour_moins_un->execute(["Jour_$chiffre"]);
        return $requete_jour_moins_un->fetchAll(PDO::FETCH_COLUMN);

    }
    function titreSalle_IdJour($jourPasse){
        global $pdo;
        $requete_liste_salles = $pdo->prepare('SELECT titre FROM salle WHERE id_jour = ?;');
        $requete_liste_salles->execute([$jourPasse]);
        return $requete_liste_salles->fetchAll(PDO::FETCH_COLUMN);
    }
    function idJour(){
        global $pdo;
        $requete_id_jours = $pdo->prepare('SELECT id FROM jour;');
        $requete_id_jours->execute(['']);
        return $requete_id_jours->fetchAll(PDO::FETCH_COLUMN);
    }
    function titreJour_Id($jour){
        global $pdo;
        $requete_jour = $pdo->prepare('SELECT titre FROM jour WHERE id = ?');
        $requete_jour->execute([$jour]);
        return $requete_jour->fetchAll(PDO::FETCH_COLUMN);
    }
    function idSalle_Titre($salle){
        global $pdo;
        $requete_id_salle = $pdo->prepare('SELECT id FROM salle WHERE titre = ?');
        $requete_id_salle->execute([$salle]);
        return $requete_id_salle->fetchAll(PDO::FETCH_COLUMN);
    }
    function titreSession_IdSalle($salle){
        global $pdo;
        $requete_liste_sessions = $pdo->prepare('SELECT titre FROM session WHERE id_salle = ?;');
        $requete_liste_sessions->execute([$salle]);
        return $requete_liste_sessions->fetchAll(PDO::FETCH_COLUMN);
    }
    function cadenasStatus(){
        global $pdo;
        $req = $pdo->prepare('SELECT cadenas FROM lock_unlock');
        $req->execute();
        return $req->fetchColumn();
    }
    function sessionValide($dsn, $username, $password, $session_sql){
        $pdo = new PDO($dsn, $username, $password);
        return $pdo->query($session_sql);
    }
    function sessionStatus(){
        global $pdo;
        $req = $pdo->prepare('SELECT session FROM lock_unlock');
        $req->execute();
        return $req->fetchColumn();
    }
    function titreSession_Id($idSession){
        global $pdo;
        $req = $pdo->prepare('SELECT titre FROM session WHERE id = ?');
        $req->execute([$idSession]);
        return $req->fetchColumn();
    }
    function idSalleSession_Titre($titre){
        global $pdo;
        $requete_id_salle = $pdo->prepare('SELECT id_salle FROM session WHERE titre = ?;');
        $requete_id_salle->execute([$titre]);
        return $requete_id_salle->fetchColumn();
    }
    function titreSalle_Id($salle){
        global $pdo;
        $requete_nom_salle = $pdo->prepare('SELECT titre FROM salle WHERE id = ?;');
        $requete_nom_salle->execute([$salle]);
        return $requete_nom_salle->fetchColumn();
    }
    function idJourSalle_Id($salle){
        global $pdo;
        $requete_id_jour = $pdo->prepare('SELECT id_jour FROM salle WHERE id = ?;');
        $requete_id_jour->execute([$salle]);
        return $requete_id_jour->fetchColumn();
    }
    function countId(){
        global $pdo;
        $req = $pdo->prepare('SELECT count(id) FROM document');
        $req->execute();
        return $req->fetchColumn();
    }
    function dernierId(){
        global $pdo;
        $req = $pdo->prepare('SELECT min(id) FROM document');
        $req->execute();
        return $req->fetch();
    }
    function tdatokenDocument_Id($iterateur){
        global $pdo;
        $req = $pdo->prepare("SELECT titre, description, AncienNom, token_document FROM document WHERE id = ?;");
        $req->execute([$iterateur]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    function numintervenantDocument_Id($iterateur){
        global $pdo;
        $req = $pdo->prepare("SELECT num_intervenant FROM document WHERE id = ?;");
        $req->execute([$iterateur]);
        return $req->fetchColumn();
    }
    function nptIntervenant_Id($num_intervenant){
        global $pdo;
        $req = $pdo->prepare("SELECT nom, prenom, token_photo FROM intervenant WHERE id = ?");
        $req->execute([$num_intervenant]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    function numsessionDocument_Id($document){
        global $pdo;
        $req = $pdo->prepare('SELECT num_session FROM document WHERE id = ?');
        $req->execute([$document]);
        return $req->fetchColumn();
    }
    function idSalleSession_Id($session){
        global $pdo;
        $req = $pdo->prepare('SELECT id_salle FROM session WHERE id = ?');
        $req->execute([$session]);
        return $req->fetchAll(PDO::FETCH_COLUMN);
    }
    function idTitreDescTdnuminumsDocument_Td($td){
        global $pdo;
        $req = $pdo->prepare("SELECT id, titre, description, token_document, num_intervenant, num_session FROM document WHERE token_document = ?");
        $req->execute([$td]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    function nomPrenomTpIntervenant_Id($num_intervenant){
        global $pdo;
        $req = $pdo->prepare("SELECT nom, prenom, token_photo FROM intervenant WHERE id = ?");
        $req->execute([$num_intervenant]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * 
      INSERTION DANS LA BDD A PARTIR D'ICI
     * 
     */
    function insererJour($jour){
        global $pdo;
        $requete = $pdo->prepare("INSERT INTO jour (titre) VALUES (?);");
        $requete->execute([$jour]);
    }
    function insererSalle($titre, $idJour){
        global $pdo;
        $requete_inserer_salles = $pdo->prepare('INSERT INTO salle (titre, id_jour) VALUES (?, ?)');
        $requete_inserer_salles->execute([$titre, $idJour]);
    }
    function insererSession($salle, $titre, $date){
        global $pdo;
        $requete_titre_session = $pdo->prepare('INSERT INTO session (id_salle, titre, created_at) VALUES (?, ?, ?);');
        $requete_titre_session->execute([$salle, $titre, $date]);
    }

    /**
     * 
      MISE A JOUR (UPDATE) DANS LA BDD A PARTIR D'ICI
     * 
     */
    function updateDocumentTitreDescAncienNomTdNumIntNumS_Id($titre, $description, $ancienNom, $td, $num_intervenant, $num_session, $id){
        global $pdo;
        $requete_update_document = $pdo->prepare("UPDATE document SET titre = ?, description = ?, AncienNom = ?, token_document = ?, num_intervenant = ?, num_session = ? WHERE id = ?;");
        $requete_update_document->execute([$titre, $description, $ancienNom, $td, $num_intervenant, $num_session, $id]);
    }
?>