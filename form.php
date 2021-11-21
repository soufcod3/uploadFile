<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'public/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['fileToUpdate']['name']);
    $extension = pathinfo($_FILES['fileToUpdate']['name'], PATHINFO_EXTENSION);
    $ipath = $uploadDir . uniqid() . "." . $extension;
    $authorizedExtensions = ['jpg','png', 'gif', 'webp'];
    $maxFileSize = 1000000;
   
    if (!in_array($extension, $authorizedExtensions)) {
        $errors['format'] = "Wrong format, please select a .jpg, .jpeg or .png file.";
    } 
    
    if (file_exists($_FILES['fileToUpdate']['tmp_name']) && filesize($_FILES['fileToUpdate']['tmp_name']) > $maxFileSize) {
        $errors['size'] = "Your file must weigh less than 2Mo.";
    }

    if (empty($errors)) {
        move_uploaded_file($_FILES['fileToUpdate']['tmp_name'], $ipath);
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Profile Picture</title>
</head>
<body>
<div class="idCard">
    <img class="bg" src="public/assets/img/logo.png" alt="">
    <h1 class="title">SPRINGFIELD, IL</h1>
    <div class="content">
        <div class="pictureAndDelete">
            <div class="picture"><?php
            if (isset($uploadFile) && isset($_FILES['fileToUpdate']['name'])) {
                if (empty($errors)) {
                    echo "<img class='uploadedImg' src='" . $ipath . "' alt='id picture'>";
                }
            } elseif (!isset($_POST['fileToUpdate'])) {
                echo "<img class='uploadedImg' src='public/assets/img/young_homer.jpg'alt='id picture'>";
            }
            ?></div>
        </div>
        <div class="info">
            <h2 class="title">DRIVERS LICENSE</h2>
            <div class="details">
                <h3>HOMER SIMPSON</h3>
                <h3>69 OLD PLUMTREE BLVD</h3>
                <h3>SPRINGFIELD, IL 62701</h3>
                <div class="moreinfo">
                    <h4>SEX <br> OK</h4>
                    <h4>HEIGHT <br> MEDIUM</h4>
                    <h4>HAIR <br> NONE</h4>
                    <h4>EYES <br> OVAL</h4>
                </div>
            </div>
            <img class="signatureImg" src="public\assets\img\signature.png" alt="">
            <div class="signature">
                <hr>
                <h5>SIGNATURE</h5>
            </div>
        </div>
    </div>
</div>
<form action="" method="POST" enctype="multipart/form-data">
    <label for="upload">Find Homer a new photo:</label>
    <input type="file" name="fileToUpdate" id="fileToUpdate" value="New photo">
    <button type="submit">Upload</button><?php
    if (!empty($errors)) {
        echo "<ul>" . PHP_EOL;
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>" . PHP_EOL;
        }
        echo "</ul>";
    }
?></form>
</body>
</html>