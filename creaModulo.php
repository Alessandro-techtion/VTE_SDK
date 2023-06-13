<?php
    require('../../config.inc.php');
    chdir($root_directory);
    require_once('include/utils/utils.php');
    include_once('vtlib/Vtecrm/Access.php');
    require_once('modules/Update/Update.php'); 
    require_once('vtlib/Vtecrm/Module.php');
    include_once('vtlib/Vtecrm/Block.php');
    include_once('vtlib/Vtecrm/Field.php');
    include_once('vtlib/Vtecrm/Filter.php');
    include_once('vtlib/Vtecrm/Menu.php');
    include_once('vtlib/Vtecrm/Link.php');
    include_once('vtlib/Vtecrm/Event.php');
    include_once('vtlib/Vtecrm/Version.php');
    include_once('vtlib/Vtecrm/Profile.php');

    $vtlib_Utils_Log = true;
    global $adb, $table_prefix;

    //avvia una sessione per l'applicazione.
    VteSession::start();
    
    //imposta il nome del modulo a "Macchine"
    $moduleName='Macchine';
    //tenta di ottenere un'istanza del modulo "Macchine" dall'applicazione.
    $module= Vtecrm_Module::getInstance($moduleName);

    if(!$module){
        
        //Viene creato un nuovo oggetto di modulo utilizzando
        $module = new Vtecrm_Module();
        //Il nome del modulo viene impostato su "Macchine" utilizzando 
        $module->name = $moduleName;
        //Il modulo viene salvato
        $module->save();
        //Viene inizializzato il servizio Web del modulo utilizzando 
        $module->initWebservice();
        //Vengono inizializzate le tabelle del modulo utilizzando
        $module->initTables();
        //Viene impostata la condivisione predefinita del modulo
        $module->setDefaultSharing('Public_ReadWriteDelete');
        //Vengono abilitati alcuni strumenti per il modulo (Import, Export, Merge)
        $module->enableTools(Array('Import','Export','Merge'));
        //Viene ottenuto un'istanza del menu "Inventory" utilizzando
        $menu = Vtecrm_Menu::getInstance('Inventory');
        //il modulo viene aggiunto al menu utilizzando
        $menu->addModule($module);
        
        //imposta le voci di lingua per il modulo "Macchine". Viene specificato il nome del modulo ("Macchine") e viene fornito un array che associa le 
        //traduzioni alle lingue specificate. In questo caso, le traduzioni sono impostate come "Macchine" per l'italiano (it_it) e "Machines" per l'inglese (en_us).
        SDK::setLanguageEntries($module->name, 'Macchine', array('it_it'=>'Macchine','en_us'=>'Machines'));
        //imposta le voci di lingua per il singolo record del modulo "Macchine"
        SDK::setLanguageEntries($module->name, 'SINGLE_Macchine', array('it_it'=>'Macchina','en_us'=>'Machine'));
        
        //La riga seguente dichiara un array $panels che contiene un singolo elemento. L'elemento rappresenta un pannello del modulo "Macchine" 
        $panels = array(
            array('module'=>$moduleName, 'label'=>'Macchine')
        );
        
        //chiama il metodo create_panels della classe Update e passa l'array $panels come argomento. 
        //Questo metodo crea i pannelli definiti nell'array nel modulo corrente ("Macchine")
        Update::create_panels($panels);
        
        //crea un nuovo oggetto di blocco 
        $block = new Vtecrm_Block();
        //imposta l'etichetta del blocco come 'LBL_MACCHINE_INFORMATION'.
        $block->label = 'LBL_MACCHINE_INFORMATION';
        //aggiunge il blocco al modulo corrente.
        $module->addBlock($block);
        SDK::setLanguageEntries($module->name, $block->label, array('it_it'=>'Informazioni Macchina','en_us'=>'Machine Details'));

        $block2 = new Vtecrm_Block();
        $block2->label = 'LBL_CUSTOM_INFORMATION';
        $module->addBlock($block2);

        $block3 = new Vtecrm_Block();
        $block3->label = 'LBL_DESCRIPTION_INFORMATION';
        $module->addBlock($block3);
        
        //crea un nuovo oggetto di campo 
        $field = new Vtecrm_Field();
        $field->name = 'numero_macchina';
        $field->table = $module->basetable;
        $field->label = 'Numero macchina';
        $field->columntype = 'C(100)';
        $field->uitype = 4;
        $field->typeofdata = 'V~O';
        $field->quickcreate = 0;
        //aggiunge il campo al primo blocco creato in precedenza.
        $block->addField($field);
        //imposta il campo come identificatore dell'entità nel modulo.
        $module->setEntityIdentifier($field);

        $field2 = new Vtecrm_field();
        $field2->name = 'codice_seriale';
        $field2->table = $module->basetable;
        $field2->label = 'Codice seriale';
        $field2->columntype = 'C(255)';
        $field2->uitype = 1;
        $field2->typeofdata = 'V~M';
        $field2->quickcreate = 0;
        $block->addField($field2);

        $field3 = new Vtecrm_Field();
        $field3->name = 'description';
        $field3->table = $table_prefix.'_crmentity';
        $field3->label = 'Description';
        $field3->uitype = 19;
        $field3->typeofdata = 'V~O';
        $block3->addField($field3);

        $field4 = new Vtecrm_Field();
        $field4->name = 'marca';
        $field4->table = $module->basetable;
        $field4->label = 'Marca';
        $field4->columntype = 'C(255)';
        $field4->uitype = 1;
        $field4->typeofdata = 'V~O';
        $field4->quickcreate = 0;
        $block->addField($field4);

        $field5 = new Vtecrm_Field();
        $field5->name = 'modello';
        $field5->table = $module->basetable;
        $field5->label = 'Modello';
        $field5->columntype = 'C(255)';
        $field5->uitype = 1;
        $field5->typeofdata = 'V~O';
        $field5->quickcreate = 0;
        $block->addField($field5);
        
        //Campo obbligatorio
        $field6 = new Vtecrm_Field();
        $field6->name = 'assigned_user_id';
        $field6->table = $table_prefix.'_crmentity';
        $field6->label = 'Assigned To';
        $field6->column = 'smownerid';
        $field6->uitype = 53;
        $field6->quickcreate = 0;
        $field6->typeofdata = 'V~M';
        $block->addField($field6);

        //Campo obbligatorio
        $field7 = new Vtecrm_Field();
        $field7->name = 'createdtime';
        $field7->table = $table_prefix.'_crmentity';
        $field7->label = 'Created Time';
        $field7->column = 'createdtime';
        $field7->uitype = 70;
        $field7->displaytype = 2;
        $field7->typeofdata = 'T~O';
        $block->addField($field7);
        
        //Campo obbligatorio
        $field8 = new Vtecrm_Field();
        $field8->name = 'modifiedtime';
        $field8->table = $table_prefix.'_crmentity';
        $field8->label = 'Modified Time';
        $field8->column = 'modifiedtime';
        $field8->uitype = 70;
        $field8->displaytype = 2;
        $field8->typeofdata = 'T~O';
        $block->addField($field8);

        $module = Vtecrm_Module::getInstance($moduleName);
        
        //crea un nuovo oggetto di filtro 
        $filter =  new Vtecrm_Filter();
        //imposta il nome del filtro come 'All'.
        $filter->name = 'All';
        //imposta il filtro come predefinito
        $filter->isdefault = true;
        //aggiunge il filtro al modulo corrente.
        $module->addFilter($filter);
        
        //aggiunge il campo $field con un indice di ordinamento 1 al filtro.
        $filter->addField($field, 1);
        $filter->addField($field2, 2);
        $filter->addField($field4, 3);
        $filter->addField($field5, 4);
        $filter->addField($field6, 5);

    }

    $moduleName='Accessori';
    $module= Vtecrm_Module::getInstance($moduleName);

    if(!$module){
        $module = new Vtecrm_Module();
        $module->name = $moduleName;
        $module->save();
        $module->initWebservice();
        $module->initTables();
        $module->setDefaultSharing('Public_ReadWriteDelete');
        $module->enableTools(Array('Import','Export','Merge'));
        
        $menu = Vtecrm_Menu::getInstance('Inventory');
        $menu->addModule($module);
  
        SDK::setLanguageEntries($module->name, 'Accessori', array('it_it'=>'Accessori','en_us'=>'Accessories'));
        SDK::setLanguageEntries($module->name, 'SINGLE_Accessori', array('it_it'=>'Accessorio','en_us'=>'Accessory'));
        
        $panels = array(
            array('module'=>$moduleName, 'label'=>'Accessori')
        );
        Update::create_panels($panels);
       
  
        $block = new Vtecrm_Block();
        $block->label = 'LBL_ACCESSORI_INFORMATION';
        $module->addBlock($block);
        SDK::setLanguageEntries($module->name, $block->label, array('it_it'=>'Dettagli Accessori','en_us'=>'Accessories Details'));
  
        $block2 = new Vtecrm_Block();
        $block2->label = 'LBL_CUSTOM_INFORMATION';
        $module->addBlock($block2);
  
        $block3 = new Vtecrm_Block();
        $block3->label = 'LBL_DESCRIPTION_INFORMATION';
        $module->addBlock($block3);

        $field = new Vtecrm_Field();
        $field->name = 'numero_accessorio';
        $field->table = $module->basetable;
        $field->label = 'Numero accessorio';
        $field->columntype = 'C(100)';
        $field->uitype = 4;
        $field->typeofdata = 'V~O';
        $field->quickcreate = 0;
        $block->addField($field);

        $field2 = new Vtecrm_Field();
        $field2->name = 'codice_accessorio';
        $field2->table = $module->basetable;
        $field2->label = 'Codice Accessorio';
        $field2->columntype = 'C(255)';
        $field2->displaytype = 1;
        $field2->uitype = 1;
        $field2->typeofdata = 'V~M';
        $field2->quickcreate = 0;
        $block->addField($field2);
        $module->setEntityIdentifier($field2);

        $field3 = new Vtecrm_Field();
        $field3->name = 'accessorio';
        $field3->table = $module->basetable;
        $field3->label = 'Accessorio';
        $field3->columntype = 'C(255)';
        $field3->displaytype = 1;
        $field3->uitype = 1;
        $field3->typeofdata = 'V~M';
        $field3->quickcreate = 0;
        $block->addField($field3);

        $field4 = new Vtecrm_Field();
        $field4->name = 'description';
        $field4->table = $table_prefix.'_crmentity';
        $field4->label = 'Description';
        $field4->uitype = 19;
        $field4->typeofdata = 'V~O';
        $block3->addField($field4);

        $field5 = new Vtecrm_Field();
        $field5->name = 'assigned_user_id';
        $field5->table = $table_prefix.'_crmentity';
        $field5->label = 'Assigned To';
        $field5->column = 'smownerid';
        $field5->uitype = 53;
        $field5->quickcreate = 0;
        $field5->typeofdata = 'V~M';
        $block->addField($field5);

        $field6 = new Vtecrm_Field();
        $field6->name = 'createdtime';
        $field6->table = $table_prefix.'_crmentity';
        $field6->label = 'Created Time';
        $field6->column = 'createdtime';
        $field6->uitype = 70;
        $field6->displaytype = 2;
        $field6->typeofdata = 'T~O';
        $block->addField($field6);

        $field7= new Vtecrm_Field();
        $field7->name = 'modifiedtime';
        $field7->table = $table_prefix.'_crmentity';
        $field7->label = 'Modified Time';
        $field7->column = 'modifiedtime';
        $field7->uitype = 70;
        $field7->displaytype = 2;
        $field7->typeofdata = 'T~O';
        $block->addField($field7);

        $module= Vtecrm_Module::getInstance($moduleName);

        $filter =  new Vtecrm_Filter();
        $filter->name = 'All';
        $filter->isdefault = true;
        $module->addFilter($filter);

        $filter->addField($field, 1);
        $filter->addField($field2, 2);
        $filter->addField($field3, 3);
        $filter->addField($field5, 4);	

    }

    $moduleName='MacchineClienti';
    $module= Vtecrm_Module::getInstance($moduleName);

    if(!$module){
        $module = new Vtecrm_Module();
        $module->name = $moduleName;
        $module->save();
        $module->initWebservice();
        $module->initTables();
        $module->setDefaultSharing('Public_ReadWriteDelete');
        $module->enableTools(Array('Import','Export','Merge'));
        
        $menu = Vtecrm_Menu::getInstance('Inventory');
        $menu->addModule($module);

        SDK::setLanguageEntries($module->name, 'MacchineClienti', array('it_it'=>'Macchine Clienti','en_us'=>'Customer Machines'));
        SDK::setLanguageEntries($module->name, 'SINGLE_MacchineClienti', array('it_it'=>'Macchina Cliente','en_us'=>'Customer Machine'));
        
        $panels = array(
            array('module'=>$moduleName, 'label'=>'Macchine Clienti')
        );
        Update::create_panels($panels);
        
        $block = new Vtecrm_Block();
        $block->label = 'LBL_MACCHINE_CLIENTI_INFORMATION';
        $module->addBlock($block);
        SDK::setLanguageEntries($module->name, $block->label, array('it_it'=>'Informazioni Macchina Cliente','en_us'=>'Customer Machines Details'));

        $block2 = new Vtecrm_Block();
        $block2->label = 'LBL_CUSTOM_INFORMATION';
        $module->addBlock($block2);

        $block3 = new Vtecrm_Block();
        $block3->label = 'LBL_DESCRIPTION_INFORMATION';
        $module->addBlock($block3);

        $field = new Vtecrm_Field();
        $field->name = 'numero_macchina_cliente';
        $field->table = $module->basetable;
        $field->label = 'Numero macchina cliente';
        $field->columntype = 'C(100)';
        $field->uitype = 4;
        $field->typeofdata = 'V~O';
        $field->quickcreate = 0;
        $block->addField($field);
        $module->setEntityIdentifier($field);

        $field2 = new Vtecrm_Field();
        $field2->name = 'macchine_id';
        $field2->table = $module->basetable;
        $field2->label = 'Macchina';
        $field2->column = 'macchineid';
        $field2->columntype = 'I(19)';
        $field2->uitype = 10;
        $field2->typeofdata = 'I~M';
        $field2->displaytype = 1;
        $field2->helpinfo = 'Seleziona una macchina esistente';
        $field2->quickcreate = 0;
        $block->addField($field2);
        $field2->setRelatedModules(Array('Macchine'));

        $field3 = new Vtecrm_Field();
        $field3->name = 'data_installazione';
        $field3->table = $module->basetable;
        $field3->label = 'Data installazione';
        $field3->columntype = 'D';
        $field3->uitype = 5;
        $field3->typeofdata = 'D~O';
        $block->addField($field3);

        $field4 = new Vtecrm_Field();
        $field4->name = 'account_id';
        $field4->table = $module->basetable;
        $field4->label = 'Azienda';
        $field4->column = 'accountid';
        $field4->columntype = 'I(19)';
        $field4->uitype = 10;
        $field4->typeofdata = 'I~M';
        $field4->displaytype = 1;
        $field4->helpinfo = 'Seleziona una azienda esistente';
        $field4->quickcreate = 0;
        $block->addField($field4);
        $field4->setRelatedModules(Array('Accounts'));
        $module->setEntityIdentifier($field4);

        $field5 = new Vtecrm_Field();
        $field5->name = 'assigned_user_id';
        $field5->table = $table_prefix.'_crmentity';
        $field5->label = 'Assigned To';
        $field5->column = 'smownerid';
        $field5->uitype = 53;
        $field5->quickcreate = 0;
        $field5->typeofdata = 'V~M';
        $block->addField($field5);

        $field6 = new Vtecrm_Field();
        $field6->name = 'createdtime';
        $field6->table = $table_prefix.'_crmentity';
        $field6->label = 'Created Time';
        $field6->column = 'createdtime';
        $field6->uitype = 70;
        $field6->displaytype = 2;
        $field6->typeofdata = 'T~O';
        $block->addField($field6);

        $field7 = new Vtecrm_Field();
        $field7->name = 'modifiedtime';
        $field7->table = $table_prefix.'_crmentity';
        $field7->label = 'Modified Time';
        $field7->column = 'modifiedtime';
        $field7->uitype = 70;
        $field7->displaytype = 2;
        $field7->typeofdata = 'T~O';
        $block->addField($field7);

        $module= Vtecrm_Module::getInstance($moduleName);

        $filter =  new Vtecrm_Filter();
        $filter->name = 'All';
        $filter->isdefault = true;
        $module->addFilter($filter);

        $filter->addField($field, 1);
        $filter->addField($field2, 2);
        $filter->addField($field3, 3);
        $filter->addField($field4, 4);
        $filter->addField($field5, 5);

        //Relazione Calendario
        $calendar_instance = Vtecrm_Module::getInstance(9);
        $events_instance = Vtecrm_Module::getInstance(16);
        $field_instance = Vtecrm_Field::getInstance('parent_id',$calendar_instance);
        $field_instance->setRelatedModules(Array($moduleName));
        $field_instance1 = Vtecrm_Field::getInstance('parent_id',$events_instance);
        $field_instance1->setRelatedModules(Array($moduleName));
        $module->setRelatedList($calendar_instance, 'Activities', Array('ADD'), 'get_activities');

        //Relazione Ticket Cliente
        $module = Vtecrm_Module::getInstance('MacchineClienti');
        $helpHeskInstance = Vtecrm_Module::getInstance('HelpDesk');
        $relationLabel = 'Assistenza Clienti';
        $module->setRelatedList(
            $helpHeskInstance, $relationLabel, Array('ADD','SELECT','get_related_list')
        );
        
        //Relazione Accessori
        $module = Vtecrm_Module::getInstance('MacchineClienti');
        $helpHeskInstance = Vtecrm_Module::getInstance('Accessori');
        $relationLabel = 'Accessori';
        $module->setRelatedList(
            $helpHeskInstance, $relationLabel, Array('ADD','SELECT','get_related_list')
        );
    }
    echo 'Eseguito correttamente!\n';

    /*$module=Vtecrm_Module::getInstance('HelpDesk');
    $blockInstance=Vtecrm_Block::getInstance('LBL_TICKET_INFORMATION',$module);
    $fieldInstance = new Vtecrm_Field();
    $fieldInstance->name = 'numero_macchina_cliente';
    $fieldInstance->table = $module->basetable;
    $fieldInstance->label= 'Macchina Cliente';
    $fieldInstance->column = 'macchineclientiid';
    $fieldInstance->uitype = 10;
    $fieldInstance->columntype = 'I(19)';
    $fieldInstance->typeofdata = 'I~O';
    $fieldInstance->displaytype= 1;
    $fieldInstance->quickcreate = 0;
    $blockInstance->addField($fieldInstance);
    $fieldInstance->setRelatedModules(Array('MacchineClienti'));*/

?>
