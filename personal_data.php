<?php
include("config.php");
$get = new sHelper();
$modUrl =  ltxt::getVar( 'mod','get' );
$ArrMod = explode(".",$modUrl);
$modData = $ArrMod[count($ArrMod)-1];

switch( strtolower($modData) ) {

	case $KeyPage."_list":
		$list = array();
		$group = $get->getGroup();
		$get->getDataList($list);

	break;
	case $KeyPage."_add":
		$group = $get->getGroup();
		if( ltxt::getVar( 'id', 'get' ) ){
			$datas = array();
			$get->getDetail( $datas );
			foreach( $datas[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}

	break;
	case $KeyPage."_view":

		if( ltxt::getVar( 'id', 'get' ) ){
			$detail = array();
			$get->getDetail( $detail );
			foreach( $detail[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}

	break;

	case $KeyPage."_contract":
		$group = $get->getGroup();
		if( ltxt::getVar( 'id', 'get' ) ){
			$datas = array();
			$get->getDetail( $datas );
			foreach( $datas[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}

	break;

	case $KeyPage."_security":
		$group = $get->getGroup();
		if( ltxt::getVar( 'id', 'get' ) ){
			$datas = array();
			$get->getDetail( $datas );
		 	//$get->getSecurityDetail($datas);
			foreach( $datas[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}

	break;
	case $KeyPage."_education":
		$group = $get->getGroup();
		if( ltxt::getVar( 'id', 'get' ) ){
			$datas = array();
			$get->getDetail( $datas );
			foreach( $datas[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
	break;

	case $KeyPage."_evaluate":
			$list = array();
			$group = $get->getGroup();
			$get->getEvaList($list);

	break;

	case $KeyPage."_evaform":
		$group = $get->getGroup();
		if( ltxt::getVar( 'eva', 'get' ) ){
			$datas = array();
			$get->getEvaDetail($datas);
			foreach( $datas[0] as $k=>$v){ $GLOBALS[$k] = $v; ${$k} = $v;}
		}
	break;

	case $KeyPage."_contract_expire":
		//$expirelist = array();
		//$group = $get->getGroup();
		//$get->getContractFromView($expirelist);
	break;

}
?>
