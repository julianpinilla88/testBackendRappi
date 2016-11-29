<?php

$target_file = $_FILES["fileUpload"]["name"];

if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)){
    echo true;
}