<?php
include("config.php");
include($KeyPage."_helper.php");
class sFunction extends sHelper{
	var $RedirectPage;
	var $PathUpload;
	//  Not Remove  //
	function RedirectPage($RPage)
	{
		$this->RedirectPage = $RPage;
	}

	function setUploadPath($Path)
	{
		$this->PathUpload = $Path;
	}

	function Reload($redirect_page)
	{
		LTXT::_( $redirect_page, 'redirect' );
	}

	function changeStatus()
	{
		if($_REQUEST['EnableStatus'] == 1){
			$_REQUEST['EnableStatus']='Y';
			$Status = "แสดง";
		}else{
			$_REQUEST['EnableStatus']='N';
			$Status = "ไม่แสดง";
		}



		//*** log files ***
		$LogTopic = $this->getBannerName($_REQUEST["PersonalId"]);
		LogFiles::SaveLog("ระบบบุคลากร","กำหนดสถานะข้อมูลบุคลากรเป็น ".$Status,$_REQUEST["PersonalId"],$LogTopic);
		//*****************



		if($pk = $this->db->arecSave('tblpersonal',$_REQUEST)){
			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
		}else{
			echo ltxt::_('Error!','jalert');
		}
	}
	//  End Not Remove  //

	function Save(){
		//fixed date from thaidate
		$datex=explode('-',$_POST['BirthDate']);
  		$_POST['BirthDate']=implode('-',array(($datex[2]-543),$datex[1],$datex[0]));



		$cfg = array(
			"upload_path" 	=> $this->PathUpload,
			'encrypt_name' 	=> true,
			"allowed_types" => "*"
		);

		if(!is_dir($this->PathUpload)){
			mkdir($this->PathUpload,0777);
		}

		$upload = new CI_Upload( $cfg );


		// Thumpnail
		if($_FILES["PictureFile"]["name"] != ''){
			if( $upload->do_upload( 'PictureFile') ){
				$file_data = $upload->data();
				$_POST["PictureFile"] = $file_data["file_name"];
			}
		}
		if($_POST["delThump"]==1){
			$_POST["PictureFile"] = '';
		}

		if($_POST["PersonalId"] == ""){
			$_POST["PersonalCode"] = RandomCode();
		}

		if($pk = $this->db->arecSave('tblpersonal',$_POST)){


			//*** log files ***
			if($_REQUEST['PersonalId']==""){
				LogFiles::SaveLog("ระบบบุคลากร","เพิ่มข้อมูลบุคลากร ",$pk,$_REQUEST["FirstName"]);
			}else{
				LogFiles::SaveLog("ระบบบุคลากร","แก้ไขข้อมูลบุคลากร ",$_REQUEST["PersonalId"],$_REQUEST["FirstName"]);
			}
			//*****************



			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

		}else{
			echo ltxt::_('Error!','jalert');
		}

	}
	function ContractSave(){


	if((is_uploaded_file($_FILES["ContractFilename"]["tmp_name"]))){

		if(!is_dir($this->PathUpload)){
			mkdir($this->PathUpload,0777);
		}

		//change name

		$filename = md5(date('Y-m-d H:i:s:u')).".pdf";


		$_FILES['ContractFilename']['name'] = $filename;

		//setup file folder
		$uploadfile = $this->PathUpload."/contract/". basename($_FILES['ContractFilename']['name']);
		//move

		move_uploaded_file($_FILES['ContractFilename']['tmp_name'], $uploadfile);


		$_POST["ContractFilename"] = $filename;//changename

	}else{
			$_POST["ContractFilename"] = $_POST["ContractFilenameOld"];
	}

	//Generates dataset BoardTypeId
	$BoardTypeId=$_POST['BoardTypeId'];
	foreach ($BoardTypeId as $value){
		 $bvalue .= $value.",";
	}
	$_POST['BoardTypeId'] = rtrim($bvalue,",");

	//mysql_query("UPDATE tblpersonal_contract SET EnableStatus='N' WHERE PersonalId=".$_POST["PersonalId"]);

	//Enble ล่าสุด
	$_POST["EnableStatus"]=="Y";
		if($pk = $this->db->arecSave('tblpersonal_contract',$_POST)){

			//update disanle old contract
			//mysql_query("UPDATE tblpersonal_contract SET EnableStatus='N' WHERE PersonalId=".$_POST["PersonalId"]."  AND StartDate < Now() AND EndDate < Now()");

			//*** log files ***
			if($_REQUEST['PersonalId']==""){
				LogFiles::SaveLog("ระบบบุคลากร","เพิ่มข้อมูลสัญญาเลขที่ ".$_POST["ContractNo"],$pk,$_REQUEST["FirstName"]);
			}else{
				LogFiles::SaveLog("ระบบบุคลากร","แก้ไขข้อมูลสะญญา ".$_POST["ContractNo"],$_REQUEST["PersonalId"],$_REQUEST["FirstName"]);
			}
			//*****************

			//echo $this->RedirectPage;

			LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

		}else{
			echo ltxt::_('Error!','jalert');
		}

		print_r($_POST);
	}

	function SecureSave(){

		if(!isset($_POST["GroupInsure"]))
				$_POST["GroupInsure"] = 0;

		if(!isset($_POST["ChildernEdu"]))
				$_POST["ChildernEdu"] = 0;

		if(!isset($_POST["HealthCheck"]))
				$_POST["HealthCheck"] = 0;

		if(!isset($_POST["Uniform"]))
				$_POST["Uniform"] = 0;

		if(!isset($_POST["CallFee"]))
						$_POST["CallFee"] = 0;

		if(!isset($_POST["Bonus"]))
						$_POST["Bonus"] = 0;

		if(!isset($_POST["GetHurt"]))
						$_POST["GetHurt"] = 0;

if(!isset($_POST["VisitGift"]))
					$_POST["VisitGift"] = 0;

if(!isset($_POST["PublicHazard"]))
						$_POST["PublicHazard"] = 0;

if(!isset($_POST["Retire"]))
							$_POST["Retire"] = 0;

		if(!isset($_POST["Layoff"]))
					$_POST["Layoff"] = 0;

		if(!isset($_POST["Funeral"]))
					$_POST["Funeral"] = 0;

		mysql_query("UPDATE tblpersonal_security SET EnableStatus='N' WHERE PersonalId=".$_POST["PersonalId"]);

		$_POST["EnableStatus"]="Y";
		if($pk = $this->db->arecSave('tblpersonal_security',$_POST)){


			//*** log files ***
			if($_POST['SecurityId']==""){
				LogFiles::SaveLog("ระบบบุคลากร","เพิ่มสวัสดิการ ".$_POST["ContractNo"],$pk,$_POST["FirstName"]);
			}else{
				LogFiles::SaveLog("ระบบบุคลากร","แก้ไขข้อสวัสดิการ ".$_POST["ContractNo"],$_POST["FirstName"]);
			}
			//*****************



		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

		}else{
			echo ltxt::_('Error!','jalert');
		}

	}

	function EducationSave(){

		if($pk = $this->db->arecSave('tblpersonal_education',$_POST)){


			//*** log files ***
			if($_POST['DegreeId']==""){
				LogFiles::SaveLog("ระบบบุคลากร","เพิ่มประวัติการศึกษา ".$_POST["PersonalId"],$pk,$_POST["DegreeId"]);
			}else{
				LogFiles::SaveLog("ระบบบุคลากร","แก้ไขประวัติการศึกษา ".$_POST["PersonalId"],$_POST["DegreeId"]);
			}
			//*****************



		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

		}else{
			echo ltxt::_('Error!','jalert');
		}

	}

	function EducationDelete(){

		//*** log files ***
		//$LogTopic = $this->getBannerName($_REQUEST["PersonalId"]);
		$this->RedirectPage ="personal_education&id=".$_REQUEST["PersonalId"];

		$this->db->Execute("Update tblpersonal_education set DeleteStatus='Y',,EnableStatus='N' where EducationId = ".$_REQUEST["EducationId"]."");
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}

function EvaluateSave(){

	if($pk = $this->db->arecSave('tblpersonal_evaluate',$_POST)){
//print_r($_POST);

		//*** log files ***
		if($_POST['PersonalId']!=""){
			LogFiles::SaveLog("ระบบบุคลากร","ทำแบบฟอร์มประเมิน ".$_POST["PersonalId"],$pk,$_POST["EvaMateId"]);
		}else{
			LogFiles::SaveLog("ระบบบุคลากร","ทำแบบฟอร์มประเมิน ".$_POST["PersonalId"],$_POST["EvaMateId"]);
		}
		//*****************



	LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );

	}else{
		echo ltxt::_('Error!','jalert');
	}

}


	function Delete(){

		//*** log files ***
		$LogTopic = $this->getBannerName($_REQUEST["PersonalId"]);
		//LogFiles::SaveLog("จัดการลิงค์หน่วยงานที่เกี่ยวข้อง","ลบลิงค์หน่วยงานที่เกี่ยวข้อง",$_REQUEST["PersonalId"],$LogTopic);
		//*****************

		$this->db->Execute("Update tblpersonal set DeleteStatus='Y',EnableStatus='N' where PersonalId = ".$_REQUEST["PersonalId"]."");
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}

	function DeleteContract(){

		//*** log files ***
		$LogTopic = $this->getBannerName($_REQUEST["PersonalId"]);
		//LogFiles::SaveLog("จัดการลิงค์หน่วยงานที่เกี่ยวข้อง","ลบลิงค์หน่วยงานที่เกี่ยวข้อง",$_REQUEST["PersonalId"],$LogTopic);
		//*****************
		$this->RedirectPage .="&id=".$_REQUEST["PersonalId"];

		$this->db->Execute("Update tblpersonal_contract set DeleteStatus='Y',EnableStatus='N' where ContractId = ".$_REQUEST["ContractId"]." LIMIT 1");
		LogFiles::SaveLog("ระบบบุคลากร","ลบสัญญาเลขที่ ".$_POST["ContractNo"],$_POST["FirstName"]);
		LTXT::_( '?mod='.LURL::dotPage($this->RedirectPage), 'redirect' );
	}

	function SaveYear()
	{
		$Year = date("Y") + 543;
		$OrgId = $_REQUEST["OrgId"];
		$this->db->Execute("DELETE FROM tblpersonal_year  where OrgId = ".$OrgId." ");

		foreach($_REQUEST["ListPersonalSelect"] as $PersonalId){

			$this->db->Execute("DELETE FROM tblpersonal_year  where PersonalId='$PersonalId' AND OrgId <> ".$OrgId." ");
			$sql = "INSERT INTO tblpersonal_year (PersonalId,OrgId,BgtYear,EnableStatus) VALUES ('$PersonalId','$OrgId','$Year','Y')";
			$this->db->Execute($sql);
		}

		LTXT::_( '?mod='.LURL::dotPage("personal_year").'&OrgId='.$OrgId, 'redirect' );
	}

}
?>
