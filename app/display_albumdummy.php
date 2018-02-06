<?php
require_once('../bootstrap.php');

$pix_count=2; $pix_size=0;
//$pix = "this folder: ".CONFIG_DATA_URL ."litratuwaan/$folder/ contains:<BR><BR>";
$pix_count=0; $pix_size=0;
$pix = "this folder: ".CONFIG_DATA_URL ."litratuwaan/$folder/ contains:<BR><BR>";
	if ($handle = opendir(CONFIG_DATA_PATH . "litratuwaan/$folder/")) {
	    while (false !== ($file = readdir($handle))) {
	        if ($file != "." && $file != "..") {
			$filename[$pix_count] = $file;			
			$pix_count++;	
			$pix_size = $pix_size + filesize(CONFIG_DATA_PATH."litratuwaan/$folder/$file");
	        }
	    }
	    closedir($handle);
	}

	$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=75&height=75&cropratio=1:1&image=".CONFIG_IMG_URL."pisbuk/icon_video.jpg";
	$pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=70&height=70&cropratio=1:1&image=".CONFIG_IMG_URL."pisbuk/icon_pdf.gif";

	$pix .= "<table>";	

	//10 years after
	$youtube1 = "http://www.youtube.com/watch?v=ezlUOYb9J2k";

//	$download1 = CONFIG_DATA_URL ."litratuwaan/$folder/pisay91_tenyearsafter_xvid_720p.avi";
	$download1= CONFIG_LIB_URL ."model/fd.php?f=".CONFIG_DATA_PATH."litratuwaan/$folder/pisay91_tenyearsafter_xvid_720p.avi";
	$pix .= "<tr><td><img src=\"$pic1\" /></td>";
	$pix .= "<td><h2>Pisay 91: Ten Years After</h2><blockquote>xvid, 1280x720, 00:04:42, 65.3 Mb<br><a href=\"$download1\" title=\"Download Here\">download</a> - <a href=\"$youtube1\" rel=\"Litratuwaan[$folder]\" title=\"Pisay 91: Ten Years After\">youtube</a></blockquote></td></tr> ";

	//Decade & Nine
	$youtube2 = "http://www.youtube.com/watch?v=-AjlUP6UWMc";
	$download2= CONFIG_LIB_URL ."model/fd.php?f=".CONFIG_DATA_PATH."litratuwaan/$folder/pisay91_decadeandnine_xvid_mp3_720p.avi";
	$pix .= "<tr><td><img src=\"$pic1\" /></td>";
	$pix .= "<td><h2>Pisay 91: A Decade And Nine</h2><blockquote>xvid, 1280x720, 00:03:47, 58.5 Mb<br><a href=\"$download2\" title=\"Download Here\">download</a> - <a href=\"$youtube2\" rel=\"Litratuwaan[$folder]\" title=\"Pisay 91: A Decade And Nine\">youtube</a></blockquote></td></tr>";

	//Research Abstracts
	$download3= CONFIG_LIB_URL ."model/fd.php?f=".CONFIG_DATA_PATH."litratuwaan/$folder/pisay91_research_abstracts.pdf";
	$pix .= "<tr><td><img src=\"$pic2\" /></td>";
	$pix .= "<td><h2>Research Abstracts</h2><blockquote>pdf, 26 pages, 208 Kb<br><a href=\"$download3\" title=\"Download Here\">download</a></td></tr>";

	//In Retrospect
	$download4= CONFIG_LIB_URL ."model/fd.php?f=".CONFIG_DATA_PATH."litratuwaan/$folder/pisay91_in_retrospect.pdf";
	$pix .= "<tr><td><img src=\"$pic2\" /></td>";
	$pix .= "<td><h2>In Retrospect</h2><blockquote>pdf, 15 pages, 2.88 Mb<br><a href=\"$download4\" title=\"Download Here\">download</a></td></tr>";

	$pix .= "</table>";	
	

//echo $pix;

$SFM->assign( 'pix',$pix );
$display_album = $SFM->fetch('item_album.htm');

?>