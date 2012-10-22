<?php

class News extends IntegratedDataBase {
	var $NTable = 'news';
	
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY new_date DESC");
		
	}
	
	function ReadOneObject($ObjectID){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE new_id='$ObjectID'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['new_id'];
		unset ($Vars['new_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		$meil = $Vars['new_meil'];
		unset ($Vars['new_meil']);
		
		//add
		if(!$ObjectID){
			$t = explode('.',$Vars['new_date']);
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return;
			$Vars['new_date'] = mktime(1,0,0,$t[1],$t[0],'20'.$t[2]);
			//$Vars['new_date'] = time();
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
			
			if ($meil) {
				$tmp = $this->DB->ReadAss('SELECT distinct meil FROM spam');
				global $ALARM;
				foreach ($tmp as $row) {
					$ALARM->Mail($Vars['new_name'], $row['meil'], "{$Vars['new_prew']} \n {$Global['Host']}/news/{$ObjectID} \n С уважением, Администрация");
				}
			}
			
			$this->Go("{$Global['Host']}/edit_news/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			$t = explode('.',$Vars['new_date']);
			
			$Vars['new_date'] = mktime(1,0,0,$t[1],$t[0],'20'.$t[2]);
						
			$this->DB->EditDB($Vars,$this->NTable,"new_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_news/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			if (($User['Rights']&$Global['Right.SEO']) &&(!($User['Rights']&$Global['Right.Admin']))) return;
			$this->DB->DeleteDB($this->NTable, 'new_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_news");
		}
		
	}
	
	function ShowLastNews($count=0, $flag = 1) {
		global $Global;
		
		if ($count) {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY new_date DESC LIMIT $count");
		} else {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY new_date DESC");
		}
		
		foreach ($temp as $i=>$row) {
			
			echo '<font class="date">'.(date("d.m.Y", $temp[$i]['new_date'])).'</font> <div class="new_text"><a href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'">';
			if (substr($temp[$i]['new_prew'],strlen($temp[$i]['new_prew'])-4,4)=="</p>") 
				$temp[$i]['new_prew'] = substr($temp[$i]['new_prew'], 0, strlen($temp[$i]['new_prew'])-4);
			echo $temp[$i]['new_prew'].'... »</a></p></div>';
		}
	}

	function eShowLastNews($count=0, $cond=1) {
		global $Global;
		$res='';
		if ($count) {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where $cond ORDER BY new_date DESC LIMIT $count");
		} else {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where $cond ORDER BY new_date DESC");
		}
		
		if (!$temp) $res.='Нет новостей за данный период';
		
		foreach ($temp as $i=>$row) {
			
			$res.='<font class="date">'.(date("d.m.Y", $temp[$i]['new_date'])).'</font> <div class="new_text"><a href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'">';
			$res.=$temp[$i]['new_prew'].'... »</a></div>';
		}
		
		return $res;
	}
	
	function aShowLastNews($count=0, $cond=1) {
		global $Global;
		$res='';
		if ($count) {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where $cond ORDER BY new_date DESC LIMIT $count");
		} else {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} where $cond ORDER BY new_date DESC");
		}
		
		if (!$temp) $res.='Нет новостей за данный период';
		else
		foreach ($temp as $i=>$row) {
			
			$res.='<font class="date">'.(date("d.m.Y", $temp[$i]['new_date'])).'</font> <div class="new_text">
			<a OnClick="ShowNew('.$temp[$i]['new_id'].'); return false;"
			href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'">';
			$res.=$temp[$i]['new_prew'].'... »</a></div>';
		}
		
		return $res;
	}

	function ShowAllNews($count=0, $flag = 1) {
		global $Global;
		
		if ($count) {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY new_date DESC LIMIT $count");
		} else {
			$temp = $this->DB->ReadAss("SELECT * FROM {$this->NTable} ORDER BY new_date DESC");
		}
		
		$count = count($temp);
		
		if ($flag) echo '<h2>Последние новости</h2>';
		echo'
		<div id="last_news_left">
			<div class="last_news_content" align="left">';
		
		for ($i=0; $i<(int)($count/2)+$count%2; $i++) {
			
			echo '<p><font class="date">'.(date("d/m/Y", $temp[$i]['new_date'])).'</font> <a href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'">'.$temp[$i]['new_name'].'</a><br />';
			if (substr($temp[$i]['new_prew'],strlen($temp[$i]['new_prew'])-4,4)=="</p>") 
				$temp[$i]['new_prew'] = substr($temp[$i]['new_prew'], 0, strlen($temp[$i]['new_prew'])-4);
			echo $temp[$i]['new_prew'].'&nbsp;<a href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'" title="Читать дальше"><img src="'.$Global['Host'].'/css/images/last_news_arrow.gif" width="8" height="7" alt="Читать дальше" /></a></p></p>';
		}
		
		echo'</div>	</div>
		<div id="last_news_right" align="right">
			<div class="last_news_content" align="left">';
			
		for ($i=(int)($count/2)+$count%2; $i<$count; $i++) {
			
			echo '<p><font class="date">'.(date("d/m/Y", $temp[$i]['new_date'])).'</font> <a href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'">'.$temp[$i]['new_name'].'</a><br />';
			if (substr($temp[$i]['new_prew'],strlen($temp[$i]['new_prew'])-4,4)=="</p>") 
				$temp[$i]['new_prew'] = substr($temp[$i]['new_prew'], 0, strlen($temp[$i]['new_prew'])-4);
			echo $temp[$i]['new_prew'].'&nbsp;<a href="'.$Global['Host'].'/news/'.$temp[$i]['new_id'].'" title="Читать дальше"><img src="'.$Global['Host'].'/css/images/last_news_arrow.gif" width="8" height="7" alt="Читать дальше" /></a></p></p>';
		}
		echo'	</div>
		</div>';
		
	}
	
	function ReadYears() {
		
		$last_year = $this->DB->ReadScalar('select new_date from news order by new_date desc limit 1');
		$last_year = date('Y',$last_year);
		
		
		$first_year = $this->DB->ReadScalar('select new_date from news order by new_date  limit 1');
		$first_year = date('Y',$first_year);
		
		
		$res = array();
		
		
		for ($i = $first_year; $i<= $last_year; $i++) {
			$res[] = $i;
		}
		
		return $res;
	}
	
}

?>