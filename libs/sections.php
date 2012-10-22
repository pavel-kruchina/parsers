<?php
class Section extends IntegratedDataBase {
	var $NTable = 'sections';
	var $Objects;
	var $Object;
	var $ObjectsCount;
	
	function ReadAll($parent_id) {
		
		$parent_id = (int) $parent_id;
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE parent_id=$parent_id ORDER BY section_name");
		
	}
	
	function ReadRealyAll() {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable}");
		
	}
	
	function ReadOneObject($ObjectID){
		if($ObjectID) {
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE section_id='$ObjectID'",'*1');
			
		}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);
	}
	
	function ReadObjectByPoint($point){
		/*if($ObjectID) {*/
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE section_point='$point'",'*1');
			
		/*}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);*/
	}
	
	function CheckVars(&$Vars) {
		global $Errors;
		global $Global;
				
		$Vars['section_name'] = $this->CleanTag($Vars['section_name']);
		$Vars['section_name'] = trim($Vars['section_name']);
		if ($Vars['section_name'] == '')
			$Errors['section_name'] = $Global['No value'];
		
		$Vars['section_point'] = $this->CleanEngStr($Vars['section_point']);
		$Vars['section_point'] = trim($Vars['section_point']);
		if ($Vars['section_point'] == '')
			$Errors['section_point'] = $Global['No point'];
		
		if (count($Errors)) return false;
		else 				return true;
	}
	
	function Edit() {
		global $HTTP_POST_VARS;
		global $Global;
		
		$Vars = $HTTP_POST_VARS;
		
		
		
		unset($Vars['sender']);
		
		$ObjectID = $Vars['section_id'];
		unset ($Vars['section_id']);
		
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		
		
		//add
		if(!$ObjectID){
			
			if (!$this->CheckVars($Vars)) {
				return;
			}
			
			$this->DB->EditDB($Vars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
	
			$this->Go("{$Global['Host']}/edit_pages/$ObjectID");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			if (!$this->CheckVars($Vars)) {
				return;
			}
			
			$this->DB->EditDB($Vars,$this->NTable,"section_id='$ObjectID'");
			$this->Go("{$Global['Host']}/edit_pages/$ObjectID");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'section_id=' . $ObjectID);
			$this->DB->DeleteDB('pages', 'section_id=' . $ObjectID);
			
			$this->Go("{$Global['Host']}/edit_pages");
		}
		
	}
	
	function ShowSection($section_point) {
		global $PAGE;
		global $Global;
		
		$this->ReadObjectByPoint($section_point);
		
		if (!$this->Object['section_name']) {
			$PAGE->ShowDefaultPage();
			return;
		}
		
		?><div id="menu" align="right">
	<ul>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>">Главная</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/news">Новости</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/about">О компании</a></li>
		<li><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/contacts">Контакты</a></li>
		<li  class="active" ><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/help">Справка</a></li>
		<li  class="last"><img src="<?php echo $Global['Host'] ?>/css/images/menu_arrow.gif" width="3" height="5" alt="" /><a href="<?php echo $Global['Host'] ?>/search">Поиск</a></li>
	</ul>
 </div>

 <div id="line_after_menu_left"></div>
 <div id="line_after_menu_right"></div>
 <div id="line_after_menu_bg"></div>
 <div id="line_after_menu_ln"></div>

 <div id="left">
 
 <div id="breadcrums">
		<a href="<?php echo $Global['Host'] ?>">Главная</a>&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo $this->Object['section_name'] ?>
	</div>
 
 <?php
		
		echo $this->Object['section_text'];
		$page = $HTTP_GET_VARS['page'];
		global $Global;
		
		$temp = $this->DB->ReadAss("SELECT pages.*, sections.section_name FROM pages, sections WHERE sections.section_point='$section_point' AND sections.section_id = pages.section_id ORDER BY page_name");
		$count = count($temp);		
		
		echo '<div id="number" align="center">';
		
		for ($i = 0; $i<=((int)($count/$Global['NewsOnPage.Count'])); $i++) {
			echo ' <a href="'.$Global['Host'].'/'.$section_point.'?page='.$i.'">'.($i+1).'</a> ';
		}
		
		echo '</div>';
		
		$start = $page*$Global['NewsOnPage.Count'];
		echo'
		<div id="all_news">';
		
		$i = 0;
		
		foreach ($temp as $row) {
			$i++;
			if ($i<=$start) continue;
			if ($i>$start+$Global['NewsOnPage.Count']) break;
			echo '<p > <a href="'.$Global['Host'].'/'.$section_point.'/'.$row['page_point'].'">'.$row['page_name'].'</a><br /><div class="new_text">';
			if (substr($row['page_prev'],strlen($row['page_prev'])-4,4)=="</p>") 
				$row['page_prev'] = substr($row['page_prev'], 0, strlen($row['page_prev'])-4);
			echo $row['page_prev'].'&nbsp;<a href="'.$Global['Host'].'/'.$section_point.'/'.$row['page_point'].'" title="Читать дальше"><img src="'.$Global['Host'].'/css/images/last_news_arrow.gif" width="8" height="7" alt="Читать дальше" /></a></p></div></p>';
		}
		
		echo'</div>';
		echo '<div id="number" align="center">';
		
		for ($i = 0; $i<=((int)($count/$Global['NewsOnPage.Count'])); $i++) {
			echo ' <a href="'.$Global['Host'].'/'.$section_point.'?page='.$i.'">'.($i+1).'</a> ';
		}
		
		echo '</div></div>';
	}
	
}
?>
