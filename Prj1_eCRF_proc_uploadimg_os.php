<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
if(!isset($_SESSION['collID']) || !isset($_SESSION['collName'])) {
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}

define('testtest', 123);

define('SPINE', "1");
define('RTHIP', "2");
define('LTHIP', "3");
define('RESIZE_X', 852);
define('RESIZE_Y', 1100);
define('MEASURED_DATE_W', 79);
define('MEASURED_DATE_H', 16);
define('MEASURED_DATE_X', 555);
define('MEASURED_DATE_Y', 161);
define('PATIENT_ID_W', 64);
define('PATIENT_ID_H', 20);
define('PATIENT_ID_X', 554);
define('PATIENT_ID_Y', 125);
define('PATIENT_NAME_W', 51);
define('PATIENT_NAME_H', 20);
define('PATIENT_NAME_X', 182);
define('PATIENT_NAME_Y', 125);
define('BIRTHDATE_W', 74);
define('BIRTHDATE_H', 16);
define('BIRTHDATE_X', 182);
define('BIRTHDATE_Y', 145);
define('PATIENT_HEIGHT_W', 39);
define('PATIENT_HEIGHT_H', 17);
define('PATIENT_HEIGHT_X', 182);
define('PATIENT_HEIGHT_Y', 162);
define('PATIENT_WEIGHT_W', 33);
define('PATIENT_WEIGHT_H', 16);
define('PATIENT_WEIGHT_X', 254);
define('PATIENT_WEIGHT_Y', 162);
define('GENDER_W', 50);
define('GENDER_H', 17);
define('GENDER_X', 182);
define('GENDER_Y', 178);

$spineVals = array(array(array(133,42,369,147), array(133,42,369,189), array(133,42,369,232), array(133,42,369,275), array(133,42,369,317),
						 array(133,42,369,360),array(133,42,369,404),array(133,42,369,447),array(133,42,369,489), array(133,42,369,533)),

						array(array(115,42,748,147),array(115,42,748,189),array(115,42,748,232),array(115,42,748,275),array(115,42,748,317),
						array(115,42,748,360),array(115,42,748,404),array(115,42,748,447),array(115,42,748,489),array(115,42,748,533)),

						array(array(115,42,1064,147),array(115,42,1064,189),array(115,42,1064,232),array(115,42,1064,275),array(115,42,1064,317),
						array(115,42,1064,360),array(115,42,1064,404),array(115,42,1064,447),array(115,42,1064,489),array(115,42,1064,533)));
						
$rHipVals = array(array(array(133,42,369,147),array(133,42,369,189),array(133,42,369,232),array(133,42,369,275)),
						array(array(115,42,748,147),array(115,42,748,189),array(115,42,748,232),array(115,42,748,275)),
						array(array(115,42,1064,147),array(115,42,1064,189),array(115,42,1064,232),array(115,42,1064,275)));
						
$lHipVals = array(array(array(133,42,369,147),array(133,42,369,189),array(133,42,369,232),array(133,42,369,275)),
						array(array(115,42,748,147),array(115,42,748,189),array(115,42,748,232),array(115,42,748,275)),
						array(array(115,42,1064,147),array(115,42,1064,189),array(115,42,1064,232),array(115,42,1064,275)));

include "./include/ImageResize.php";
use \Gumlet\ImageResize;

$user_id = $_SESSION['collID'];

$ds = DIRECTORY_SEPARATOR;

$part = $_POST['parts'];
if($part == "1"){
	$storeFolder = './uploadimages/OS/DXA/spine';
}else if($part == "2"){
	$storeFolder = './uploadimages/OS/DXA/rhip';
}else if($part == "3"){
	$storeFolder = './uploadimages/OS/DXA/lhip';
}else if($part == "4"){
	$storeFolder = './uploadimages/OS/XRAY/spine';
}else if($part == "5"){
	$storeFolder = './uploadimages/OS/XRAY/rhip';  
}else if($part == "6"){
	$storeFolder = './uploadimages/OS/XRAY/lhip';
}else{
	die("ERROR:no parts");
}

$patSeqID = $_POST['patSeqID'];
$radioDate = $_POST['patShotDate'];

if(empty($patSeqID)){
	die("REJECT:<br>연구번호가 없습니다.");
}
 
if (!empty($_FILES)) {     
    $tempFile = $_FILES['file']['tmp_name'];          
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  
	$targetFileName = str_replace("-", "", $patSeqID)."_".$part."_res.jpg";	// make report file name
	
    $targetFile =  $targetPath. $targetFileName;
	
	echo $targetFile;
	
    if(move_uploaded_file($tempFile, $targetFile)){ // store report file
		procImage($part, $targetFile, $patSeqID);					
		echo "OK:";
	}else{
		echo "REJECT:<br>".$targetFile;
	}
}else{
	echo "ERROR: No target file";
}

//--- IMAGE CROP & SAVE -------------------------------------
function procImage($p, $imgfile, $patID){
	$tempfolder = "./imgworkspace/";
	$resizedImg = $tempfolder."resized.jpg";
	
	//--- MEASURED DATE -------------------------------------
	$dateImg = $tempfolder."measuredate.jpg";
	$scaleUpDateImg = $tempfolder."scaleupdate.jpg";
	$grayBlurDateImg = $tempfolder."grayblurdate.jpg";
	//-------------------------------------------------------
	
	//--- PATIENT ID ----------------------------------------
	$cropPIDImg = $tempfolder."temp_pid.jpg";
	$scaleUpPIDImg = $tempfolder."temp_scaleuppid.jpg";
	$grayBlurPIDImg = $tempfolder."grayblurpid.jpg";
	//-------------------------------------------------------
	
	//--- PATIENT NAME --------------------------------------
	$cropNameImg = $tempfolder."temp_name.jpg";
	$scaleUpNameImg = $tempfolder."temp_scaleupname.jpg";
	$grayBlurNameImg = $tempfolder."grayblurname.jpg";
	//-------------------------------------------------------
	
	//--- BIRTHDATE -----------------------------------------
	$cropBirthImg = $tempfolder."temp_birth.jpg";
	$scaleUpBirthImg = $tempfolder."temp_scaleupbirth.jpg";
	$grayBlurBirthImg = $tempfolder."grayblurbirth.jpg";
	//-------------------------------------------------------
	
	//--- HEIGHT --------------------------------------------
	$cropHeightImg = $tempfolder."temp_height.jpg";
	$scaleUpHeightImg = $tempfolder."temp_scaleupheight.jpg";
	$grayBlurHeightImg = $tempfolder."grayblurheight.jpg";
	//-------------------------------------------------------
	
	//--- WEIGHT --------------------------------------------
	$cropWeightImg = $tempfolder."temp_weight.jpg";
	$scaleUpWeightImg = $tempfolder."temp_scaleupweight.jpg";
	$grayBlurWeightImg = $tempfolder."grayblurweight.jpg";
	//-------------------------------------------------------
	
	//--- GENDER --------------------------------------------
	$cropGenderImg = $tempfolder."temp_gender.jpg";
	$scaleUpGenderImg = $tempfolder."temp_scaleupgender.jpg";
	$grayBlurGenderImg = $tempfolder."grayblurgender.jpg";
	//-------------------------------------------------------
	
	//--- RESULT TABLE --------------------------------------
	$cropTableImg = $tempfolder."temp_table.jpg";
	$scaleUpTableImg = $tempfolder."temp_scaleuptable.jpg";
	$grayBlurTableImg = $tempfolder."temp_grayblur.jpg";
	//-------------------------------------------------------
	
	$xrayPath = "";
	
	if($p == SPINE){
		$xrayPath = "./uploadimages/OS/XRAY/spine/";
		$imgType = "4";
	}else if($p == RTHIP){
		$xrayPath = "./uploadimages/OS/XRAY/rhip/";
		$imgType = "5";
	}else if($p == LTHIP){
		$xrayPath = "./uploadimages/OS/XRAY/lhip/";
		$imgType = "6";
	}
	
	$xrayFname = str_replace("-", "", $patID)."_".$imgType."_dxa.jpg";	
	
//-- RESIZE TO 852X1100 --------------------------------------------
	$img = new ImageResize($imgfile);
	$img->quality_jpg = 100;		
	$img->resize(RESIZE_X, RESIZE_Y);
	$img->save($resizedImg);
//------------------------------------------------------------------	
	

//-- EXTRACTION MEASURED DATE AREA ---------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(MEASURED_DATE_W, MEASURED_DATE_H, MEASURED_DATE_X, MEASURED_DATE_Y);	// measured date
	$img->save($dateImg);
	$mdImg = new ImageResize($dateImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpDateImg);
	$im = imagecreatefromjpeg($scaleUpDateImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurDateImg);
	imagedestroy($im);		
	unlink($scaleUpDateImg);	// delete scale up table image
	unlink($dateImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION PATIENT ID AREA ------------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(PATIENT_ID_W, PATIENT_ID_H, PATIENT_ID_X, PATIENT_ID_Y);	// patient id date
	$img->save($cropPIDImg);
	$mdImg = new ImageResize($cropPIDImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpPIDImg);
	$im = imagecreatefromjpeg($scaleUpPIDImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurPIDImg);
	imagedestroy($im);		
	unlink($scaleUpPIDImg);	// delete scale up table image
	unlink($cropPIDImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION PATIENT NAME AREA ----------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(PATIENT_NAME_W, PATIENT_NAME_H, PATIENT_NAME_X, PATIENT_NAME_Y);	// patient name 
	$img->save($cropNameImg);
	$mdImg = new ImageResize($cropNameImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpNameImg);
	$im = imagecreatefromjpeg($scaleUpNameImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurNameImg);
	imagedestroy($im);		
	unlink($scaleUpNameImg);	// delete scale up table image
	unlink($cropNameImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION BIRTHDATE AREA -------------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(BIRTHDATE_W, BIRTHDATE_H, BIRTHDATE_X, BIRTHDATE_Y);	// patient birth date name 
	$img->save($cropBirthImg);
	$mdImg = new ImageResize($cropBirthImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpBirthImg);
	$im = imagecreatefromjpeg($scaleUpBirthImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurBirthImg);
	imagedestroy($im);		
	unlink($scaleUpBirthImg);	// delete scale up table image
	unlink($cropBirthImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION HEIGHT AREA ----------------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(PATIENT_HEIGHT_W, PATIENT_HEIGHT_H, PATIENT_HEIGHT_X, PATIENT_HEIGHT_Y);	// patient height
	$img->save($cropHeightImg);
	$mdImg = new ImageResize($cropHeightImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpHeightImg);
	$im = imagecreatefromjpeg($scaleUpHeightImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurHeightImg);
	imagedestroy($im);		
	unlink($scaleUpHeightImg);	// delete scale up table image
	unlink($cropHeightImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION WEIGHT AREA ----------------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(PATIENT_WEIGHT_W, PATIENT_WEIGHT_H, PATIENT_WEIGHT_X, PATIENT_WEIGHT_Y);	// patient weight
	$img->save($cropWeightImg);
	$mdImg = new ImageResize($cropWeightImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpWeightImg);
	$im = imagecreatefromjpeg($scaleUpWeightImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurWeightImg);
	imagedestroy($im);		
	unlink($scaleUpWeightImg);	// delete scale up table image
	unlink($cropWeightImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION GENDER AREA ----------------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(GENDER_W, GENDER_H, GENDER_X, GENDER_Y);	// patient birth date name 
	$img->save($cropGenderImg);
	$mdImg = new ImageResize($cropGenderImg);
	$mdImg->scale(300);
	$mdImg->save($scaleUpGenderImg);
	$im = imagecreatefromjpeg($scaleUpGenderImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurGenderImg);
	imagedestroy($im);		
	unlink($scaleUpGenderImg);	// delete scale up table image
	unlink($cropGenderImg);	// delete just cropped table image	
//------------------------------------------------------------------

//-- EXTRACTION X-RAY AREA --------------------------------
	$im = imagecreatefromjpeg($resizedImg);
	$cntStart = 0;
	$endEdge = 0;
	$cnt = 0;
	$found = false;
	$y = 440;
	$maxY = 650;
	
	while(!$found){
		$rgb = imagecolorat($im, 360, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8 ) & 0xFF;
		$b = $rgb & 0xFF;
		
		$gray = ($r + $g + $b) / 3;
		
		if($gray > 200){	// out of area			
			if(($cntStart == 0) && ($cnt == 0)){
				$cntStart = 1;
				$endEdge = $y;
			}
			$cnt++;			
			if($cnt > 20){
				$found = true;
			}
		}else{
			$endEdge = 0;
			$cntStart = 0;
			$cnt = 0;
		}	
		
		$y++;
		
		if($y >= $maxY){
			$endEdge = $maxY;
			$found = true;
		}
	}
	
	imagedestroy($im);
	
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	$img->freecrop(328, ($endEdge-215), 42, 215);	// measured date
	$img->save($xrayPath.$xrayFname);
//------------------------------------------------------------------
	
//-- EXTRACTION RESULT TABLE AREA ----------------------------------
	$img = new ImageResize($resizedImg);
	$img->quality_jpg = 100;		
	
	if($p == SPINE){
		$img->freecrop(411, 196, 382, 455);	// spine BMD table area
	}else{	
		$img->freecrop(411, 109, 382, 455);	// R or L hip BMD table	area
	}
	
	$img->save($cropTableImg);
	$tabImg = new ImageResize($cropTableImg);
	$tabImg->scale(300);
	$tabImg->save($scaleUpTableImg);		
	unlink($cropTableImg);	// delete just cropped table image
	
	$im = imagecreatefromjpeg($scaleUpTableImg);
	imagefilter($im, IMG_FILTER_GRAYSCALE);
	imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
	imagejpeg($im, $grayBlurTableImg);
	imagedestroy($im);		
	unlink($scaleUpTableImg);	// delete scale up table image
//------------------------------------------------------------------
	
//-- EXTRACTION VALUES FROM TABLE ----------------------------------	
	$extValImg = new ImageResize($grayBlurTableImg);	
	if($p == SPINE){	// case for spine
		for($col = 0; $col < 3; $col++)
		{
			for($row = 0 ; $row <10 ; $row++){
				$extValImg
					->freecrop($spineVals[$row][$col][0],$spineVals[$row][$col][1],$spineVals[$row][$col][2],$spineVals[$row][$col][3])
					->save("./imgworkspace/spval".$row.$col.".jpg");				
			}
		}
	}else if($p == RTHIP){	// case for right hip
		for($col = 0; $col < 3; $col++)
		{
			for($row = 0 ; $row <4 ; $row++){
				$extValImg
					->freecrop($rHipVals[$row][$col][0],$rHipVals[$row][$col][1],$rHipVals[$row][$col][2],$rHipVals[$row][$col][3])
					->save("./imgworkspace/rlval".$row.$col.".jpg");				
			}
		}	
	}else if($p == LTHIP){	// case for left hip
		for($col = 0; $col < 3; $col++)
		{
			for($row = 0 ; $row <4 ; $row++){
				$extValImg
					->freecrop($lHipVals[$row][$col][0],$lHipVals[$row][$col][1],$lHipVals[$row][$col][2],$lHipVals[$row][$col][3])
					->save("./imgworkspace/lhval".$row.$col.".jpg");				
			}
		}	
	}
//------------------------------------------------------------------	
	unlink($grayBlurTableImg);	
}
?> 