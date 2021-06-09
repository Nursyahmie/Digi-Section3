<?php
  if(isset($_POST["zipButton"])){
  
    $display='';
    if($_FILES['zipFile']['name'] != ''){
    
      $fileName=$_FILES['zipFile']['name'];
      $array=explode(".",$fileName);
      $name=$array[0];
      $extension=$array[1];
      if($extension=='zip'){
        $path='upload/';
        $fileLocation=$path.$fileName;
        if(move_uploaded_file($_FILES['zipFile']['tmp_name'],$fileLocation)){
          $zip = new ZipArchive();

          if($zip->open($fileLocation)){

            $zip->extractTo($path . $name);
            $zip->close();
          }
          $files=scandir($path.$name);
          foreach($files as $picture){
            $tmp = explode(".",$picture);
            $fileExtension = end($tmp);
            #$fileExtension=end(explode(".",$picture));
            $allowedExtension=array('jpg','png');
            if(in_array($fileExtension,$allowedExtension)){
              $new=md5(rand()).'.'.$fileExtension;

              $display .='<div><img src="upload/'.$new.'" width="200" height="200" /></div>';
              copy($path.$name.'/'.$picture,$path.$new);
              unlink($path.$name.'/'.$picture);
            }
          }
          gc_collect_cycles();
          @unlink($fileName);
          rmdir($path.$name);

        }
      }

    }
  }

?>



<html lang="en"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Engineering Internship Assessment</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="Digi-X Internship Committee">

  <link rel="stylesheet" href="style.css?v=1.0">
  <link rel="stylesheet" href="custom.css?v=1.0">

</head>

<body>

    <div class="top-wrapper">
        <img src="https://assets.website-files.com/5cd4f29af95bc7d8af794e0e/5cfe060171000aa66754447a_n-digi-x-logo-white-yellow-standard.svg" alt="digi-x logo" height="70">
        <h1>Engineering Internship Assessment</h1>
    </div>

    <div class="instruction-wrapper">
        <h2>What you need to do?</h2>
        <h3 style="margin-top:31px;">Using this HTML template, create a page that can:</h3>
        <ol>
            <li><b class="yellow">Upload</b> a zip file - containing 5 images (Cats, or Dogs, or even Pokemons)</li>
            <li>after uploading, <b class="yellow">Extract</b> the zip to get the images </li>
            <li><b class="yellow">Display</b> the images on this page</li>
        </ol>

        <h2 style="margin-top:51px;">The rules?</h2>
        <ol>
            <li>May use <b class="yellow">any programming language/script</b>. The simplest the better *wink*</li>
            <li><b class="yellow">Best if this project could be hosted</b></li>
            <li><b class="yellow">If you are not hosting</b>, please provide a video as proof (GDrive video link is ok)</li>
            <li><b class="yellow">Submit your code</b> by pushing to your own github account, and share the link with us</li>
        </ol>
    </div>

    <!-- DO NO REMOVE CODE STARTING HERE -->
    <div class="display-wrapper">
        <h2 style="margin-top:51px;">My images</h2>

        <form   method="post" enctype="multipart/form-data">
          <input type="file" name="zipFile">
          <br>
          <input type="submit" name="zipButton" value="Upload">
        </form>

        <div class="append-images-here">

            <p>No image found. Your extracted images should be here.</p>
            <?php 

              if(isset($display)){
                echo $display;
              }

            ?>
            <!-- THE IMAGES SHOULD BE DISPLAYED INSIDE HERE -->
        </div>
    </div>
    <!-- DO NO REMOVE CODE UNTIL HERE -->


</body></html>