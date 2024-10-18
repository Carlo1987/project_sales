<?php

abstract class Uploads
{

    protected $directory;
    protected $image_name;
    protected $image_tmp;


    protected function createDir(){
        if(!is_dir($this->directory)){
            mkdir($this->directory);
        }
    }



    protected function saveImage(){
        $folder = array();                                # array vuoto
        if($files = opendir($this->directory)){
            while(true == $file = readdir($files)){
                if($file != '.' && $file != '..'){
                    $folder[] = $file;                   # metto ogni file dentro l'array
                } 
            }
        }
        
        $search = in_array($this->image_name, $folder); 
        if(!$search){
            move_uploaded_file($this->image_tmp , $this->directory.'/'.$this->image_name);
        }
    }




    protected function deleteImage(){
        $image = $this->directory.'/'.$this->image_name;
   
        if(file_exists($image)){
           unlink($image);
        }
    }




    protected function moveImage($old_file , $new_file){

        if (file_exists($old_file)) {
            rename($old_file, $new_file);
        } 
    }


}