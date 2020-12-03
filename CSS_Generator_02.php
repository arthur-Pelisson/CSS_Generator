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