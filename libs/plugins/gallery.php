<?php

include('libs/timage.php');

class Gallery extends IntegratedDataBase {
	
	var $NTable 	= 'page_galleries';
	var $PageTable 	= 'pages';
	var $Object;
	var $Objects;
	var $ObjectsCount;
	
	function ReadAdditionalObject($ObjectID){
		if($ObjectID) {
			$this->Object = $this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE page_id='$ObjectID'",'*1');
		}
		else
			$this->Object = $this->DB->DescribeTable($this->NTable);
	}
	
}

class G_Member extends IntegratedDataBase {
	var $NTable 	= 'gal_members';
	var $Object;
	var $Objects;
	var $ObjectsCount;
	
	function ReadAll($gallery) {
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE pg_id=$gallery order by mem_id DESC");
	}
	
	function ReadOneObject($ObjectID){
		if($ObjectID) {
			$this->Object=$this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE mem_id='$ObjectID'",'*1');
			
		}
		else
			$this->Object=$this->DB->DescribeTable($this->NTable);
	}
	
	function Edit($SectionID, $page_id) {
		global $Global;
		global $HTTP_POST_FILES;
		global $HTTP_POST_VARS;
		$Vars = $HTTP_POST_VARS;
		
		$Delete = $Vars['delete'];
		unset($Vars['delete']);
		
		$File = $HTTP_POST_FILES['mem_file'];
		
		$Image = new ImageResizer();
		
		$MemVars = array();
		
		$MemVars['pg_id'] = $Vars['pg_id'];
		$MemVars['mem_img_width'] = $Vars['mem_img_width'];
		$MemVars['mem_img_height'] = $Vars['mem_img_height'];
		$MemVars['mem_span_width'] = $Vars['mem_span_width'];
		$MemVars['mem_span_height'] = $Vars['mem_span_height'];
		$MemVars['mem_href'] = $Vars['mem_href'];
		$MemVars['mem_text'] = trim($Vars['mem_text']);
		$MemVars['mem_name'] = $Vars['mem_name'];
		
		$ObjectID = (int)$Vars['mem_id'];
		
		if(!$ObjectID){
				
			$this->DB->EditDB($MemVars,$this->NTable);
			$ObjectID = $this->DB->LastInserted;
			
			if ($Vars['url_type']) {
				$this->DB->EditDB(array('mem_href'=>$Global['Host'].'/'.$Global['Gallery.Image.Dir'].'/'.$ObjectID.'.png'),$this->NTable,'mem_id='.$ObjectID);
			}
			
			if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
				
				copy($File['tmp_name'], $Global['Gallery.Image.Dir'].'/'.$ObjectID.'.png');
				$Image->ResizeOutImage($File['tmp_name'], $Global['Gallery.ImageSmall.Dir'].'/'.$ObjectID.'.png', $MemVars['mem_img_width'], $MemVars['mem_img_height'], 'png');
			
			} else {
				if ($File['size'] >= $Global['File.MaxSize']) {
						$Errors['mem_file'] = $Global['Big File'];
				} else 	$Errors['mem_file'] = $Global['Error File'];
			}
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID/$page_id/$ObjectID/#g_elements");
		}
		//edit
		elseif($ObjectID&&!$Delete){
			
			if ($Vars['url_type']) {
				$MemVars['mem_href'] = $Global['Host'].'/'.$Global['Gallery.Image.Dir'].'/'.$ObjectID.'.png';
			}
			
			$this->DB->EditDB($MemVars,$this->NTable,"mem_id='$ObjectID'");
			
			if ($File) {
			
				if (!(int)$File['error'] && file_exists($File['tmp_name']) && $File['size'] < $Global['File.MaxSize']) {
					
					copy($File['tmp_name'], $Global['Gallery.Image.Dir'].'/'.$ObjectID.'.png');
					$Image->ResizeOutImage($File['tmp_name'], $Global['Gallery.ImageSmall.Dir'].'/'.$ObjectID.'.png', $MemVars['mem_img_width'], $MemVars['mem_img_height'], 'png');
				
				} else {
					if ($File['size'] >= $Global['File.MaxSize']) {
							$Errors['mem_file'] = $Global['Big File'];
					} else 	$Errors['mem_file'] = $Global['Error File'];
				}
			}
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID/$page_id/$ObjectID/#g_elements");
		}
		//delete
		elseif($ObjectID&&$Delete){
			$this->DB->DeleteDB($this->NTable, 'mem_id=' . $ObjectID);
			unlink($Global['Gallery.ImageSmall.Dir'].'/'.$ObjectID.'.png');
			unlink($Global['Gallery.Image.Dir'].'/'.$ObjectID.'.png');
			
			$this->Go("{$Global['Host']}/edit_pages/$SectionID/$page_id");
		}
	}
	
	function ReadLastItems($gallery_id, $limit) {
		
		$lim = ($limit)?('LIMIT '.$limit):('');
		
		$this->Objects = $this->DB->ReadAss("SELECT * FROM {$this->NTable} WHERE pg_id=$gallery_id order by mem_id DESC $lim");
	}

}

$GALLERY = new Gallery($DB);
$G_MEMBER = new G_Member($DB);

$Global['Gallery.Image.Dir'] = 'images/gallery/normal';
$Global['Gallery.ImageSmall.Dir'] = 'images/gallery/small';
$Global['Gallery.Span.Color'] = '#AADBF5';
$Global['Gallery.Span.Border'] = '2px #95C6E0 solid';
?>