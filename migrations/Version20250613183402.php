<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613183402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE bridge_ginko_pds (id INT AUTO_INCREMENT NOT NULL, id_pds INT NOT NULL, id_pds_ginko VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) NOT NULL, edl_id INT NOT NULL, edl_reference VARCHAR(255) NOT NULL, edl_typespace VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, sousetat VARCHAR(255) DEFAULT NULL, coupe VARCHAR(3) DEFAULT NULL, motif_coupure VARCHAR(255) DEFAULT NULL, coupure_accessible VARCHAR(255) DEFAULT NULL, nature VARCHAR(5) DEFAULT NULL, typeinjection VARCHAR(255) DEFAULT NULL, limitation VARCHAR(3) DEFAULT NULL, puissancelimitation VARCHAR(255) DEFAULT NULL, lieulimitation VARCHAR(255) DEFAULT NULL, motiflimitation VARCHAR(255) DEFAULT NULL, puissancelimitetechnique VARCHAR(255) DEFAULT NULL, communicabilite VARCHAR(255) DEFAULT NULL, normecommunicationcpl VARCHAR(20) DEFAULT NULL, ccpiaccessible VARCHAR(3) DEFAULT NULL, emplacementcompteur VARCHAR(255) DEFAULT NULL, accescompteur VARCHAR(3) DEFAULT NULL, accesdisjoncteur VARCHAR(3) DEFAULT NULL, modereleve VARCHAR(255) DEFAULT NULL, typetension VARCHAR(255) DEFAULT NULL, ahautrisquevital VARCHAR(3) DEFAULT NULL, teleoperable VARCHAR(3) DEFAULT NULL, dateteleoperable DATE DEFAULT NULL, datebasculecommactive DATE DEFAULT NULL, datecreation DATE DEFAULT NULL, releveagent_date DATE DEFAULT NULL, datemodification DATETIME DEFAULT NULL, dateetat DATE DEFAULT NULL, dateetatlimitation DATE DEFAULT NULL, datemodifniveaucomm DATE DEFAULT NULL, datemiseenservice DATE DEFAULT NULL, commentaireintervenant LONGTEXT DEFAULT NULL, niveauouvertureservice VARCHAR(255) DEFAULT NULL, utilisation VARCHAR(255) DEFAULT NULL, centre_code VARCHAR(3) DEFAULT NULL, positiongps_lat VARCHAR(255) DEFAULT NULL, positiongps_lgt VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, adresse_compl VARCHAR(255) DEFAULT NULL, codepostal VARCHAR(5) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, codeinsee VARCHAR(5) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bridge_ginko_taches (id INT AUTO_INCREMENT NOT NULL, reference_tache INT NOT NULL, reference_pds VARCHAR(15) NOT NULL, date_creation_tache DATETIME NOT NULL, extrait_tache VARCHAR(255) DEFAULT NULL, statut_tache VARCHAR(255) DEFAULT NULL, date_debut_tache DATETIME DEFAULT NULL, liste_gestion VARCHAR(255) DEFAULT NULL, famille_tache VARCHAR(255) DEFAULT NULL, groupe_travail VARCHAR(255) DEFAULT NULL, libelle_nature_tache VARCHAR(255) DEFAULT NULL, description_nature_tache VARCHAR(255) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, code_insee VARCHAR(5) DEFAULT NULL, code_centre VARCHAR(3) DEFAULT NULL, code_affaire VARCHAR(255) DEFAULT NULL, reference_affaire VARCHAR(255) DEFAULT NULL, nature_intervention VARCHAR(255) DEFAULT NULL, objet_affaire VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', reference_sge VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bridge_meteore_dipole_bt (id INT AUTO_INCREMENT NOT NULL, gdo VARCHAR(10) DEFAULT NULL, code_gdo_ds VARCHAR(10) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, date_creation_sig DATE DEFAULT NULL, date_maj DATE DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bridge_meteore_poste_dp (id INT AUTO_INCREMENT NOT NULL, base_oper VARCHAR(10) DEFAULT NULL, code_gdo VARCHAR(10) NOT NULL, nom VARCHAR(255) DEFAULT NULL, fctn_poste_sig_orig VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, detail_emplacement VARCHAR(255) DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, date_crea_sig DATE DEFAULT NULL, date_mise_en_exploitation DATE DEFAULT NULL, date_maj_sig DATE DEFAULT NULL, date_mise_hors_expl DATE DEFAULT NULL, dossier_sig_crea VARCHAR(255) DEFAULT NULL, dossier_sig_modif VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, pos_geo_long_lat_wkt JSON DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE capella (id INT AUTO_INCREMENT NOT NULL, dossier VARCHAR(50) NOT NULL, statut VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, createur VARCHAR(255) DEFAULT NULL, entity_suivi VARCHAR(255) DEFAULT NULL, bureau_suivi VARCHAR(255) DEFAULT NULL, date_cloture DATE DEFAULT NULL, canal_echange VARCHAR(255) DEFAULT NULL, sens_canal VARCHAR(255) DEFAULT NULL, identifiant VARCHAR(255) DEFAULT NULL, segment VARCHAR(255) DEFAULT NULL, client VARCHAR(255) DEFAULT NULL, code_insee VARCHAR(5) DEFAULT NULL, processus VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, sous_type VARCHAR(255) DEFAULT NULL, nni_cloture VARCHAR(255) DEFAULT NULL, nom_cloture VARCHAR(255) DEFAULT NULL, bureau_traitement VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE gsa_c5 (id INT AUTO_INCREMENT NOT NULL, centre VARCHAR(3) DEFAULT NULL, prm VARCHAR(14) DEFAULT NULL, statut_client VARCHAR(15) DEFAULT NULL, etat_rattachement VARCHAR(20) DEFAULT NULL, nb_fils INT DEFAULT NULL, option_tarifaire VARCHAR(255) DEFAULT NULL, branche_activite VARCHAR(255) DEFAULT NULL, puissance_souscrite INT DEFAULT NULL, residence_secondaire VARCHAR(3) DEFAULT NULL, nom_client VARCHAR(255) DEFAULT NULL, num_rue VARCHAR(10) DEFAULT NULL, nom_rue VARCHAR(255) DEFAULT NULL, compl_adresse VARCHAR(255) DEFAULT NULL, code_insee VARCHAR(5) DEFAULT NULL, troncon_rattachement VARCHAR(255) DEFAULT NULL, distance_rattachement VARCHAR(255) DEFAULT NULL, position_x VARCHAR(255) DEFAULT NULL, position_y VARCHAR(255) DEFAULT NULL, gdo_ligne_bt VARCHAR(255) DEFAULT NULL, gdo_poste VARCHAR(255) DEFAULT NULL, nom_poste VARCHAR(255) DEFAULT NULL, type_poste VARCHAR(255) DEFAULT NULL, id_prm VARCHAR(14) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, liaison_reseau_id VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', created_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sge_prestations (id INT AUTO_INCREMENT NOT NULL, code_statut_affaire VARCHAR(5) DEFAULT NULL, libelle_statut_affaire VARCHAR(255) DEFAULT NULL, libelle_etat_affaire VARCHAR(255) DEFAULT NULL, segment VARCHAR(2) DEFAULT NULL, prm VARCHAR(14) NOT NULL, rue_adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, etat_point VARCHAR(255) DEFAULT NULL, date_heure_demande DATETIME DEFAULT NULL, code_type VARCHAR(10) DEFAULT NULL, libelle_type VARCHAR(255) DEFAULT NULL, code_option VARCHAR(10) DEFAULT NULL, libelle_option VARCHAR(255) DEFAULT NULL, nom_titulaire_contrat VARCHAR(255) DEFAULT NULL, prenom_titulaire_contrat VARCHAR(255) DEFAULT NULL, id_affaire VARCHAR(255) NOT NULL, clientfinal_nom VARCHAR(255) DEFAULT NULL, clientfinal_prenom VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sge_reclamations (id INT AUTO_INCREMENT NOT NULL, libelle_statut VARCHAR(50) DEFAULT NULL, code_statut VARCHAR(10) DEFAULT NULL, segment VARCHAR(2) DEFAULT NULL, description_demande_precision VARCHAR(255) DEFAULT NULL, date_reception_reclamation DATETIME DEFAULT NULL, libelle_objet_demande VARCHAR(255) DEFAULT NULL, denomination_sociale_personnemorale VARCHAR(255) DEFAULT NULL, nom_commercial_personnemorale VARCHAR(255) DEFAULT NULL, nom_personnephysique VARCHAR(255) DEFAULT NULL, prenom_personnephysique VARCHAR(255) DEFAULT NULL, telephone1num_reclamant VARCHAR(20) DEFAULT NULL, telephone2num_reclamant VARCHAR(20) DEFAULT NULL, adresse_email_reclamant VARCHAR(255) DEFAULT NULL, libelle_type VARCHAR(255) DEFAULT NULL, nom_interlocuteur VARCHAR(255) DEFAULT NULL, prenom_interlocuteur VARCHAR(255) DEFAULT NULL, libelle_reclamation VARCHAR(255) DEFAULT NULL, point_id_reclamation VARCHAR(14) DEFAULT NULL, batiment_adresse VARCHAR(255) DEFAULT NULL, numero_nom_voie_adresse VARCHAR(255) DEFAULT NULL, lieu_dit_adresse VARCHAR(255) DEFAULT NULL, code_postal_adresse VARCHAR(5) DEFAULT NULL, libelle_commune VARCHAR(255) DEFAULT NULL, libelle_site VARCHAR(255) DEFAULT NULL, code_insee_reclamation VARCHAR(5) DEFAULT NULL, libelle_motif_demande VARCHAR(255) DEFAULT NULL, description_reclamation VARCHAR(255) DEFAULT NULL, reponse_directe_reclamant_reclamation VARCHAR(255) DEFAULT NULL, saisine_mediateur_reclamation TINYINT(1) DEFAULT NULL, prejudice_client_reclamation TINYINT(1) DEFAULT NULL, libelle_nature_prejudice VARCHAR(255) DEFAULT NULL, commentaire_sensibilite VARCHAR(255) DEFAULT NULL, code_processus VARCHAR(255) DEFAULT NULL, numero_reclamation VARCHAR(255) DEFAULT NULL, categorie VARCHAR(50) DEFAULT NULL, libelle_type_demande VARCHAR(255) DEFAULT NULL, libelle_sous_type VARCHAR(255) DEFAULT NULL, nature_demande_libelle VARCHAR(255) DEFAULT NULL, recevabilite_etat_affaire VARCHAR(255) DEFAULT NULL, prm_usage VARCHAR(255) DEFAULT NULL, application_source VARCHAR(255) DEFAULT NULL, acteurtraitement VARCHAR(255) DEFAULT NULL, id_traitement VARCHAR(255) DEFAULT NULL, trig_dr VARCHAR(3) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE bridge_ginko_pds
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bridge_ginko_taches
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bridge_meteore_dipole_bt
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bridge_meteore_poste_dp
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capella
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE gsa_c5
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sge_prestations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sge_reclamations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
