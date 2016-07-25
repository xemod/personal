<?php
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];
$ArrKey = split("_",$modData);
$KeyPage = $ArrKey[0];

$noImage = '../../images/noimage.png';

switch($KeyPage)
{
	case "personal":
			$PathUpload = VSROOT.'upload/personal/';
			$startupPage = "startup";
			$actionPage = "personal_action";
			$listPage = "personal_list";
			$addPage = "personal_add";
			$confirmPage = "personal_confirm";
			$contractconfirmPage = "personal_contract_confirm";
			$educationconfirmPage = "personal_education_confirm";
			$viewPage = "personal_view";
			$MenuName = getMenuItem(lurl::dotPage($listPage))->MenuName;
			$imgWidth = '120';
			$imgHeight = '80';
			$personalYear = "personal_year";
			$personalContract = "personal_contract";
			$personalContractList = "personal_contract_list";
			$personalContractExpire = "personal_contract_expire";
			$security ="personal_security";
			$Evaluate="personal_evaluate";
			$EvaluatePage="personal_evaform";
			$Education="personal_education";
	break;

}

// Not Remove //
$GLOBALS["PathUpload"] = $PathUpload;
$GLOBALS["startupPage"] = $startupPage;
$GLOBALS["actionPage"] = $actionPage;
$GLOBALS["listPage"] = $listPage;
$GLOBALS["addPage"] = $addPage;
$GLOBALS["confirmPage"] = $confirmPage;
$GLOBALS["viewPage"] = $viewPage;
$GLOBALS["LogModule"] = $MenuName;
////
$GLOBALS["personalYear"] = $personalYear;
$GLOBALS["personalContract"] = $personalContract;
$GLOBALS["personalContractList"] = $personalContractList;
$GLOBALS["contractconfirmPage"] = $contractconfirmPage;
$GLOBALS["educationconfirmPage"] = "$educationconfirmPage";
$GLOBALS["security"] = $security;
$GLOBALS["Evaluate"] = $Evaluate;
$GLOBALS["EvaluatePage"] = $EvaluatePage;
$GLOBALS["Education"] = $Education;
$GLOBALS["ContractExpire"] = $personalContractExpire;
?>
