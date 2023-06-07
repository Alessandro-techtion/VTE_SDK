<?php
/*************************************
 * SPDX-FileCopyrightText: 2009-2020 Vtenext S.r.l. <info@vtenext.com> 
 * SPDX-License-Identifier: AGPL-3.0-only  
 ************************************/

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
 include_once('vtlib/Vtecrm/Webservice.php');
 include_once('vtlib/Vtecrm/Version.php');
 include_once('vtlib/Vtecrm/Profile.php');
 
 $vtlib_Utils_Log = true;
 global $adb, $table_prefix;


 VteSession::start();

 $moduleName='MacchineClienti';

	$modulo = Vtiger_Module::getInstance($moduleName);
	if ($modulo ) 
		$modulo->delete();

$moduleName='Macchine';

		$modulo = Vtiger_Module::getInstance($moduleName);
		if ($modulo ) 
			$modulo->delete();

$moduleName='Accessori';

		$modulo = Vtiger_Module::getInstance($moduleName);
		if ($modulo ) 
			$modulo->delete();


 ?>
