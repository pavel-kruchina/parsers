<?php //������ ����� �������� ������ ��� ��������� �����������

class ImageResizer{
	var $InnerPadding;			//������� ���������� �������
	var $IPColor;						//���� ����������� �������
	var $JPGQuality;				//�������� JPG �����������.
	
	function ImageResizer(){
		global $Global;
		$this->JPGQuality=$Global['Images.Quality'];

		$SrcImage=imagecreatetruecolor(1,1);
		$this->IPColor=imageColorAllocate($SrcImage,255,255,255); //�� ���������, ���� ���� - ����������.
		$this->InnerPadding=0;
		ImageDestroy($SrcImage);
	}

	function ImageSize($Img){		//���������� ������������� �����, ���������� �������� width � height
		$Temp['Width']=ImageSX($Img); // �������������� - ������ � ������ ����������� $Img
		$Temp['Height']=ImageSY($Img);
		return $Temp;
	}

	//�������� �������. ��������� ��� ������ �� ��������� ������� �����������. ������������ ���������: $SrcFile(string) �������� ����.
	//$DstFile(string) - ������� ����. $SrcFile � $DstFile ����� ���������. $Width(int) - ��������� ������. $Height(int) - ��������� ������. $ResizeType(string) ��� �������: In ��� Out
	//$ImageFormat(string) - ��� �������� �����: jpg, gif, png.
	function ResizeImage($SrcFile, $DstFile, $Width, $Height, $ResizeType, $ImageFormat){
	
		$SrcImage = ImageCreateFromString(file_get_contents($SrcFile));
		$DstImage = ImageCreateTrueColor($Width, $Height);
	

		ImageFilledRectangle($DstImage,0,0,$Width-1, $Height-1,$this->IPColor);

		$DstX=$this->InnerPadding;
		$DstY=$this->InnerPadding;
		$DstWidth=$Width-(2*$this->InnerPadding);
		$DstHeight=$Height-(2*$this->InnerPadding);
		
		
		$Sizes=$this->ImageSize($SrcImage);

		if (strlen($ResizeType)==2){				//���� ����� ������� 'In'
			$CoefX=$Sizes['Width']/$DstWidth;
			$CoefY=$Sizes['Height']/$DstHeight;
			If($CoefX>$CoefY) {
				$SrcWidth=$DstWidth*$CoefY;		 //������� �����������, ���������� � ���������
				$SrcHeight=$DstHeight*$CoefY;
			}
			else {
				$SrcWidth=$DstWidth*$CoefX;
				$SrcHeight=$DstHeight*$CoefX;
			}
			$SrcX=($Sizes['Width']-$SrcWidth) / 2;	 //���������� �������� ������ ���� ��������� ���������
			$SrcY=($Sizes['Height']-$SrcHeight) / 2;
		}																		//���� ����� ������� 'Out'
		else{
			$SrcWidth=$Sizes['Width'];
			$SrcHeight=$Sizes['Height'];
			$CoefX=$Sizes['Width']/$DstWidth;
			$CoefY=$Sizes['Height']/$DstHeight;
			If($CoefX<$CoefY) {
				$DstWidth=floor($SrcWidth/$CoefY);		 //������� �����������, ���������� � ���������
				$DstHeight=floor($SrcHeight/$CoefY);
			}
			else {
				$DstWidth=floor($SrcWidth/$CoefX);		 //������� �����������, ���������� � ���������
				$DstHeight=floor($SrcHeight/$CoefX);
			}
			$SrcX=0;
			$SrcY=0;
			$DstX=($Width-$DstWidth)/2;
			$DstY=($Height-$DstHeight)/2;
		}


		ImageCopyResampled($DstImage,$SrcImage,$DstX,$DstY,$SrcX,$SrcY,$DstWidth,$DstHeight,$SrcWidth,$SrcHeight);

		$ImF=strtr($ImageFormat,'JPEGIFPN','jpegifpn'); //�������� ������ � "����������� ����" - �� ��������� ����.

		if (($ImF=="jpg")||($ImF=="jpeg")) ImageJpeg($DstImage,$DstFile,$this->JPGQuality);

		if ($ImF=='gif') ImageGif($DstImage,$DstFile);
		if ($ImF=='png') ImagePng($DstImage,$DstFile);

	}
	
	//���������������� ������� "��������" �������
	function ResizeOutImage($SrcFile, $DstFile, $Width, $Height, $ImageFormat){
		$this->ResizeImage($SrcFile, $DstFile, $Width, $Height, 'Out', $ImageFormat);
	}
	
	//���������������� ������� "�����������" �������
	function ResizeInImage($SrcFile, $DstFile, $Width, $Height, $ImageFormat){
		$this->ResizeImage($SrcFile, $DstFile, $Width, $Height, 'In', $ImageFormat);
	}
	//������� ��������� ������� �����������($SrcFile2) �� ������($SrcFile1).���� ����������� ����� �����, �� ������
	//����������� ������ ������������ ������ �������.
	Function MixImages($SrcFile1,$SrcFile2,$DstFile,$ImageFormat){
		$SrcImage1 = ImageCreateFromString(file_get_contents($SrcFile1));
		$SrcImage2 = ImageCreateFromString(file_get_contents($SrcFile2));
		$Sizes=$this->ImageSize($SrcImage1);
		$DstImage = ImageCreateTrueColor($Sizes['Width'], $Sizes['Height']);
		

		ImageCopyResampled($DstImage,$SrcImage1,0,0,0,0,$Sizes['Width'],$Sizes['Height'],$Sizes['Width'],$Sizes['Height']);
		ImageCopyResampled($DstImage,$SrcImage2,0,0,0,0,$Sizes['Width'],$Sizes['Height'],$Sizes['Width'],$Sizes['Height']);

		$ImF=strtr($ImageFormat,'JPEGIFPN','jpegifpn'); //�������� ������ � "����������� ����" - �� ��������� ����.
		if (($ImF=="jpg")||($ImF=="jpeg")) ImageJpeg($DstImage,$DstFile,$this->JPGQuality);

		if ($ImF=='gif') ImageGif($DstImage,$DstFile);
		if ($ImF=='png')
		{
		 ImagePng($DstImage,$DstFile);
		}


	}
	
	function ResizeInImageGray($SrcFile, $DstFile, $Width, $Height, $ImageFormat){
		$this->ResizeImage($SrcFile, $DstFile, $Width, $Height, 'In', $ImageFormat);
		
		$SrcImage1 = ImageCreateFromString(file_get_contents($DstFile));
		$DstImage = ImageCreateTrueColor($Width, $Height);
		
		imagecopymergegray($DstImage, $SrcImage1, 0, 0, 0, 0, $Width, $Height, 100);

		$ImF=strtr($ImageFormat,'JPEGIFPN','jpegifpn'); //�������� ������ � "����������� ����" - �� ��������� ����.
		if (($ImF=="jpg")||($ImF=="jpeg")) ImageJpeg($DstImage,$DstFile,$this->JPGQuality);

		if ($ImF=='gif') ImageGif($DstImage,$DstFile);
		if ($ImF=='png')
		{
		 ImagePng($DstImage,$DstFile);
		}
	}
	
	function ResizeOutImageGray($SrcFile, $DstFile, $Width, $Height, $ImageFormat){
		
		$this->ResizeImage($SrcFile, $DstFile, $Width, $Height, 'Out', $ImageFormat);
		
		$DstImage = ImageCreateFromString(file_get_contents($DstFile));
		
		$this->imagegreyscale($DstImage);
		
		$ImF=strtr($ImageFormat,'JPEGIFPN','jpegifpn'); //�������� ������ � "����������� ����" - �� ��������� ����.
		if (($ImF=="jpg")||($ImF=="jpeg")) ImageJpeg($DstImage,$DstFile,$this->JPGQuality);

		if ($ImF=='gif') ImageGif($DstImage,$DstFile);
		if ($ImF=='png')
		{
		 ImagePng($DstImage,$DstFile);
		}
	}
	
	function imagegreyscale(&$img, $dither=1) {    
	   if (!($t = imagecolorstotal($img))) { 
	       $t = 256; 
	       imagetruecolortopalette($img, $dither, $t);    
	   } 
	   
	   for ($c = 0; $c < $t; $c++) {    
	       $col = imagecolorsforindex($img, $c); 
	       $min = min($col['red'],$col['green'],$col['blue']); 
	       $max = max($col['red'],$col['green'],$col['blue']); 
	       $i = ($max+$min)/2; 
	       imagecolorset($img, $c, $i, $i, $i); 
		}
	}
	
	function ImToGray($SrcFile, $DstFile, $ImageFormat) {
		
		$Image = ImageCreateFromString(file_get_contents($SrcFile));
		$this->imagegreyscale($Image);
		
		$ImF=strtr($ImageFormat,'JPEGIFPN','jpegifpn'); //�������� ������ � "����������� ����" - �� ��������� ����.
		if (($ImF=="jpg")||($ImF=="jpeg")) ImageJpeg($Image,$DstFile,$this->JPGQuality);

		if ($ImF=='gif') ImageGif($Image,$DstFile);
		if ($ImF=='png')
		{
			ImagePng($Image,$DstFile);
		}
	}

};

?>
