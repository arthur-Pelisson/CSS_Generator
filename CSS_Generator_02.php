<?php
function list_dir($file)
{
	$tab_image = array();
	if (is_dir($file))
	{
		if($kira = opendir($file))
		{				
			while(false !== ($entry = readdir($kira)))
			{								
				if( $entry != '.' && $entry != '..' && preg_match('#\.(png)$#i', $entry))
				{
					$size = getimagesize($file."/".$entry);
					$tab_image [$file."/".$entry]= $size;
				}	
			}
		}
	}return($tab_image); 
}
// list_dir("Kira");

// function sprite_img($file,$lastname="sprite.png")
// {	
// 	$tab_images = list_dir($file);
// 	$max_height = 0;
// 	$max_width = 0;
// 	foreach ($tab_images as $key => $value) 
// 	{
// 		$width = $value[0];
// 		$height = $value[1];
// 		if($height > $max_height)
// 		{	
// 			$max_height = $height;
// 		}
// 		$max_width += $width ;	
// 		}
// 	$sprite = imagecreatetruecolor($max_width,$max_height); 
// 	$max_x = 0;
// 	foreach ($tab_images as $key => $value) 
// 	{
// 	$width = $value[0];
// 	$height = $value[1];
// 	$img_1 = imagecreatefrompng($key);	 	
// 	imagecopy($sprite,$img_1,$max_x, 0,0,0,$width,$height);
// 	$max_x += $width;
// 	}
// 	imagepng($sprite,$lastname);
	
// }

//  function generate_css($file,$last_css="style.css")
// {	
// 	$open = fopen($last_css,"w+");
// 	$max_x = 0;
// 	$tab_images=list_dir($file); 
// 	foreach ($tab_images as $key => $value) 
// 	{	
// 		$nom = basename($key);
// 		$nom2 =  substr($nom,0,strpos($nom,".")-4);
// 		$width = $value[0];
// 		$height = $value[1];

// 		fwrite($open,"#".$nom2. "{\n\twidth : ".$width."px;\n\theight : ".$height."px;\n\tbackground-position: 0px -".$max_x."px;\n}\n" );
// 		$max_x += $width;
// 	}  
// } 