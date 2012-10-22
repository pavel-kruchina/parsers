<?php
class Search extends IntegratedDataBase {
	
	function MakeSearch($search_string) {
		$str = $this->CleanStr($search_string);
		
		$str = AddSlashes($str);
		
		$temp = explode(' ', $str);
		$str = '%'.implode('%',$temp).'%';
		
		$res = array('sections' => array(), 'pages' => array(), 'news' => array());
		
		$res['sections'] = $this->DB->ReadAss("SELECT * FROM sections WHERE section_name LIKE '$str' OR section_text LIKE '$str'");
		$res['pages'] = $this->DB->ReadAss("SELECT pages.*, sections.section_point FROM pages, sections WHERE (pages.page_name LIKE '$str' OR pages.page_text LIKE '$str') AND pages.section_id = sections.section_id");
		$res['news'] = $this->DB->ReadAss("SELECT * FROM news WHERE new_prew LIKE '$str' OR new_text LIKE '$str'");
		
		return $res;
	}
	
	function ShowSearch() {
		global $Global;
		global $HTTP_GET_VARS;
		
		$search = $this->MakeSearch($HTTP_GET_VARS['search_string']);
		echo '<h5 style="font-size: 17px">Вы искали сторку: '.$HTTP_GET_VARS['search_string'].'</h5><br />';
		echo '<h5 style="font-size: 17px">Разделы</h5>';
		if (count($search['sections'])) {
			foreach ($search['sections'] as $row)
				echo "<a href='{$Global['Host']}/{$row['section_point']}'>{$row['section_name']}</a><br />";
		} else echo'Не найдено разделов';
		echo '<h5 style="font-size: 17px">Страницы</h5>';
		if (count($search['pages'])) {
			foreach ($search['pages'] as $row)
				echo "<a href='{$Global['Host']}/{$row['section_point']}/{$row['page_point']}'>{$row['page_name']}</a><br />";
		} else echo'Не найдено страниц';
		echo '<h5 style="font-size: 17px">Новости</h5>';
		if (count($search['news'])) {
			foreach ($search['news'] as $row)
				echo "<a href='{$Global['Host']}/news/{$row['new_id']}'>".tstamp_to_date($row['new_date']).'</a><br />';
		} else echo'Не найдено новостей';
	}
	
}?>