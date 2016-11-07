<?php

class sHelper
{
	var $db;
	var $debug = 0;
	function sHelper()
	{
		$this->db = &JFactory::getDBO();
		$this->db->debug( $this->debug );
	}

	function getData($table,$field,$value){
		$sql="select * from ".$table." where ".$field." = ".$value."";
		$this->db->setQuery($sql);
		$row = $this->db->loadObjectList();
		return $row;
	}

function getEvaPersonId($selected=''){
		//$selected = $GLOBALS["OrgId"];
		jimport('packages.utility.utl_grouptree');
		$Tree = $this->getEvaPersonTree();
print_r($Tree);

		$t = $Tree->getTree(0);

		$row[] = clssHTML::makeOption('','เลือกรายชื่อผู้ถูกประเมิน...');
		foreach( $t as $r ){
			$x = new stdClass;
			$x->value = $r->PersonalId;
			$x->text = $this->getListPrefixTxt($r->PrefixId)." ".$r->FirstName." ".$r->LastName;
			$row[] = $x;
		}
		echo clssHTML::selectList( $row, 'EvaPersonalId', '', 'value', 'text',$selected );
	}

	function getEvaPersonTree(){
		jimport('packages.utility.utl_grouptree');
		$Tree = new JGroupTree(array(
			'dbo'  => $this->db,
			'table' => 'tblpersonal',
			'prefix' => 'Per',
			'root' => 'Root',
			//'debug' => 2,
			'where'=>array(
				'EnableStatus' => 'Y',
				'DeleteStatus' => 'N'
			)
		));
		$Tree->rebuildTree(0,0);
		return $Tree;
	}

	function getOrganize($selected=''){
			//$selected = $GLOBALS["OrgId"];
			jimport('packages.utility.utl_grouptree');
			$Tree = $this->getTree();
			$t = $Tree->getTree(0);

			$row[] = clssHTML::makeOption('','เลือกหน่วยงาน/ฝ่าย...');
			foreach( $t as $r ){
				$x = new stdClass;
				$x->value = $r->OrgId;
				$x->text = @str_repeat('&nbsp;&nbsp;',$r->Level-1).@str_repeat('-',$r->Level-1)."&nbsp;".$r->OrgName;
				$row[] = $x;
			}
			echo clssHTML::selectList( $row, 'OrgId', '', 'value', 'text',$selected );
		}

		function getTreeLevel($level=3,$root=false){
			return $this->getTree()->getTreeLevel($level,$root);
		}

		function getTree(){
			jimport('packages.utility.utl_grouptree');
			$Tree = new JGroupTree(array(
				'dbo'  => $this->db,
				'table' => 'tblorganize',
				'prefix' => 'Org',
				'root' => 'Root',
				//'debug' => 2,
				'where'=>array(
					'OrgYear' =>$_REQUEST["OrgYear"]?$_REQUEST["OrgYear"]:(date('Y')+543),
					'DeleteStatus' => 'N'
				)
			));
			$Tree->rebuildTree(0,0);
			return $Tree;
		}

	function getDataList(&$list){
		$where 	  = array();
		$keyword = $_REQUEST['type'];

		if($_REQUEST['arrange']){
			$ord = " order by ".$_REQUEST['arrange']." ".$_REQUEST['fil'];
		}else{
			$ord=" ORDER BY EnableStatus DESC";
		}

		if($_REQUEST["tsearch"]){
			$where[] = " (tr.FirstName like ('%".$_REQUEST["tsearch"]."%')"." OR tr.LastName like ('%".$_REQUEST["tsearch"]."%') ) ";
		}

		$where[] ="tr.DeleteStatus='N'";

		if($where){
			$where_r = "\n WHERE ".implode(" AND ",$where);
		}

		$sql = "SELECT * FROM tblpersonal as tr "
		.$where_r."  ".$ord." "	;

		$this->db->setQuery($sql);
		$list = $this->db->loadDataSet();
		return $list;
	}

	function getEvaList(&$list){
		$where 	  = array();
		$keyword = $_REQUEST['type'];
		$sql = "SELECT * FROM tblpersonal Join tblpersonal_eva_mate ON tblpersonal.PersonalId = tblpersonal_eva_mate.EvaPersonalId WHERE tblpersonal_eva_mate.PersonalId=".$_SESSION['Session_PersonalId'];


		$this->db->setQuery($sql);
		$list = $this->db->loadDataSet();
		return $list;
	}

	function getChkEvaluatePerson($EvaMateId,$PersonalId)
	{
		$sql = "SELECT EvaId FROM tblpersonal_evaluate WHERE EvaMateId= ".$EvaMateId." AND PersonalId=".$PersonalId;
		$this->db->setQuery($sql);
		$res = $this->db->loadResult();
		if($res) return true; else return false;
	}

	function getContractById(&$ContractByID,$ContractId=""){
		$sql = "SELECT * FROM tblpersonal_contract WHERE ContractId=$ContractId";
		$this->db->setQuery($sql);
		$ContractByID = $this->db->loadDataSet();
		return $ContractByID;
	}

		function getEducationById(&$EducationByID,$EducationId=""){
			$sql = "SELECT * FROM tblpersonal_education WHERE EducationId = $EducationId";
			$this->db->setQuery($sql);
			$EducationByID = $this->db->loadDataSet();
			return $EducationByID;
		}


	function getContractByPersonalId(&$ContractByPersonalId,$PersonalId=""){
		$sql = "SELECT * FROM tblpersonal_contract WHERE PersonalId = $PersonalId AND DeleteStatus='N' ORDER BY StartDate DESC";
		$this->db->setQuery($sql);
		$ContractByPersonalId = $this->db->loadDataSet();
		return $ContractByPersonalId;
	}


function getSecureByContractNo(&$SecureData,$ContractNo=""){
		$sql = "SELECT * FROM tblpersonal_security WHERE ContractNo = '$ContractNo' AND EnableStatus='Y' AND DeleteStatus='N'";
		$this->db->setQuery($sql);
		$SecureData = $this->db->loadDataSet();
}



	function getLastestContractNoByPersonalid($PersonalId){
		$sql = "SELECT ContractNo FROM tblpersonal_contract WHERE PersonalId = $PersonalId AND EnableStatus='Y' AND DeleteStatus='N' ORDER BY StartDate DESC LIMIT 1";
		$this->db->setQuery($sql);
		$ContractNo = $this->db->loadResult();
		return $ContractNo;

	}


	function getListPersonal()
	{
		$sql = "SELECT * FROM tblpersonal where EnableStatus='Y' AND DeleteStatus='N' order by FirstName Asc";
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList();
		return $detail;
	}



	function getListPersonalOrg($OrgId='')
	{
		$sql = "SELECT t1.* FROM tblpersonal  as t1 inner join tblpersonal_year as t2 on t1.PersonalId=t2.PersonalId where t2.OrgId='$OrgId' order by t1.FirstName Asc";
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList();
		return $detail;
	}

	function getDetail(&$detail){
		$sql = "SELECT * FROM tblpersonal where PersonalId=".$_GET['id'];
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList();
		return $detail;
	}

	function getEvaDetail(&$detail){
		$sql = "SELECT * FROM tblpersonal where PersonalId=".$_GET['eva'];
		$this->db->setQuery($sql);
		$detail = $this->db->loadObjectList();
		return $detail;
	}

	function getFiles($Id,$Type='file'){
		$sql = "SELECT * FROM tblpersonal where BNType='$Type' and PersonalId=".$Id;
		$this->db->setQuery($sql);
		$files = $this->db->loadObjectList();
		return $files;
	}

	function getThumpnail($Id){
		$sql = "SELECT BNFilePath FROM tblpersonal where PersonalId=".$Id;
		$this->db->setQuery($sql);
		$files = $this->db->loadResult();
		return $files;
	}

	function getOrg_Year($id){
		$sql = "SELECT Year FROM tblyear where YearId=".$id;
		$this->db->setQuery($sql);
		$rows = $this->db->loadObjectList();
		return $rows ;
	}

	function getGroup(){
		$sql="select BNGroupID as value,BNGroupName as text from tblpersonal";
		$this->db->setQuery($sql);
		//$title[] = clssHTML::makeOption('','เลือกกลุ่ม');
		$type = $this->db->loadObjectList();
		//$type = array_merge($title,$type);
		return $type;
	}

	function getGroupName($BNGroupID)
	{
		$sql = "SELECT BNGroupName FROM tblpersonal where BNGroupID=".$BNGroupID;
		$this->db->setQuery($sql);
		$BNGroupName = $this->db->loadResult();
		return $BNGroupName;
	}



	function getBannerName($PersonalId)
	{
		$sql = "SELECT FirstName FROM tblpersonal where PersonalId=".$PersonalId;
		$this->db->setQuery($sql);
		$BNGroupName = $this->db->loadResult();
		return $BNGroupName;
	}

	function getListPrefix($PrefixId='',$type='TH'){

		$sql = "select PrefixId as value,PrefixName as text from tblpersonal_prefix
		where EnableStatus='Y' and StatusPrefix='$type'";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption('','กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'PrefixId', '', 'value', 'text', $PrefixId );

	}

	function getListPrefixTxt($PrefixId)
	{
		$sql = "SELECT PrefixName FROM tblpersonal_prefix where PrefixId=".$PrefixId;
		$this->db->setQuery($sql);
		$Txt = $this->db->loadResult();
		return $Txt;
	}


	function getListManPower($ManPowerId=''){
		$sql = "select ManPowerId as value,ManPowerName as text from tblpersonal_manpower where EnableStatus='Y' ";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption('','กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'ManPowerId', '', 'value', 'text', $ManPowerId );

	}

		function getListBoardType($BoardTypeId=''){
			$sql = "select BoardTypeId as value,BoardType as text from tblpersonal_board where EnableStatus='Y' ";
			$this->db->setQuery($sql);
			//$title[] = clssHTML::makeOption('','กรุณาเลือก(กด ctrl เพื่อเลือก)');
			$subCate = $this->db->loadArrayList();
			echo "<select multiple name=\"BoardTypeId[]\" id=\"BoardTypeId\" >\n";
			echo "<option disabled>กดปุ่ม ctrl ค้างเพื่อเลือก</option>";
			foreach ($subCate as $k) {
					echo "<option value=\"".$k["value"]."\"";
					if(strpos($BoardTypeId,(string)$k["value"])!==false) echo " selected ";
					echo ">".$k["text"]."</option>\n";
			}
			echo "</select>\n";
			//echo clssHTML::selectList( $subCate, 'BoardTypeId[]', 'multiple', 'value', 'text', $BoardTypeId );
		}


	function getListEducationLevel($LevelId='')
	{
		$sql = "SELECT LevelId as value,Level as text FROM tblpersonal_edu_level where EnableStatus='Y' order by LevelId";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption('','กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'LevelId', '', 'value', 'text', $LevelId);

	}

	function getListEducationLevelTxt($LevelId)
	{
		$sql = "SELECT Level FROM tblpersonal_edu_level where LevelId=".$LevelId;
		$this->db->setQuery($sql);
		$Txt = $this->db->loadResult();
		return $Txt;
	}

	function getEducationByPersonalId(&$EducationByPersonalId,$PersonalId=""){
		$sql = "SELECT * FROM tblpersonal_education WHERE PersonalId = $PersonalId AND EnableStatus='Y' AND DeleteStatus='N' ORDER BY FinishYear DESC";
		$this->db->setQuery($sql);
		$EducationByPersonalId = $this->db->loadDataSet();
		return $EducationByPersonalId;
	}

	function getListEducationDegree($DegreeId='')
	{
		$sql = "SELECT DegreeId as value,Degree as text FROM tblpersonal_edu_degree where EnableStatus='Y' order by DegreeId";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption('','กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'DegreeId', '', 'value', 'text', $DegreeId);

	}

	function getListEducationDegreeTxt($DegreeId)
	{
		$sql = "SELECT Degree FROM tblpersonal_edu_degree where DegreeId=".$DegreeId;
		$this->db->setQuery($sql);
		$Txt = $this->db->loadResult();
		return $Txt;
	}

	function getListHealthCoverage($HealthCoverage=''){

		$title[] = clssHTML::makeOption('','--โปรดเลือก--');

		$subCate = array();
		$subCate[0] = (object)array ('value' => '1','text' => 'สวัสดิการรักษาพยาบาลข้าราชการ');
		$subCate[1] = (object)array ('value' => '2','text' => 'ประกันสังคม');
		$subCate[2] = (object)array ('value' => '0','text' => 'ไม่มี');


		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'HealthCoverage', '', 'value', 'text', $HealthCoverage );

	}


	function getListPensionType($PensionType=''){
		$title[] = clssHTML::makeOption('','--โปรดเลือก--');

		$subCate = array();
		$subCate[0] = (object)array ('value' => '1','text' => 'บำเน็จ');
		$subCate[1] = (object)array ('value' => '2','text' => 'กองทุนเลี้ยงชีพ');

		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'PensionType','', 'value', 'text',$PensionType);
	}


	function getListBoardTypeTxt($BoardTypeId=''){
		$sql = "select BoardType from tblpersonal_board where BoardTypeId='$BoardTypeId' ";
		$this->db->setQuery($sql);
		$txt = $this->db->loadResult();
		return $txt;
	}

	function getListManPowerTypeTxt($ManPowerId=''){
		$sql = "select ManPowerName from tblpersonal_manpower where ManPowerId='$ManPowerId' ";
		$this->db->setQuery($sql);
		$txt = $this->db->loadResult();
		return $txt;
	}


	function getListPositionType($PositionTypeId=''){

		$sql = "select PositionId as value,Position as text from tblposition";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption('','กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'PositionTypeId', '', 'value', 'text', $PositionTypeId );

	}

	function getListPositionTypeTxt($PositionTypeId=''){
		$sql = "select Position from tblposition where PositionId='$PositionTypeId' ";
		$this->db->setQuery($sql);
		$txt = $this->db->loadResult();
		return $txt;
	}

	function getListPersonalType($PerTypeId=''){

		$sql = "select PerTypeId as value,PerType as text from tblpersonal_type where EnableStatus='Y' ";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption('','กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'PerTypeId', '', 'value', 'text', $PerTypeId );

	}

	function getListPersonalTypeTxt($PerTypeId='')
	{
		$sql = "select PerType from tblpersonal_type where PerTypeId='$PerTypeId' ";
		$this->db->setQuery($sql);
		$txt = $this->db->loadResult();
		return $txt;
	}


	function getListProvince($ProvinceId=''){

		$sql = "select ProvinceId as value,Province as text from tblpersonal_province where EnableStatus='Y' order by Province asc";
		$this->db->setQuery($sql);
		$title[] = clssHTML::makeOption(0,'กรุณาเลือก');
		$subCate = $this->db->loadObjectList();
		$subCate = array_merge($title,$subCate);
		echo clssHTML::selectList( $subCate, 'ProvinceId', '', 'value', 'text', $ProvinceId );

	}

	function getListProvinceTxt($ProvinceId)
	{
		$sql = "select Province from tblpersonal_province where ProvinceId='$ProvinceId' ";
		$this->db->setQuery($sql);
		$txt = $this->db->loadResult();
		return $txt;
	}

	function getContractFromView(&$expirelist){
		$sql="select * from vw_personal order by EndDate";
		$this->db->setQuery($sql);
		$expirelist = $this->db->loadDataSet();
		return $expirelist;
	}

 function ChkContract($date){

	 $valid = date_create($date);
	 $colors = array("#00000","#ff0505","#ff904d","#ffcc4d","#bbf220");
	 $i=1;


	 while ($i <= 3){

		 if($valid < date_create(date("Y-m-d"))){
					$t = "<td bgcolor=\"".$colors[1]."\">เลยสัญญา ".$this->dateDiff(date("Y-m-d"),$date)."</td>\n";
					break;
		 }elseif($valid == date_create(date("Y-m-d"))) {
	 			  $t ="<td bgcolor=\"".$colors[1]."\">หมดวันนี้</td>\n";
					break;
	 	}

		 // ลบออกทีละเดือน
 	 	 date_sub($valid, date_interval_create_from_date_string('1 month 0 days')); //ลบ เดือน
		 if(date_create(date("Y-m-d")) >= $valid){
			 	$t = "<td bgcolor=\"".$colors[$i]."\">".$this->dateDiff(date("Y-m-d"),$date)."</td>\n";
				break;
		 }else{
			  $t = "<td style=\"background-color:#6fe56f\">".$this->dateDiff(date("Y-m-d"),$date)."</td>\n";
		 }
		 $i++;
	 }
	 echo $t;
 }

	function dateDiff($time1, $time2, $precision=6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    //$intervals = array('','เดือน','วัน','ขั่วโมง','นาที','วินาที');
    $diffs = array();

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
      $diffs['diff'] = ' ago';
      $diffs['sign'] = '-';
    }

    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
    $time1 = $ttime;
    $diffs[$interval]++;
    // Create new temp time from time1 and interval
    $ttime = strtotime("+1 " . $interval, $time1);
      }
    }

    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
    break;
      }
      // Add value and interval
      // if value is bigger than 0
      if ($value > 0) {
    // Add s if value is not 1
    if ($value != 1) {
      $interval .= "s";
    }
    // Add value and interval to times array
    $times[] = $value . " " . $interval;
    $count++;
      }
    }

    // -- \\ ALTERED SECTION // -- \\
    // Return string with times
    //$diffs['text'] = implode(', ',$times);
    //return $diffs;
    // -- \\ END OF ALTERED SECTION // -- \\
    // original return statement

    return str_replace(
    array('years','months','days','hours','minutes','seconds','year','month','day','hour','minute','second'),
    array('ปี','เดือน','วัน','ชั่วโมง','นาที','วินาที','ปี','เดือน','วัน','ชั่วโมง','นาที','วินาที'),
    implode(", ", $times));


 	}

}
?>
