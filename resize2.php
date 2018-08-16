<?
	include('exif.php');
$ar=[];
//$dir=".";
$dirs="ss/";
$diro="oo/";
$dirb="bb/";
$flist=$dirb."flist.txt";
if(!is_dir($dirs))	mkdir($dirs);
if(!is_dir($diro))	mkdir($diro);

function imagesharpe($image) {
    // Matrix lower shaper but take space 16 is medium
    $sharpen = array(
        array(-1, -1,  -1),
        array(-1, 13, -1),
        array(-1, -1,  -1),
    ); 
    // Calculate the sharpen divisor
    $divisor = array_sum(array_map('array_sum', $sharpen)); 
    // Apply matrix
    imageconvolution($image, $sharpen, $divisor, 0);
}
function resizeimg($images,$mod=0){
	//$images= $_GET['img'];
	//if (!$images) $images = "a.jpg";
	//$images= $_GET['img'];	
	$file_parts = pathinfo($images);
	$file_parts['extension'];
	$cool_extensions = Array('jpg','png',"JPG");
	if (!in_array($file_parts['extension'], $cool_extensions)) { echo "$images not image<br>";return;}
	echo $images;
	//exit;
	$cext=explode(".",$images);
	$new_images = $images."_s";//nmygirl.jpg";
	$new_images = $cext[0]."_s.".$cext[1];//nmygirl.jpg";
	$ss="";
	$imageso="oo/".$images;
	$dirs="ss/";
	$new_images = $dirs.$images;//nmygirl.jpg";
	echo " >".$new_images;
	
	//if (!$images) exit;
	$width=268 ; //*** Fix Width & Heigh (Autu caculate) ***//
	//$height=960;
	$size=GetimageSize($imageso);
	$height=round($width*$size[1]/$size[0]);
	$images_orig = ImageCreateFromJPEG($imageso);
	$photoX = ImagesX($images_orig);
	$photoY = ImagesY($images_orig);
	$images_fin = ImageCreateTrueColor($width, $height);
	 //ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);	
	 ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1,$height+1,  $photoX, $photoY);	
	// $md=img_fix_rot($images_fin);
	//if ($md=1) {ImageCopyResampled($images_fin, $images_orig, 100,100 110, 0, 0, $width+1, $height+1, $photoX, $photoY);	
	 // $image = imagecreatefromjpeg($images_fin);
//$ix = ImageCreateFromJPEG($images_fin,90);	
//$image = imagecreatefromjpeg($images_fin);

	 // imagejpeg($image, $filename, 90);
	//}
	// Apply function
	imagesharpe($images_fin);
	//if(!is_dir($ss))	mkdir($ss);
	//if(!is_dir($oo))	mkdir($oo);
	$new_images = $dirs.$images;//nmygirl.jpg";
	echo "<br>".$new_images."<br>";
	$oi = "".$imageso;//nmygirl.jpg";
	ImageJPEG($images_fin,$new_images,100);
	list($width, $height, $type, $attr) = getimagesize($oi);
	echo "[$oi]$width:$height";
	$verbose=0;
	$result = read_exif_data_raw($oi,$verbose);	
echo "<PRE>"; 
$model=$result['IFD0']['Model'];
print_r($result);
echo "</PRE>"; 
//$model = 'How are you?';
// $cool_model = Array('Cannon','Redmi'); //next fixed 
//temp check if not in lib	
if ((strpos($model, 'Canon') !== false) || (strpos($model, 'Redmi') !== false)) {
    echo 'true'.$model;
	if ($result['IFD0']['Orientation']=="Normal (O deg)")
	{
		$image = imagecreatefromjpeg($new_images);
		$imag2e = imagerotate($image, 0, -1);
		imagejpeg($image, $new_images, 90); //compress
	}
	if ($result['IFD0']['Orientation']=="90 deg CCW")
			{
		$image = imagecreatefromjpeg($new_images);
			//imagesharpe($image);
			$imag2e = imagerotate($image, -90, 0);
	
		 imagejpeg($imag2e, $new_images, 90);
	}
}
else 	if  (($result['IFD1']['Orientation']=="p") || ($result['IFD1']['Orientation']=="90 deg CCW"))
 {
		$image = imagecreatefromjpeg($new_images);
		$imag2e = imagerotate($image, 90, 0);
		 imagejpeg($imag2e, $new_images, 90);
		 //image_fix_orientation($imag2e);
		 echo $result['IFD1']['Orientation'];
		}
		else 
			{
		$image = imagecreatefromjpeg($new_images);
		$imag2e = imagerotate($image, 0, 0);
		 imagejpeg($image, $new_images, 90);
		 //image_fix_orientation($imag2e);
		}
		
		echo "::".$result['IFD1']['Orientation'].":";
	


	//$new_images = $ss."/".$images;//nmygirl.jpg";
	//ImageJPEG($images_fin,$new_images,100);
	ImageDestroy($images_orig);
	ImageDestroy($images_fin);
	return $new_images;
}

if (!file_exists($dirb)) mkdir ($dirb);
//if (!file_exists($flist)) touch($flist);
//if (filesize($flist)<1){
    $ffs = scandir($diro);	
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
    foreach($ffs as $ff){
		$ar[]=$ff;		
		if (!file_exists(($dirb.$ff))) touch($dirb.$ff);
		//file_put_contents ($flist,$ff. PHP_EOL,FILE_APPEND);		
	}
	//var_dump($ar);
    $ffs = scandir($dirb);	
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
    foreach($ffs as $ff){
		$ar[]=$ff;		
		//touch($dirb.$ff);
		echo $ff."<br>";
		if (!file_exists($dirs.$ff)) resizeimg($ff);
		if (file_exists($dirs.$ff)) unlink($dirb.$ff);
		//file_put_contents ($flist,$ff. PHP_EOL,FILE_APPEND);		
	}
	?>