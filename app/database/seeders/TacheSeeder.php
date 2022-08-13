<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
			[13, 'GE - navire', 'Conduite du domaine navire'],
			[33, 'SOCLE-PRODEF', 'Protection Défense'],
			[12, 'GE - ELEC', 'Conduite du domaine elec'],
			[14, 'GE - PC MES', 'Quart au PC MES'],
			[15, 'GE - manoeuvre', 'Domaine manoeuvre'],
			[16, 'OG - ELEC', 'Connaître l\'usine électrique'],
			[17, 'OG - manoeuvre', 'Acquérir les compétences du domaine MAN'],
			[18, 'OG - sécurité', 'Acquérir les compétences du domaine SECURITE'],
			[19, 'OG - SST', 'Compétence SST'],
			[20, 'OG - service courant', 'Compétence du domaine SERVICE COURANT'],
			[21, 'OG - SIC', 'Compétence SIC'],
			[22, 'OG - PRODEF', 'Compétence PRODEF'],
			[23, 'OG - général', 'Compétences générales'],
			[39, 'OPN - documentation', 'DOCUMENTATION'],
			[40, 'OPN -  IPMS/INS', 'RESEAU IPMS/INS'],
			[38, 'OPN - communication', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[36, 'OPSC - PRODEF', 'OPSC - PRODEF'],
			[37, 'OPN - navire', 'CONDUIRE LE DOMAINE NAVIRE'],
			[34, 'SOCLE-COMMUN', 'SOCLE-COMMUN'],
			[35, 'GN - PROTEC', 'GN - PROTEC'],
			[31, 'OPSC - manoeuvre', 'OPSC - manoeuvre'],
			[32, 'OPSC - général', 'OPSC - général'],
			[30, 'OPSC - service courant', 'OPSC - service courant'],
			[41, 'OPN - MOB', 'CONDUIRE LE DOMAINE MOBILITE'],
			[42, 'OPN - install ext', 'CONDUIRE LES INSTALLATIONS EXTERIEURS'],
			[43, 'OPN - matériel sécu', 'MATERIELS  SECURITE'],
			[44, 'OPN - install sécu', 'CONDUIRE LES INSTALLATIONS SECURITE'],
			[45, 'OPN - ELEC', 'CONDUIRE LE DOMAINE ELECTRICITE'],
			[46, 'GP - manoeuvre', 'ETRE L\'EXPERT DU DOMAINE MANŒUVRE AU SEIN DE LA FRACTION DE SERVICE'],
			[47, 'GP - PRODEF', 'PARTICIPER A LA PROTECTION DEFENSE'],
			[48, 'GN - navire', 'GRADE NAVIRE'],
			[49, 'GN - QUART PC NAVIRE', 'EFFECTUER LE QUART AU PC NAVIRE'],
			[50, 'GN - communication', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[51, 'GN - documentation', 'DOCUMENTATION'],
			[52, 'GN - conduite', 'CONDUIRE LE DOMAINE NAVIRE'],
			[53, 'GN - SIMCP', 'SIMCP'],
			[54, 'GN - MOB', 'CONDUIRE LE DOMAINE MOBILITE'],
			[55, 'GN - install ext', 'CONDUIRE LES INSTALLATIONS EXTERIEURS'],
			[56, 'GC - navman', 'Expert NAVMAN'],
			[57, 'GC-prodef', 'Capitaine d\'armes'],
			[58, 'GC - service courant', 'OG/ OPSC'],
			[59, 'METTRE EN OEUVRE LES INSTALLATIONS DE MISE A L\'EAU ', 'METTRE EN OEUVRE LES INSTALLATIONS DE MISE A L\'EAU '],
			[60, 'METTRE EN OEUVRE LES APPARAUX DE MANOEUVRE', 'METTRE EN OEUVRE LES APPARAUX DE MANOEUVRE'],
			[61, 'SECU GSIC - EXERCER LA FONCTION DE TELEPHONISTE', 'EXERCER LA FONCTION DE TELEPHONISTE'],
			[62, 'SECU - INTERVENIR EN TANT QU\'II1', 'INTERVENIR EN TANT QU\'II1'],
			[63, 'SECU GSIC - INTERVENIR SUR UN SINISTRE AU SEIN D’UN GA', 'INTERVENIR SUR UN SINISTRE AU SEIN D’UN GA'],
			[64, 'SECU GC - COMPETENCES GENERALES', 'COMPETENCES GENERALES'],
			[65, 'SECU GC - INTERVENIR EN TANT QU\'II2', 'INTERVENIR EN TANT QU\'II2 [ACTIONS NON COMMUNES AVEC L\'II1]'],
			[66, 'SECU GC - EXERCER LA FONCTION DE CHEF D\'EQUIPE D\'ALARME', 'EXERCER LA FONCTION DE CHEF D\'EQUIPE D\'ALARME'],
			[67, 'SECU GE - CHEF DU GROUPE SOUTIEN : LE DESENFUMAGE', 'CHEF DU GROUPE SOUTIEN : ASSIMILER ET METTRE EN OEUVRE LES PRINCIPES DU DESENFUMAGE'],
			[68, 'SECU GE - CHEF DU GROUPE SOUTIEN : LE MATERIEL D\'EPUISEMENT', 'CHEF DU GROUPE SOUTIEN : ASSURER LA MISE EN PLACE DU MATERIEL D\'EPUISEMENT'],
			[69, 'SECU GE - CHEF DU GROUPE SOUTIEN : ASSURER LE SOUTIEN DE L\'EQUIPE D\'INTERVENTION', 'CHEF DU GROUPE SOUTIEN : ASSURER LE SOUTIEN DE L\'EQUIPE D\'INTERVENTION'],
			[70, 'SECU GE - EQUIPIER GROUPE SOUTIEN : LE MATERIEL D\'EPUISEMENT', 'EQUIPIER GROUPE SOUTIEN : EFFECTUER LA MISE EN PLACE DU MATERIEL D\'EPUISEMENT'],
			[71, 'SECU GE - EQUIPIER GROUPE SOUTIEN : LE RENFORT DES MOYENS D ATTAQUE', 'EQUIPIER GROUPE SOUTIEN : EFFECTUER LE RENFORT DES MOYENS D ATTAQUE PAR DES BRANCHEMENTS SUPPLEMENTAIRES'],
			[72, 'SECU GE - EQUIPIER GROUPE SOUTIEN : LE SOUTIEN EN MATIERE DE LUTTE', 'EQUIPIER GROUPE SOUTIEN : EFFECTUER LE SOUTIEN EN MATIERE DE LUTTE'],
			[73, 'SECU GE - EQUIPIER GROUPE SOUTIEN : LE MATERIEL DE GESTION DES FUMEES', 'EQUIPIER GROUPE SOUTIEN : METTRE EN PLACE LE MATERIEL DE GESTION DES FUMEES'],
			[74, 'SECU GE - EQUIPIER GROUPE SOUTIEN : PARTICIPER AU CONFINEMENT D UNE ZONE', 'EQUIPIER GROUPE SOUTIEN : PARTICIPER AU CONFINEMENT D UNE ZONE'],
			[75, 'SECU GE - ACCOMPAGNATEUR DE RELEVES : ACCOMPAGNER LES POMPIERS LOURDS', 'ACCOMPAGNATEUR DE RELEVES : ACCOMPAGNER LES POMPIERS LOURDS'],
			[76, 'SECU GE - ACCOMPAGNATEUR DE RELEVES', 'ACCOMPAGNATEUR DE RELEVES'],
			[77, 'SECU GE - II1 :EFFECTUER UNE II1', 'II1 :EFFECTUER UNE II1'],
			[78, 'SECU GE - REAGIR A UN ACCIDENT DE PLONGEE', 'REAGIR A UN ACCIDENT DE PLONGEE'],
			[79, 'SECU GE - EFFECTUER UNE MISE EN SECURITE HT', 'EFFECTUER UNE MISE EN SECURITE HT'],
			[80, 'SECU GP - COMPETENCES GENERALES', 'EFFECTUER DU QUART AU PC NAVIRE : COMPETENCES GENERALES'],
			[81, 'SECU GP - COMMUNICATION', 'EFFECTUER DU QUART AU PC NAVIRE : MAITRISER LES MOYENS DE COMMUNICATION'],
			[82, 'SECU GP - REAGIR A UNE DETECTION', 'EFFECTUER DU QUART AU PC NAVIRE :  REAGIR A UNE DETECTION'],
			[83, 'SECU GP - CONSOLE DE QUART', 'EFFECTUER DU QUART AU PC NAVIRE : METTRE EN ŒUVRE LA CONSOLE DE QUART [PF4]'],
			[84, 'SECU GP - PARTICIPER A UNE INTERVENTION SECURITE', 'PARTICIPER A UNE INTERVENTION SECURITE'],
			[85, 'SECU GN - S\'EQUIPER EN TENUE D\'INTERVENTION SECURITE', 'S\'EQUIPER EN TENUE D\'INTERVENTION SECURITE'],
			[86, 'SECU OPN - ADJOINT FEU', 'ADJOINT FEU'],
			[87, 'SECU OPN - DDI', 'DDI'],
			[88, 'SECU OPN - GESTIONNAIRE ARI', 'GESTIONNAIRE ARI'],
			[89, 'SECU OPN - TELEPHONISTE DDI', 'TELEPHONISTE DDI'],
			[90, 'SECU OPN - II1', 'II1'],
			[91, 'SECU OPN - PARTICIPER A UNE INTERVENTION SECURITE', 'PARTICIPER A UNE INTERVENTION SECURITE'],
			[92, 'SECU OPSC - COMMUNICATIONS', 'COMMUNICATIONS'],
			[93, 'SECU OPSC - ELEC', 'SECU OPSC - ELEC'],
			[94, 'SECU OPSC - INTERVENTION', 'SECU OPSC - INTERVENTION'],
			[95, 'Lâcher OPSC', 'Lâcher OPSC'],
			[96, 'Lâcher OPN', 'Lâcher OPN'],
			[97, 'Lâcher OG', 'Lâcher OG'],
			[98, 'Lâcher GSIC', 'Lâcher GSIC'],
			[99, 'Lâcher GP', 'Lâcher GP'],
			[100, 'Lâcher GN', 'Lâcher GN'],
			[101, 'Lâcher GE', 'Lâcher GE'],
			[102, 'Lâcher GC', 'Lâcher GC'],
			[103, 'Lâcher GCMA', 'Lâcher GCMA'],
			[104, 'AOQN - CONDUIRE LE DOMAINE AUXILIAIRE', 'CONDUIRE LE DOMAINE AUXILIAIRE'],
			[105, 'AOQN - MOBILITE', 'CONDUIRE LE DOMAINE MOBILITE'],
			[106, 'AOQN - SECURITE', 'CONDUIRE LE DOMAINE SECURITE'],
			[107, 'AOQN - COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[108, 'AOQN - SYNTHESE', 'SYNTHESE'],
			[129, 'LAS GE ELEM - DISPONIBILITE DU MATERIEL', 'ASSURER LA DISPONIBILITE DU MATERIEL'],
			[110, 'AOQN - APPAREIL A GOUVERNER', 'PREPARER L\'APPAREIL A GOUVERNER'],
			[111, 'AOQN - MISE EN ŒUVRE DE L\'APPAREIL A GOUVERNER', 'MISE EN ŒUVRE DE L\'APPAREIL A GOUVERNER'],
			[112, 'AOQN - REAGIR A UNE AVARIE DE BARRE', 'REAGIR A UNE AVARIE DE BARRE'],
			[113, 'METTRE EN OEUVRE LES INSTALLATIONS DE RAM', 'METTRE EN OEUVRE LES INSTALLATIONS DE RAM'],
			[114, 'ARMER L\'EMBARCATION', 'ARMER L\'EMBARCATION'],
			[115, 'PREPARER L\'EMBARCATION', 'PREPARER L\'EMBARCATION'],
			[116, 'UTILISER LES OUTILS DU SID', 'UTILISER LES OUTILS DU SID'],
			[117, 'OQN - DOCUMENTATION DE CONDUITE', 'SAVOIR EXPLOITER LA DOCUMENTATION DE CONDUITE'],
			[118, 'OQN - OUTILS  DE CONDUITE', 'MAITRISER LES OUTILS  DE CONDUITE ET D\'AIDE A LA CONDUITE'],
			[119, 'OQN - COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[120, 'OQN - DOMAINE AUXILIAIRES', 'SUPERVISER LA CONDUITE DU DOMAINE AUXILIAIRES'],
			[121, 'OQN - DOMAINE MOBILITE', 'SUPERVISER LA CONDUITE DU DOMAINE MOBILITE'],
			[122, 'OQN - DOMAINE SECU', 'SUPERVISER LA CONDUITE DU DOMAINE SECU'],
			[123, 'OQN - DOMAINE ELEC', 'SUPERVISER LA CONDUITE DU DOMAINE ELEC'],
			[124, 'OQN - REACTIONS D\'URGENCE', 'MAITRISER LES REACTIONS D\'URGENCE'],
			[125, 'OQN - SYNTHESE', 'SYNTHESE'],
			[126, 'MECAN SUP - EFFECTUER LA MAINTENANCE SUPERIEURE MECANIQUE ', 'EFFECTUER LA MAINTENANCE SUPERIEURE MECANIQUE '],
			[127, 'MECAN SUP - PREPARER LES MAINTENANCES', 'PREPARER LES MAINTENANCES'],
			[128, 'MECAN ELEM - MAINTENANCE ELEMENTAIRE MECANIQUE ', 'EFFECTUER LA MAINTENANCE ELEMENTAIRE MECANIQUE '],
			[130, 'LAS GE SUP - PREPARER LES MAINTENANCES', 'PREPARER LES MAINTENANCES'],
			[131, 'LAS GE SUP - DIAGNOSTIQUER UNE PANNE', 'DIAGNOSTIQUER UNE PANNE'],
			[132, 'LAS GE SUP - ASSURER LA DISPONIBILITE DU MATERIEL', 'ASSURER LA DISPONIBILITE DU MATERIEL'],
			[133, 'LAS GE SUP - ASSURER LE SUIVI LOGISTIQUE', 'ASSURER LE SUIVI LOGISTIQUE'],
			[134, 'LAS GE OP - EXPLOITER LE SYSTEME SIC21 ', 'EXPLOITER LE SYSTEME SIC21 '],
			[135, 'LAS GE OP - METTRE EN ŒUVRE LES EQUIPEMENTS GE', 'METTRE EN ŒUVRE LES EQUIPEMENTS GE'],
			[136, 'LAS GE - PARAMETRER ESM', 'PARAMETRER ESM'],
			[137, 'LAS GE - REAGIR FACE A UNE MENACE ', 'REAGIR FACE A UNE MENACE '],
			[138, 'LAS GE OP - ELABORER, PRESENTER ET DIFFUSER UNE SITUATION GE ', 'ELABORER, PRESENTER ET DIFFUSER UNE SITUATION GE '],
			[139, 'LAS GE OP - EXPLOITER ESM ', 'EXPLOITER ESM '],
			[140, 'LAS GE OP - EXPLOITER LES CONSOLES OPERATIONNELLES', 'EXPLOITER LES CONSOLES OPERATIONNELLES'],
			[141, 'LAS GE OP - COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[142, 'LAS GE OP - UTILISATION  DE LA BASE DE DONNEES GE', 'UTILISATION  DE LA BASE DE DONNEES GE'],
			[143, 'LAS GE OP - CONNAISSANCE DES BASES DE LA GE', 'CONNAISSANCE DES BASES DE LA GE'],
			[144, 'LAS GE OP - FONCTIONNEMENT THEORIQUE D\'UN RADAR', 'FONCTIONNEMENT THEORIQUE D\'UN RADAR'],
			[145, 'LAS GE OP - CHARGER LES AFFUTS DLS', 'CHARGER LES AFFUTS DLS'],
			[146, 'LAS GE OP - TRANSPORTER DES MUNITIONS GE', 'TRANSPORTER DES MUNITIONS GE DE LA SOUTE PRINCIPALE VERS LA SOUTE RELAIS'],
			[147, 'LAS GE AGE - ASSURER LE ROLE DE EWC', 'ASSURER LE ROLE DE EWC'],
			[148, 'LAS GE AGE - ELABORER, PRESENTER ET DIFFUSER UNE SITUATION GE', 'ELABORER, PRESENTER ET DIFFUSER UNE SITUATION GE'],
			[149, 'LAS GE AGE - EXPLOITER ESM ', 'EXPLOITER ESM '],
			[150, 'LAS GE AGE - EXPLOITER LES CONSOLES OPERATIONNELLES ', 'EXPLOITER LES CONSOLES OPERATIONNELLES '],
			[161, 'CROWN - EXPLOITER LES CONSOLES OPERATIONNELLES', 'EXPLOITER LES CONSOLES OPERATIONNELLES'],
			[152, 'LAS GE AGE - EXPLOITER LE SYSTEME SIC2', 'EXPLOITER LE SYSTEME SIC21 [AGE]'],
			[153, 'LAS GE AGE - EXPLOITER L\'EWSS', 'EXPLOITER L\'EWSS'],
			[154, 'LAS GE AGE - GERER LA DISCRETION EM DU BATIMENT', 'GERER LA DISCRETION EM DU BATIMENT'],
			[155, 'LAS GE AGE - METTRE EN OEUVRE LES EQUIPEMENTS GE', 'METTRE EN OEUVRE LES EQUIPEMENTS GE'],
			[160, 'CROWN - EXPLOITER LA MESSAGERIE DEDIEE AUX OPERATIONS', 'EXPLOITER LA MESSAGERIE DEDIEE AUX OPERATIONS'],
			[158, 'LAS GE AGE - CONDUIRE UN ENGAGEMENT GE', 'CONDUIRE UN ENGAGEMENT GE'],
			[159, 'LAS GE AGE - PARAMETRER L\'EWSS', 'PARAMETRER L\'EWSS'],
			[162, 'CROWN - EXPLOITER LES MOYENS DE COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[163, 'CROWN - EXPLOITER LE SYSTEME SIC21 ', 'EXPLOITER LE SYSTEME SIC21 '],
			[164, 'CROWN - X CROWN', 'X CROWN'],
			[165, 'LAS SURVAIR - APPLIQUER LA PROCEDURE', 'APPLIQUER LA PROCEDURE'],
			[166, 'LAS SURVAIR - SUPERVISER LE CMS', 'SUPERVISER LE CMS'],
			[167, 'LAS SURVAIR - EXPLOITER LES MODES AIR DU RADAR HERAKLES', 'EXPLOITER LES MODES AIR DU RADAR HERAKLES'],
			[168, 'LAS SURVAIR - EXPLOITER MATERIELS SDV', 'EXPLOITER LE MATERIELS SATELITE DU MODULE SDV'],
			[169, 'LAS SURVAIR - COMPLEMENT AAD', 'COMPLEMENT AAD'],
			[170, 'LAS SDV - APPLIQUER LA PROCEDURE', 'APPLIQUER LA PROCEDURE'],
			[171, 'LAS SDV - DIRIGER LA VEILLE', 'DIRIGER LA VEILLE'],
			[172, 'LAS SDV - EFFECTUER LA VEILLE AIR ET SURFACE', 'EFFECTUER LA VEILLE AIR ET SURFACE'],
			[173, 'LAS SDV - EXPLOITER LA DOCUMENTATION OPERATIONNELLE', 'EXPLOITER LA DOCUMENTATION OPERATIONNELLE'],
			[174, 'LAS SDV - EXPLOITER LES CONSOLES OPERATIONNELLES', 'EXPLOITER LES CONSOLES OPERATIONNELLES'],
			[175, 'LAS BUROPS - DIFFUSER LA DOCUMENTATION OPERATIONNELLE', 'DIFFUSER LA DOCUMENTATION OPERATIONNELLE'],
			[176, 'LAS BUROPS - DIRIGER LE BUROPS', 'DIRIGER LE BUROPS'],
			[177, 'LAS BUROPS - EXPLOITER LE SYSTEME SIC21', 'EXPLOITER LE SYSTEME SIC21 [BUROPS]'],
			[178, 'LAS BUROPS - EXPLOITER LES CONSOLES OPERATIONNELLES [OQEM]', 'EXPLOITER LES CONSOLES OPERATIONNELLES [OQEM]'],
			[179, 'LAS BUROPS - COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS [Chef BUROPS]'],
			[180, 'LAS DEM ELEM - ASSURER LA DISPONIBILITE DU MATERIEL', 'ASSURER LA DISPONIBILITE DU MATERIEL'],
			[181, 'LAS DEM SUP - PREPARER LES MAINTENANCES', 'PREPARER LES MAINTENANCES'],
			[182, 'LAS DEM SUP - DIAGNOSTIQUER UNE PANNE [DEM]', 'DIAGNOSTIQUER UNE PANNE [DEM]'],
			[183, 'LAS DEM SUP - ASSURER LA DISPONIBILITE DU MATERIEL', 'ASSURER LA DISPONIBILITE DU MATERIEL [DEM SUP]'],
			[184, 'LAS DEM SUP - MAINTENIR LE MATERIEL EN CONDITION OPERATIONNELLE', 'MAINTENIR LE MATERIEL EN CONDITION OPERATIONNELLE'],
			[185, 'LAS SURVSURF - DIRIGER LA VEILLE', 'DIRIGER LA VEILLE'],
			[186, 'LAS SURVSURF - EFFECTUER LA VEILLE AIR ET SURFACE', 'EFFECTUER LA VEILLE AIR ET SURFACE'],
			[187, 'LAS SURVSURF - EXPLOTER LA DOCUMENTATION OPERATIONNELLE', 'EXPLOTER LA DOCUMENTATION OPERATIONNELLE'],
			[188, 'LAS SURVSURF - EXPLOITER LES CONSOLES OPERATIONNELLES', 'EXPLOITER LES CONSOLES OPERATIONNELLES'],
			[189, 'LAS SURVSURF - EXPLOITER LE SYSTÈME SIC 21', 'EXPLOITER LE SYSTÈME SIC 21'],
			[190, 'LAS SURVSURF - OPTIMISER L\'EMPLOI DES SENSEURS DE VEILLE', 'OPTIMISER L\'EMPLOI DES SENSEURS DE VEILLE'],
			[191, 'LAS SURVSURF - REAGIR FACE A UNE MENACE', 'REAGIR FACE A UNE MENACE'],
			[192, 'LAS SURVSURF - EXPLOITER LES MOYENS DE COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[193, 'LAS SURVSURF - EXPLOITER LE MATERIELS SATELITE DU MODULE SURV', 'EXPLOITER LE MATERIELS SATELITE DU MODULE SURV'],
			[194, 'LAS OINFO - EXPLOITER LA MESSAGERIE DEDIEE AUX OPERATIONS', 'EXPLOITER LA MESSAGERIE DEDIEE AUX OPERATIONS'],
			[195, 'LAS OINFO - EXPLOITER LES CONSOLES OPERATIONNELLES', 'EXPLOITER LES CONSOLES OPERATIONNELLES'],
			[196, 'LAS OINFO - SUPERVISER LE CMS', 'SUPERVISER LE CMS'],
			[197, 'LAS OINFO - EXPLOITER LES MOYENS DE COMMUNICATIONS', 'EXPLOITER LES MOYENS DE COMMUNICATIONS'],
			[198, 'LAS OINFO - EXPLOITER LE SYSTEME SIC21', 'EXPLOITER LE SYSTEME SIC21'],
			[199, 'LAS OINFO - EXPLOITER LES LDT', 'EXPLOITER LES LDT'],
			[200, 'LAS OINFO - MANAGER LES LDT', 'MANAGER LES LDT'],
			[201, 'LAS OINFO - PRESENTER UNE SITUATION TACTIQUE COMPLETE ET UNIQUE', 'PRESENTER UNE SITUATION TACTIQUE COMPLETE ET UNIQUE'],
			[202, 'LAS OINFO - REAGIR FACE A UNE MENACE', 'REAGIR FACE A UNE MENACE'],
			[203, 'LAS MFC', 'EXPLOITER LA CONSOLE'],
			[204, 'ELEC SUP - PREPARER LES MAINTENANCES', 'PREPARER LES MAINTENANCES'],
			[205, 'ELEC SUP - ASSURER LE SUIVI LOGISTIQUE', 'ASSURER LE SUIVI LOGISTIQUE'],
			[206, 'ELEC SUP - DIAGNOSTIQUER UNE PANNE ELECT', 'DIAGNOSTIQUER UNE PANNE ELECT'],
			[207, 'ELEC SUP - RACCORDEMENT OU DEBRANCHEMENT DU BORD A QUAI', 'PROCEDER AU RACCORDEMENT OU DEBRANCHEMENT DU BORD A QUAI'],
			[208, 'ELEC SUP - EFFECTUER LA MAINTENANCE ELECT', 'EFFECTUER LA MAINTENANCE ELECT'],
			[209, 'ELEC ELEM - MAINTENANCE ET CONDUITE ELEMENTAIRE SECTEUR EXTERIEUR', 'MAINTENANCE ET CONDUITE ELEMENTAIRE SECTEUR EXTERIEUR'],
			[210, 'ELEC ELEM - MAINTENANCE ET CONDUITE ELEMENTAIRE SECTEUR CONTCO', 'MAINTENANCE ET CONDUITE ELEMENTAIRE SECTEUR CONTCO'],
			[211, 'ELEC ELEM - DIAGNOSTIQUER UNE PANNE ELEMENTAIRE ELEC', 'DIAGNOSTIQUER UNE PANNE ELEMENTAIRE ELEC'],
			[212, 'ELEC ELEM - COMPTE RENDU D’AVARIE', 'COMPTE RENDU D’AVARIE'],
			[213, 'ELEC ELEM - EFFECTUER UNE MAINTENANCE ELEMENTAIRE', 'EFFECTUER UNE MAINTENANCE ELEMENTAIRE'],
			[214, 'ELEC ELEM - PROCEDER AU RACCORDEMENT OU DEBRANCHEMENT DU BORD A QUAI', 'PROCEDER AU RACCORDEMENT OU DEBRANCHEMENT DU BORD A QUAI'],
			[215, 'ELEC ELEM - UTILISATION DU MATERIEL ELECT', 'UTILISATION DU MATERIEL ELECT'],
			[216, 'ELEC ELEM - EFFECTUER DU QUART A LA MER AU PC MES', 'EFFECTUER DU QUART A LA MER AU PC MES LORS D\'UN POSTE DE MANŒUVRE, SA2 ou SA3'],
			[217, 'ELEC ELEM - VOLTIGEUR', 'VOLTIGEUR'],
			[218, 'ELEC ELEM - UTILISER LE DCTMAT  ', 'UTILISER LE DCTMAT  '],
			[219, 'ELEC ELEM - CONSIGNATION', 'CONSIGNATION'],
			[220, 'ELEC PROPAUX - METTRE EN OEUVRE LE PROPULSEUR AUXILAIRE', 'METTRE EN OEUVRE LE PROPULSEUR AUXILAIRE'],
			[221, 'ELEC CYBER - ETRE SENSIBILISE AU RISQUE CYBER DU DOMAINE ELEC', 'ETRE SENSIBILISE AU RISQUE CYBER DU DOMAINE ELEC'],
			[222, 'SECU ELEM - EFFECTUER LA MAINTENANCE ELEMENTAIRE SECU', 'EFFECTUER LA MAINTENANCE ELEMENTAIRE SECU'],
			[223, 'SECU SUP - PREPARER LES MAINTENANCES', 'PREPARER LES MAINTENANCES'],
			[224, 'SECU SUP - ASSURER LE SUIVI LOGISTIQUE', 'ASSURER LE SUIVI LOGISTIQUE'],
			[225, 'SECU SUP - DIAGNOSTIQUER UNE PANNE SECU', 'DIAGNOSTIQUER UNE PANNE SECU'],
			[226, 'SECU SUP - EFFECTUER LA MAINTENANCE SECU', 'EFFECTUER LA MAINTENANCE SECU'],
			[227, 'METTRE EN OEUVRE LES PORTES DE BORDEE', 'METTRE EN OEUVRE LES PORTES DE BORDEE'],
			[228, 'LSM ARM - METTRE EN OEUVRE LES LEURRES ASM', 'METTRE EN OEUVRE LES LEURRES ASM'],
			[229, 'LSM ARM - EMBARQUER/DEBARQUER UNE TORPILLE', 'EMBARQUER/DEBARQUER UNE TORPILLE'],
			[230, 'LSM ARM - METTRE A POSTE UNE TORPILLE', 'METTRE A POSTE UNE TORPILLE'],
			[231, 'CASM - CONSEILLER L\'OLASM DANS LA MISE EN ŒUVRE DU SONAR PASSIF', 'CONSEILLER L\'OLASM DANS LA MISE EN ŒUVRE DU SONAR PASSIF'],
			[232, 'CASM - CONSEILLER L\'OLASM DANS LES DOMAINES TECHNIQUE ET TACTIQUE', 'CONSEILLER L\'OLASM DANS LES DOMAINES TECHNIQUE ET TACTIQUE'],
			[233, 'CASM - CONTROLER LES PROCEDURES DE SECURITE ASM', 'CONTROLER LES PROCEDURES DE SECURITE ASM'],
			[234, 'CASM - DONNER DES DIRECTIVES DE VEILLE AUX OPERATEURS SONAR', 'DONNER DES DIRECTIVES DE VEILLE AUX OPERATEURS SONAR'],
			[235, 'CASM - EFFECTUER UN LANCEMENT TORPILE', 'EFFECTUER UN LANCEMENT TORPILE'],
			[236, 'CASM - METTRE EN ŒUVRE LE SYSTEME DE LEURRES ASM', 'METTRE EN ŒUVRE LE SYSTEME DE LEURRES ASM'],
			[237, 'CASM - METTRE EN ŒUVRE LE TUUM', 'METTRE EN ŒUVRE LE TUUM'],
			[238, 'CASM - METTRE EN ŒUVRE L\'ENSEMBLE DES ENGINS REMORQUES', 'METTRE EN ŒUVRE L\'ENSEMBLE DES ENGINS REMORQUES'],
			[239, 'CASM - UTILISER LA MFC ROLE CASM', 'UTILISER LA MFC ROLE CASM'],
			[240, 'CASM - EXPLOITER LE MODULE METIER GESTION DE L\'ESPACE MARITIME', 'EXPLOITER LE MODULE METIER GESTION DE L\'ESPACE MARITIME'],
			[241, 'CASM - METTRE EN ŒUVRE LES INSTALLATIONS TORPILLES', 'METTRE EN ŒUVRE LES INSTALLATIONS TORPILLES'],
			[242, 'CASM - EXPLOITER LA CHAINE ASBA NG', 'EXPLOITER LA CHAINE ASBA NG'],
			[243, 'CASM - METTRE EN ŒUVRE LA CIBLE ASM', 'METTRE EN ŒUVRE LA CIBLE ASM']
		];
		foreach ($records as $record){
			DB::insert('insert into taches (id, tache_libcourt, tache_liblong) values (?, ?, ?)', $record);
		}
    }
}
