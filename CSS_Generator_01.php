#!/usr/bin/php
<?php

include'CSS_Generator_02.php';

// les argument ne sont pas fini
function argument($argv)
{	
	// var_dump($argv);
	foreach ($argv as $key => $value) 
	{	
		$argc = count($argv) - 1;
		// var_dump($argc);
		if ($argv[1] === "-r")
		{
			list_dir_r($argv[$argc]);
			if ($argv[2] === "-i")
			{
				sprite_img($argv[$argc], $argv[3]);
				if ($argv[4] === "-s")
				{
					generate_css($argv[$argc], $argv[5]);
					break;
				}
				else
				{
					break;
				}
			}
			elseif ($argv[2] === "-s")
			{
				generate_css($argv[$argc]);
				if ($argv[3] === "-i")
				{
					sprite_img($argv[$argc], $argv[4]);
					break;
				}
				else
				{
					break;
				}
			}
			else
			{
				break;
			}
		}
		elseif ($argv[1] === "-i")
		{
			sprite_img($argv[$argc], $argv[2]);
			if ($argv[3] === "-r")
			{
				list_dir_r($argv[$argc]);
				if ($argv[4] === "-s")
				{
					generate_css($argv[$argc], $argv[5]);
					break;
				}
				else
				{
					break;
				}
			}
			elseif ($argv[3] === "-s")
			{
				generate_css($argv[$argc], $argv[4]);
				if ($argv[5] === "-r")
				{
					list_dir_r($argv[$argc]);
					break;
				}
				else
				{
					break;
				}
			}
			else
			{
				break;
			}
		}
		elseif ($argv[1] === "-s")
		{
			generate_css($argv[$argc], $argv[2]);
			if ($argv[3] === "-r")
			{
				list_dir_r($argv[$argc]);
				if ($argv[4] === "-i")
				{
					sprite_img($argv[$argc], $argv[5]);
					break;
				}
				else
				{
					break;
				}
			}
			elseif ($argv[3] === "-i")
			{
				sprite_img($argv[$argc], $argv[4]);
				if ($argv[5] === "-r")
				{
					list_dir_r($argv[$argc]);
					break;
				}
				else
				{
					break;
				}
			}
			else
			{
				break;
			}
		}
		else
		{
			list_dir($argv[$argc]);
			sprite_img($argv[$argc]);
			generate_css($argv[$argc]);
			break;
		}
	}	
}
argument($argv);


// cherche les image png en recursive dans le dossier donnée et mets les image png dans un tableau
function list_dir_r($file)
{
	$tab_image = array();
	if (is_dir($file))
	{
		if($img = opendir($file))
		{				
			while(false !== ($entry = readdir($img)))
			{								
				if (is_dir($file."/".$entry) && $entry != '.' && $entry != '..'  )	
				{	
					$tab_image = array_merge ($tab_image,list_dir_r($file."/".$entry));
				}
				elseif( $entry != '.' && $entry != '..' && preg_match('#\.(png)$#i', $entry))
				{
					$size = getimagesize($file."/".$entry);
					$tab_image [$file."/".$entry] = $size;
				}	
			}
		}
	}return($tab_image); 
}
//crée une image vide et la remplis avec les image trouvée avec list_dir_r en calculant les taille des image
function sprite_img($file,$lastname="sprite.png")
{	
	if (array(list_dir_r($file)))
	{
		$tab_images = list_dir($file);
	}
	else
	{
		$tab_images = list_dir_r($file);
	}
	$max_height = 0;
	$max_width = 0;
	foreach ($tab_images as $key => $value) 
	{
		$width = $value[0];
		$height = $value[1];
		if($height > $max_height)
		{	
			$max_height = $height;
		}
		$max_width += $width ;	
	}
	$sprite = imagecreatetruecolor($max_width,$max_height); 
	$max_x = 0;
	foreach ($tab_images as $key => $value)
	{
		$width = $value[0];
		$height = $value[1];
		$img_1 = imagecreatefrompng($key);	 	
		imagecopy($sprite, $img_1, $max_x, 0, 0 ,0, $width, $height);
		$max_x += $width;
	}
	imagepng($sprite,$lastname);
	
}
// sprite_img_r("image");



// crée un fichier css et ecrit a l'interieure avec le stylsheet des image 
function generate_css($file,$last_css="style.css")
{	
	$open = fopen($last_css,"w+");
	$max_x = 0;
	if (array(list_dir_r($file)))
	{
		$tab_images = list_dir($file); 
	}
	else
	{
		$tab_images = list_dir_r($file);
	}
	foreach ($tab_images as $key => $value) 
	{	
		$nom = basename($key);
		$nom2 =  substr($nom,0,strpos($nom,".")-4);
		$width = $value[0];
		$height = $value[1];

		fwrite($open,"#".$nom2. "{\n\twidth : ".$width."px;\n\theight : ".$height."px;\n\tbackground-position: 0px -".$max_x."px;\n}\n" );
		$max_x += $width;
	}  
}
// generate_css("image");
 

