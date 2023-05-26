<?php
/*************************************
 * SPDX-FileCopyrightText: 2009-2020 Vtenext S.r.l. <info@vtenext.com> 
 * SPDX-License-Identifier: AGPL-3.0-only  
 ************************************/

require('../../config.inc.php');
chdir($root_directory);
require_once('include/utils/utils.php');
require_once('vtlib/Vtecrm/Module.php');
include_once('vtlib/Vtecrm/Block.php');
include_once('vtlib/Vtecrm/Field.php');
include_once('vtlib/Vtecrm/Menu.php');
$vtlib_Utils_Log = true;
global $adb, $table_prefix;
VteSession::start();


      //CREAZIONE DI UN MODULO


  //Crea un'istanza della classe Vtecrm_Module.
  $moduleInstance = new Vtecrm_Module();
  //Imposta il nome del modulo come 'MacchineClienti'.
  $moduleInstance->name = 'MacchineClienti';
  //Salva l'istanza del modulo nel database.
  $moduleInstance->save();
  
  //Inizializza le tabelle del modulo nel database.
  $moduleInstance->initTables();
  //Ottiene un'istanza esistente del modulo 'ClientsMachine'.
  $moduleInstance = Vtecrm_Module::getInstance('MacchineClienti');
  //Ottiene un'istanza del menu 'Tools'.
  $menuInstance = Vtecrm_Menu::getInstance('Tools');
  //Aggiunge il modulo 'ClientsMachine' al menu.
  $menuInstance->addModule($moduleInstance);

  //Setto la lingua di come si vedrà a frontend 
  SDK::setLanguageEntries($moduleInstance->name, 'MacchineClienti', array('it_it'=>'Macchine Clienti','en_us'=>'Customer Machines'));


  $moduleInstance = Vtecrm_Module::getInstance('MacchineClienti');




        //CREAZIONE DEI PANNELLI NEL MODULO



  //Crea una nuova istanza della classe Vtecrm_Panel.
  $panelInstance = new Vtecrm_Panel();
  //Imposta l'etichetta del pannello come 'LBL_TAB_MAIN'.
  $panelInstance->label = 'LBL_MACCHINE_CLIENTI_MAIN';
  //Aggiunge il pannello appena creato all'istanza del modulo 'MacchineClienti'.
  $moduleInstance->addPanel($panelInstance);

  SDK::setLanguageEntries($module->name, $panelInstance->label, array('it_it'=>'Macchine Clienti','en_us'=>'Customer Machines'));





        //CREAZIONE DEI BLOCCHI NEL MODULO



  //Crea una nuova istanza della classe Vtecrm_Block.
  $blockInstance = new Vtecrm_Block();
  //Imposta l'etichetta del pannello come 'LBL_MacchineClienti_INFORMATION'
  $blockInstance->label = 'LBL_MacchineClienti_INFORMATION';
  //Aggiunge il blocco appena creato all'istanza del modulo.
  $moduleInstance->addBlock($blockInstance);

  //Setto la lingua del Blocco
  SDK::setLanguageEntries($module->name, $blockInstance->label, array('it_it'=>'Informazioni Macchine','en_us'=>'Machine information'));

  //Ottiene un'istanza esistente del blocco con l'etichetta 'LBL_InstalledBase_INFORMATION' all'interno dell'istanza del modulo 'InstalledBase'.
  $blockInstance=Vtecrm_Block::getInstance('LBL_MacchineClienti_INFORMATION',$moduleInstance);



        
        //CREAZIONE CAMPI




  //Crea una nuova istanza della classe Vtecrm_Field.
  $fieldInstance = new Vtecrm_Field();
  //Imposta il nome del campo come 'codice_seriale'.
  $fieldInstance->name = 'codice_seriale';
  //Specifica la tabella a cui il campo appartiene, nel caso specifico 'vte_macchineclienti'.
  $fieldInstance->table = 'vte_macchineclienti';
  //Specifico la colonna
  $fieldInstance->column = 'codice_seriale';
  //Imposta l'etichetta del campo come 'Codice Macchine Seriali'.
  $fieldInstance->label = 'Codice Macchine Seriali';
  //Specifica il tipo di colonna del campo come 'VARCHAR(255)'.
  $fieldInstance->columntype = 'VARCHAR(255)';
  //Specifica il tipo di interfaccia utente (uitype) del campo come 1, che indica un campo di ID.
  $fieldInstance->uitype = 4;
  //Specifica il tipo di dati del campo come 'V~M', che indica che il campo è un campo obbligatorio 
  $fieldInstance->typeofdata = 'V~M';
  //Imposta il flag 'quickcreate' del campo su 0, che indica che il campo non è disponibile nella creazione rapida.
  $fieldInstance->quickcreate = 0;
  //Aggiunge il campo appena creato al blocco.
  $blockInstance->addField($fieldInstance);
  SDK::setLanguageEntries($module->name, $fieldInstance->label, array('it_it'=>'Codice Macchine Seriali','en_us'=>'Serial Machine Code'));


  $fieldInstance2 = new Vtecrm_Field();
  $fieldInstance2->name = 'data_installazione';
  $fieldInstance2->table = 'vte_macchineclienti';
  $fieldInstance2->column = 'data_installazione';
  $fieldInstance2->label = 'Data Installazione';
  $fieldInstance2->columntype = 'DATE';
  $fieldInstance2->uitype = 5; // 5 rappresenta il campo di input per la data
  $fieldInstance2->typeofdata = 'D~O'; //typeofdata = 'V~O';  non obbligatorio, di tipo data
  $fieldInstance2->quickcreate = 0;
  $blockInstance->addField($fieldInstance2);
  SDK::setLanguageEntries($module->name, $fieldInstance2->label, array('it_it'=>'Data Installazione','en_us'=>'Date of installation'));


  $fieldInstance3 = new Vtecrm_Field();
  $fieldInstance3->name = 'azienda';
  $fieldInstance3->table = 'vte_macchineclienti';
  $fieldInstance3->column = 'azienda';
  $fieldInstance3->label = 'Azienda';
  $fieldInstance3->columntype = 'I(19)';
  $fieldInstance3->uitype = 10; // 10 rappresenta il campo di collegamento
  $fieldInstance3->typeofdata = 'V~O';
  $fieldInstance3->quickcreate = 0;
  $blockInstance->addField($fieldInstance3);
  $fieldInstance3->setRelatedModules(Array('Accounts')); //Relazioni il campo al modulo aziende
  SDK::setLanguageEntries($module->name, $fieldInstance3->label, array('it_it'=>'Azienda','en_us'=>'Account'));

 echo 'Fatto';