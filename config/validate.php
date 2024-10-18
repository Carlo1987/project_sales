<?php

trait Validate {
    
    public function validateString($data,$data_name){
        $data_sanified = htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
        $data_name = strtoupper($data_name);

        if (isset($data_sanified) && !empty($data_sanified)) {

            if (is_string($data_sanified) && !preg_match("/[0-9]/", $data_sanified)) {
                return array(
                    'status' => true,
                    'data' => $data_sanified
                );
            } else {
                return array(
                    'status' => false,
                    'error' => "Non possono essere presenti numeri nel campo $data_name"
                );
                
            }
        } else {
            return array(
                'status' => false,
                'error' => "Non puoi lasciare il campo $data_name vuoto"
            );
        }
        
    }



    public function validateNumber($number){
        if(is_integer($number)){
            return true;
        }else{
            return false;
        }
    }




    public function validateEmail($email){
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
       
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            
            if (isset($email) && !empty($email)){
                
                return array(
                    'status' => true,
                    'data' => $email
                );
            
            }else{
                return array(
                    'status' => false,
                    'error' => "Non puoi lasciare il campo EMAIL vuoto"
                );
            }
        
        }else{
            return array(
                'status' => false,
                'error' => "Immettere una email valida"
            );
        }
       
    }




    public function validateImage($image_type){
        $result = false;
        if ($image_type == 'image/jpg' || $image_type == "image/jpeg" || $image_type == "image/png" || $image_type == "image/gif" || $image_type == "image/webp"){
            $result = true;
        }

        return $result;
    }




    public function validatePrice($input){
        $regex = '/^\d{2}\.\d{2}$/';

        if (preg_match($regex, $input)) {
            return true;
        } else {
            return false;
        }
    }
        
    


}



