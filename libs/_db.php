<?php
// StripSlashes
function _StripSlashes(&$Value){
	$Value=StripSlashes($Value);
}

class DataBase extends Error{
	var $DataBase;
	var $DataBaseName;
	var $LastCount;
	var $LastInserted;
    var $Log = array();

	function DataBase(){
		global $Global;
		$this->DataBase=mysql_pconnect($Global['MySQL.Host'],$Global['MySQL.Login'],$Global['MySQL.Password']);
		if(!$this->DataBase)
			$this->MySQLError('NoConnection');

		mysql_query("SET NAMES 'utf8'");
			
		if(isset($Global['MySQL.DataBase']))
			$this->SelectDataBase($Global['MySQL.DataBase']);
			
		
		//mysql_query("SET CHARACTER SET 'cp1251'");
	}

	//����� ���� ������
	function SelectDataBase($DataBaseName){
		if($this->DataBaseName!=$DataBaseName){
			mysql_select_db($DataBaseName);
			$this->DataBaseName=$DataBaseName;
		}
	}

	//������� ������� ������ �� �� � ��������� ������
	function ReadNum($Query,$Map='**'){
		global $Global;
		//�������� ����� �������� ����� �������
		if(strlen($Map)!=2)
			$this->MySQLError('DataBase.ReadNum.InvalidArrayMap');

		$Result=mysql_query($Query,$this->DataBase);
		//�������� �� ������������� ���������� ���������� ������� MySQL
		if(!$Result && $Global['Debug'])
			$this->MySQLError("NoResult [$Query]");

		$Col=$Map[0];
		$Row=$Map[1];

      		$Num=mysql_num_rows($Result);
		if($Row==1&&$Num)$Num=1;

		for($i=0;$i<$Num;$i++){
			$ResultArray[$i]=mysql_fetch_row($Result);
			if($Col==1)
				$ResultArray[$i]=StripSlashes($ResultArray[$i][0]);
			else
				array_walk($ResultArray[$i],_StripSlashes);
		}
	
		if($Row==1)$ResultArray=$ResultArray[0];
		$this->LastCount=($Row==1)?count($ResultArray):$Num;
		return $ResultArray;
	}

	//������� ������� ������ �� �� � �������������� ������
	function ReadAss($Query,$Map='**'){
		global $Global;
		//�������� ����� �������� ����� �������
		if(strlen($Map)!=2)
			$this->MySQLError('DataBase.ReadAss.InvalidArrayMap');

        $start = microtime(true);
		$Result=mysql_query($Query,$this->DataBase);
        $this->Log[] = array('time'=>microtime(true)-$start,'query'=>$Query);
        
		//�������� �� ������������� ���������� ���������� ������� MySQL
		if(!$Result && $Global['Debug'])
			$this->MySQLError("NoResult [$Query]");
		
		$Col=$Map[0];
		$Row=$Map[1];

		$Num=mysql_num_rows($Result);
		if($Row==1&&$Num)$Num=1;

		for($i=0;$i<$Num;$i++){
			$ResultArray[$i]=mysql_fetch_assoc($Result);
			
			if($Col==1){
				$Each=each($ResultArray[$i]);
				$ResultArray[$i]=StripSlashes($Each['value']);
		 	}
			else array_walk($ResultArray[$i],_StripSlashes);

		}

		if($Row==1)$ResultArray=$ResultArray[0];
		$this->LastCount=($Row==1)?count($ResultArray):$Num;	
		return $ResultArray;
	}
		
	//������ ������� ������ �� ��
	function ReadAssLine($Query){
		return $this->ReadAss($Query,'*1');
	}

	//������� ������� ������ �� �� � ���������� �������������� ������ (������� ����� ������)
	function ReadAssRow($Query){
		return $this->ReadAss($Query,'*1');
	}

	//�-� ������ ������ ������������� �������� �� ��
	function ReadScalar($Query){
		global $Global;
		
		$Result=mysql_query($Query,$this->DataBase);
		//�������� �� ������������� ���������� ���������� ������� MySQL
		if(!$Result && $Global['Debug'])
			$this->MySQLError("NoResult [$Query]");
		
		$ResultArray=mysql_fetch_row($Result);
		//$this->LastCount=0;

		return StripSlashes($ResultArray[0]);
	}

	function Exec($Query, $debug=0){
		$Result=mysql_query($Query,$this->DataBase);
		//�������� �� ������������� ���������� ���������� ������� MySQL
		if(!$Result && $Global['Debug'])
			$this->MySQLError("NoResult [$Query]");
		
		return $Result;
	}
	
	//������� ������/���������� ������
	function EditDB($AssocArray,$TableName,$Condition=''){
		global $Global;
		
		//���� ������� ������� - ������ ������ ��������
		if ($Condition) $Query="update $TableName set ";
		else 			$Query="insert into $TableName set ";
		
		foreach ($AssocArray as $key=>$value)
			$Query.="`".AddSlashes($key)."`='".AddSlashes($value)."',";
		$Query=substr($Query,0,-1);
		
		if ($Condition) $Query.=" where $Condition";

		$Result=mysql_query($Query,$this->DataBase);		
		
		if(!$Result && $Global['Debug'])
			$this->MySQLError("NoResult [$Query]");
			
		$this->LastInserted=$this->ReadScalar('select last_insert_id()');

	}

	//�-� �������� ������� �� �������
	function DeleteDB($TableName,$Condition=''){
		$Query="delete from $TableName";
		if($Condition) $Query.=" where $Condition";
	
		$Result=mysql_query($Query,$this->DataBase);
		if(!$Result && $Global['Debug'])
			$this->MySQLError("DataBase.DeleteDB.NoResult [$Query]");
	}

	//�-� ���������� �������� �������, �������� ������� ���. ������� � ������� - ����� �����
	function DescribeTable($TableName){
		$Field=$this->ReadAss("describe $TableName",'1*');
		
		foreach ($Field as $str)
			$Result[$str]='';
		
		return $Result;
	}
	
};

class IntegratedDataBase extends Error{
	var $DB;
	
	function IntegratedDataBase(&$DataBaseVariable){
		$this->DB=&$DataBaseVariable;	
	}
};

?>
