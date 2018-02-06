<?PHP
 // Define the path to file
 // $file = 'ryboe_tag_cloud.zip';
 $file = $_GET['f'];
 
 if(!file)
 {
     // File doesn't exist, output error
     die('file not found');
 }
 else
 {
 $f=pathinfo($file);
 $filename = $f['basename'];	
 $fileext = $f['extension'];
 	
     // Set headers
     header("Cache-Control: public");
     header("Content-Description: File Transfer");
     header("Content-Disposition: attachment; filename=$filename");
     header("Content-Type: application/$fileext");
     header("Content-Transfer-Encoding: binary");
    
     // Read the file from disk
     readfile($file);
 }
 ?>
