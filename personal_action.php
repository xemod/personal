<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

include("config.php");
include($KeyPage."_function.php");

if($action = ltxt::getVar( 'action','req' )) {

	$tsk = new sFunction();
	switch( strtolower($action) ) {

		case "reloadpage":
			if($_REQUEST["redirect_page"] != '') $rpage = $_REQUEST["redirect_page"];
			else $rpage = lurl::dotPage($listPage);
			$tsk->Reload($rpage);
		break;
		case "changestatus":
			$tsk->RedirectPage($listPage);
			$tsk->changeStatus();
		break;
		case "save":
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->Save();
		break;
		case "contractsave":
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->ContractSave();
		break;
		case "securesave":
			$tsk->RedirectPage($listPage);
			$tsk->SecureSave();
		break;

		case "educationsave":
			$tsk->RedirectPage($listPage);
			$tsk->EducationSave();
		break;

		case "educationdelete":
			$tsk->RedirectPage($listPage);
			$tsk->EducationDelete();
		break;

		case "delete":
			$tsk->RedirectPage($listPage);
			$tsk->Delete();
		break;
		case "deletecontract":
			$tsk->RedirectPage($personalContract);
			$tsk->DeleteContract();
		break;
		case 'confirm':
			include $confirmPage.'.php';
			exit;
		break;

		case 'contractconfirm':
		include $contractconfirmPage.'.php';
			exit;
		break;

		case 'educationconfirm':
		include $educationconfirmPage.'.php';
			exit;
		break;

		case "saveyear":
			$tsk->RedirectPage($listPage);
			$tsk->setUploadPath($PathUpload);
			$tsk->SaveYear();
		break;

		case "evaluatesave":
			$tsk->RedirectPage($Evaluate);
			$tsk->EvaluateSave();
		break;

	}

exit;

}
?>
