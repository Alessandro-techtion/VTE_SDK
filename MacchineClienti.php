<?php
/*+*************************************************************************************
 * The contents of this file are subject to the VTECRM License Agreement
 * ("licenza.txt"); You may not use this file except in compliance with the License
 * The Original Code is: VTECRM
 * The Initial Developer of the Original Code is VTECRM LTD.
 * Portions created by VTECRM LTD are Copyright (C) VTECRM LTD.
 * All Rights Reserved.
 ***************************************************************************************/
require_once('data/CRMEntity.php');
require_once('data/Tracker.php');

class MacchineClienti extends CRMEntity {
	//Vengono dichiarate due variabili, "$db" e "$log", che sembrano essere utilizzate nelle funzioni della classe "CRMEntity":
	var $db, $log; 

	#Vengono dichiarate alcune variabili per gestire le informazioni del database
	#tra cui il nome della tabella, l'indice della tabella, i campi della colonna:
	var $table_name;
	var $table_index= 'codice_serialeid';
	var $column_fields = Array();

	#Viene impostato il valore di "$IsCustomModule" su "true", indicando che questo 
	#è un modulo personalizzato anziché un modulo standard:
	var $IsCustomModule = true;

	#Viene definito un array vuoto "$customFieldTable". Utilizzato per supportare campi personalizzati:
	var $customFieldTable = Array();

	#Viene definito un array vuoto "$tab_name". 
	#Questo array è necessario per il salvataggio e include le tabelle correlate a questo modulo:
	var $tab_name = Array();

	#Viene definito un array vuoto "$tab_name_index". Questo array è necessario per il salvataggio e 
	#include il nome della tabella e la colonna della chiave di tabella:
	var $tab_name_index = Array();

	#Vengono definiti due array "$list_fields" e "$list_fields_name". Questi array sono 
	#necessari per la visualizzazione in elenco e contengono i campi da visualizzare nel modulo di elenco, insieme ai loro nomi di campo:
	var $list_fields = Array ();
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Codice Macchine Seriali'=> 'codice_seriale',
		'Data Installazione'=> 'data_installazione',
		'Azienda'=> 'azienda',
		'Assigned To' => 'assigned_user_id'
	);

	#Viene definita la variabile "$list_link_field" che specifica quale campo deve essere un link alla vista dettaglio dalla vista elenco. 
	#In questo caso, il campo "codice_seriale" viene utilizzato come link:
	var $list_link_field = 'codice_seriale';

	#Vengono definiti due array vuoti "$search_fields" e "$search_fields_name". Questi array sono necessari per 
	#il supporto della ricerca e contengono i campi che possono essere utilizzati per la ricerca nel modulo,
	var $search_fields = Array();
	var $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Codice Macchine Seriali'=> 'codice_seriale',
		'Data Installazione'=> 'data_installazione',
		'Azienda'=> 'azienda',
	);

	#Viene definito l'array "$popup_fields" che specifica i campi da visualizzare nella finestra popup per la selezione
	#dei record. In questo caso, viene specificato solo il campo "codice_seriale":
	var $popup_fields = Array('codice_seriale');

	#Viene definito l'array "$sortby_fields" come un array vuoto. Questo array verrà inizializzato per consentire la 
	#classificazione attraverso la funzione "initSortFields":
	var $sortby_fields = Array();

	#Viene specificato il campo di base per la ricerca alfabetica nel modulo con la variabile "$def_basicsearch_col". 
	#In questo caso, il campo "codice_seriale" è specificato come campo di base per la ricerca:
	var $def_basicsearch_col = 'codice_seriale';

	#Viene specificato il campo da utilizzare per visualizzare il testo del record nella vista dettaglio con la variabile "$def_detailview_recname". 
	#In questo caso, il campo "codice_seriale" è specificato come valore del campo da utilizzare:
	var $def_detailview_recname = 'codice_seriale';

	#Viene definito l'array "$required_fields" che specifica i campi obbligatori per il modulo. 
	#In questo caso, il campo "codice_seriale" è dichiarato come campo obbligatorio:
	var $required_fields = Array('codice_seriale'=>1);
	
	#Viene specificato l'ordine predefinito per l'elenco dei record con le variabili "$default_order_by" e "$default_sort_order". 
	#In questo caso, l'ordine predefinito è impostato sul campo "codice_seriale" in ordine ascendente:
	var $default_order_by = 'codice_seriale';
	var $default_sort_order='ASC';
	#Viene definito l'array "$mandatory_fields" che specifica i campi obbligatori per il modulo. 
	#Questi campi corrispondono ai valori dei campi "createdtime", "modifiedtime" e "codice_seriale" nel modulo:
	var $mandatory_fields = Array('createdtime', 'modifiedtime', 'codice_seriale');
	#Viene specificato il campo di base per la ricerca con la variabile "$search_base_field". 
	#In questo caso, viene specificato il campo "codice_seriale" come campo di base per la ricerca:
	var $search_base_field = 'codice_seriale';

	function __construct() {
		global $log, $table_prefix; // crmv@64542
		#Viene chiamato il costruttore della classe padre CRMEntity utilizzando parent::__construct(). 
		#Ciò assicura che il costruttore della classe padre venga eseguito prima del codice specifico della classe figlia:
		parent::__construct();
		#Viene impostato il nome della tabella utilizzando il prefisso della tabella ($table_prefix) e il suffisso '_codice_seriale':
		$this->table_name = $table_prefix.'_codice_seriale';

		#Viene impostato l'array $customFieldTable per supportare i campi personalizzati. L'array contiene il nome della tabella 
		#dei campi personalizzati ($table_prefix.'_codice_serialecf') e la colonna chiave della tabella ('codice_serialeid'):
		$this->customFieldTable = Array($table_prefix.'_codice_serialecf', 'codice_serialeid');
		$this->entity_table = $table_prefix."_crmentity";

		#Vengono impostati gli array $tab_name e $tab_name_index. Questi array definiscono le tabelle correlate al modulo e le colonne 
		#chiave delle rispettive tabelle. L'array $tab_name contiene le tabelle '_crmentity', 
		#'_codice_seriale' e '_codice_serialecf', mentre l'array $tab_name_index specifica le colonne chiave corrispondenti a ciascuna tabella:
		$this->tab_name = Array($table_prefix.'_crmentity', $table_prefix.'_codice_seriale', $table_prefix.'_codice_serialecf');
		$this->tab_name_index = Array(
			$table_prefix.'_crmentity' => 'crmid',
			$table_prefix.'_codice_seriale'   => 'codice_serialeid',
			$table_prefix.'_codice_serialecf' => 'codice_serialeid'
		);

		#Vengono impostati gli array $list_fields e $search_fields. Questi array definiscono i campi da visualizzare nel modulo 
		#di elenco e i campi utilizzati per la ricerca. Ogni elemento dell'array specifica il nome del campo e 
		#il suo rispettivo nome di tabella e colonna:
		$this->list_fields = Array(
			/* Format: Field Label => Array(tablename, columnname) */
			// tablename should not have prefix 'vte_'
			'Codice Macchine Seriali'=> Array($table_prefix.'_codice_seriale', 'codice_seriale'),
			'Data Installazione' => Array($table_prefix.'_crmentity','data_installazione'),
			'Azienda'=> Array($table_prefix.'_codice_seriale', 'azienda'),
			'Assigned To' => Array($table_prefix.'_crmentity','smownerid')
		);
		$this->search_fields = Array(
			/* Format: Field Label => Array(tablename, columnname) */
			// tablename should not have prefix 'vte_'
			'Codice Macchine Seriali'=> Array($table_prefix.'_codice_seriale', 'codice_seriale'),
			'Data Installazione' => Array($table_prefix.'_crmentity','data_installazione'),
			'Azienda'=> Array($table_prefix.'_codice_seriale', 'azienda')
		);

		#Viene chiamata la funzione getColumnFields() per ottenere i campi della colonna utilizzati nella classe corrente. 
		#Questi campi saranno memorizzati nell'array $column_fields:
		$this->column_fields = getColumnFields(get_class());

		#Viene ottenuta un'istanza del database Pear utilizzando 
		#PearDatabase::getInstance(). L'istanza del database viene assegnata alla variabile $db della classe:
		$this->db = PearDatabase::getInstance();
		#La variabile $log viene assegnata alla variabile $log della classe. Questa variabile sembra essere utilizzata per il logging:
		$this->log = $log;
	}

	/*
	// moved in CRMEntity
	function getSortOrder() { }
	function getOrderBy() { }
	*/

	function save_module($module) {
		global $adb,$table_prefix,$iAmAProcess;
		
		//Viene eseguito il salvataggio dei blocchi di prodotti solo se il modulo non è vuoto e se il modulo è un modulo di inventario. 
		#Questa condizione è verificata utilizzando la funzione isInventoryModule($module):
		if (!empty($module) && isInventoryModule($module)) {
			/*
				All'interno del blocco condizionale, viene verificato se la richiesta è un'azione di tipo Ajax, dettaglio vista Ajax, 
				salvataggio della modifica di massa o se il processo non è un processo in background ($iAmAProcess). 
				Se queste condizioni sono false, viene chiamato il metodo saveInventoryProductDetails() dell'oggetto InventoryUtils 
				per salvare i dettagli del prodotto dell'entità corrente. 
				Questo metodo si occupa di salvare la relazione tra l'entità e i prodotti associati ad essa:
			*/
			if($_REQUEST['action'] != "{$module}Ajax" && $_REQUEST['ajxaction'] != 'DETAILVIEW' && $_REQUEST['action'] != 'MassEditSave' && !$iAmAProcess) {	//crmv@138794
				$InventoryUtils = InventoryUtils::getInstance();
				//Based on the total Number of rows we will save the product relationship with this entity
				$InventoryUtils->saveInventoryProductDetails($this, $module);
			}

			/*
				Viene eseguito un aggiornamento nel database per impostare l'id della valuta e il tasso di conversione 
				per il modulo corrente. Viene utilizzata una query di aggiornamento per aggiornare i valori 
				nel record della tabella specificato dal campo $table_index (che sembra essere il campo 'codice_serialeid'). 
				I valori vengono presi dai campi $column_fields['currency_id'], $column_fields['conversion_rate'] 
				e l'id dell'oggetto corrente ($this->id):
			*/
			$update_query = "UPDATE {$this->table_name} SET currency_id=?, conversion_rate=? WHERE {$this->table_index} = ?";
			$update_params = array($this->column_fields['currency_id'], $this->column_fields['conversion_rate'], $this->id);
			$adb->pquery($update_query, $update_params);
		}
		
		// You can add more options here
		// ...
	}
	// crmv@64542e

	/**
	 * Return query to use based on given modulename, fieldname
	 * Useful to handle specific case handling for Popup
	 */
	function getQueryByModuleField($module, $fieldname, $srcrecord) {
		// $srcrecord could be empty
	}

	/**
	 * Invoked when special actions are performed on the module.
	 * @param String Module name
	 * @param String Event Type (module.postinstall, module.disabled, module.enabled, module.preuninstall)
	 */
	function vtlib_handler($modulename, $event_type) {
		global $adb,$table_prefix;
		if($event_type == 'module.postinstall') {
			$moduleInstance = Vtiger_Module::getInstance($modulename);
			if ($moduleInstance->is_mod_light) {	//crmv@106857
				$moduleInstance->hide(array('hide_module_manager'=>1,'hide_profile'=>1,'hide_report'=>1));
			} else {
				//crmv@29617
				$result = $adb->pquery('SELECT isentitytype FROM '.$table_prefix.'_tab WHERE name = ?',array($modulename));
				if ($result && $adb->num_rows($result) > 0 && $adb->query_result($result,0,'isentitytype') == '1') {
	
					$ModCommentsModuleInstance = Vtiger_Module::getInstance('ModComments');
					if ($ModCommentsModuleInstance) {
						$ModCommentsFocus = CRMEntity::getInstance('ModComments');
						$ModCommentsFocus->addWidgetTo($modulename);
					}
	
					$ChangeLogModuleInstance = Vtiger_Module::getInstance('ChangeLog');
					if ($ChangeLogModuleInstance) {
						$ChangeLogFocus = CRMEntity::getInstance('ChangeLog');
						$ChangeLogFocus->enableWidget($modulename);
					}
	
					$ModNotificationsModuleInstance = Vtiger_Module::getInstance('ModNotifications');
					if ($ModNotificationsModuleInstance) {
						$ModNotificationsCommonFocus = CRMEntity::getInstance('ModNotifications');
						$ModNotificationsCommonFocus->addWidgetTo($modulename);
					}
	
					$MyNotesModuleInstance = Vtiger_Module::getInstance('MyNotes');
					if ($MyNotesModuleInstance) {
						$MyNotesCommonFocus = CRMEntity::getInstance('MyNotes');
						$MyNotesCommonFocus->addWidgetTo($modulename);
					}
				}
				//crmv@29617e
				
				//crmv@92272
				$ProcessesFocus = CRMEntity::getInstance('Processes');
				$ProcessesFocus->enable($modulename);
				//crmv@92272e
				
				//crmv@105882 - initialize home for all users
				require_once('include/utils/ModuleHomeView.php');
				$MHW = ModuleHomeView::install($modulename);
				//crmv@105882e
			}
		} else if($event_type == 'module.disabled') {
			// TODO Handle actions when this module is disabled.
		} else if($event_type == 'module.enabled') {
			// TODO Handle actions when this module is enabled.
		} else if($event_type == 'module.preuninstall') {
			// TODO Handle actions when this module is about to be deleted.
		} else if($event_type == 'module.preupdate') {
			// TODO Handle actions before this module is updated.
		} else if($event_type == 'module.postupdate') {
			// TODO Handle actions after this module is updated.
		}
	}

	/**
	 * Handle saving related module information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	/*
	function save_related_module($module, $crmid, $with_module, $with_crmid) {
		parent::save_related_module($module, $crmid, $with_module, $with_crmid);
		//...
	}
	*/

	/**
	 * Handle deleting related module information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function delete_related_module($module, $crmid, $with_module, $with_crmid) { }

	/**
	 * Handle getting related list information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function get_related_list($id, $cur_tab_id, $rel_tab_id, $actions=false) { }

	/**
	 * Handle getting dependents list information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function get_dependents_list($id, $cur_tab_id, $rel_tab_id, $actions=false) { }
}
?>
