<?php

class Users_controller 
{

    use Validate;

    public function save()
    {
        if (isset($_POST['register']) || isset($_POST['change'])) {
            $errors = array();
            $user = new User();

          if(!isset($_GET['editPassword'])){

            /*   NOME   */
            $name = $_POST['name'];
            $validate_name = $this->validateString($name,'nome');

            if($validate_name['status']){
          
                $user->setName($validate_name['data']);
            }else{
                $errors['name'] = $validate_name['error'];
            }
        
    

            /*  COGNOME */
            $surname = $_POST['surname'];
            $validate_surname = $this->validateString($surname,'cognome');

            if($validate_surname['status']){

                $user->setSurname($validate_surname['data']);
            }else{
                $errors['surname'] = $validate_surname['error'];
            }


            /*  GENERE  */
            if (isset($_POST['gender'])) {
                $gender = $_POST['gender'];
                if ($gender) {
                    $user->setGender($gender);
                }
            }


            /*  EMAIL  */
            $validate_email = $this->validateEmail($_POST['email']);

            if($validate_email['status']){
                $email = $validate_email['data'];

                if (!isset($_SESSION['identity'])) {
                    $verify = $user->verify_email($email);
                    if ($verify == false) {
                        $user->setEmail($email);
                    } else {
                        $errors['email'] = 'Email già registrata, immetterne una nuova';
                    }
                } else if (isset($_SESSION['identity'])) {
                    $user->setEmail($email);
                }
            
            }else{
                $errors['email'] = $validate_email['error'];
            }

   

            /*  IMMAGINE AVATAR  */
            if (isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['name'] != '') {
                $image = $_FILES['image'];
                $image_name = $image['name'];
                $image_type = $image['type'];
                $image_tmp = $image['tmp_name'];
        
                if($this->validateImage($image_type)) {
                    if (!is_dir('assets/img/users')) {
                        mkdir('assets/img/users');
                    }
                    move_uploaded_file($image_tmp, 'assets/img/users/' . $image_name);
                    $user->setImage($image_name);
                }
            } else {
                if (isset($_SESSION['identity'])) {
                    $user->setImage($_SESSION['identity']->image);
                }
            }
         }  //  fine condizione per GET "editPassword"

             /*  PASSWORD  */
             if (!isset($_SESSION['identity'])) {

                if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
                    $password = $_POST['password'];
                    $confirm = $_POST['confirm_password'];

                    if ($password == $confirm) {
                        $user->setPassword($password);
                    } else {
                        $errors['password'] = 'La password deve essere la stessa in entrambi i campi';
                    }
                } else {
                    $errors['password'] = 'Devi riempire entrambi i campi PASSWORD e CONFERMA';
                }


            } else if (isset($_SESSION['identity']) && isset($_GET['editPassword'])) {

                if (isset($_POST['old_password']) && !empty($_POST['old_password']) && isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['confirm_password']) && !empty($_POST['confirm_password']) 
                    && $_POST['old_password'] != ''  && $_POST['new_password'] != ''  && $_POST['confirm_password'] != '') {
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];

                    $verify = password_verify($old_password, $_SESSION['identity']->password);

                    if ($verify) {
                        if ($new_password == $confirm_password) {
                            $user->setPassword($new_password);
                        } else {
                            $errors['password'] = 'La password deve essere la stessa in entrambi i campi precedenti';
                        }
                    } else {
                        $errors['password'] = 'La vecchia password inserita risulta errata, riprovare';
                    }

                }else if($_POST['old_password'] == ''  || $_POST['new_password'] == ''  || $_POST['confirm_password'] == ''){ 
                    
                        $errors['password'] = 'Compilare tutti i campi';
                } 
            }


            /*  REGISTRAZIONE / MODIFICA */
            if (count($errors) == 0) {

                if (!isset($_SESSION['identity'])) {
                    $user->save_User();
                    $_SESSION['register'] = 'Registrazione completata, effettua il LOGIN';

                } else if (isset($_SESSION['identity'])) {
                    $id = $_SESSION['identity']->id;

                    if(isset($_GET['editPassword'])){
                        $user->modify_User_password($id);
                    }else{
                        $user->modify_User($id);
                    }
                    
                    $new_dates = $user->search_User_byID($id);
                    $_SESSION['identity'] = $new_dates;

                    $_SESSION['success'] = 'Modifiche effettuate';
                }
            } else {
                if (!isset($_SESSION['identity'])) {
                    $_SESSION['errors'] = $errors;
                } else if (isset($_SESSION['identity'])) {
                    $_SESSION['errors_change'] = $errors;
                }
            }


            if (!isset($_SESSION['identity'])) {
                Utils::route('home');
           
            } else if (isset($_SESSION['identity'])) {

                Utils::route('back');

             /*    if(isset($_GET['editPassword'])){
                    Utils::route('user-editPassword');

                }else{
                    Utils::route('user-edit');
                } */
            }
        }
    }



    public function login()
    {
        if (isset($_POST['login'])) {

            $validate_email = $this->validateEmail($_POST['email']);

            if($validate_email['status']){
                
                if (isset($_POST['password']) && !empty($_POST['password'])) {
                    $email = $validate_email['data'];
                    $password_login = $_POST['password'];
    
                    $user_class = new User();
                    $user = $user_class->verify_email($email);
    
                    $errors = array();
                    if ($user) {
    
                        $verify = password_verify($password_login, $user->password);
    
                        if ($verify) {
    
                           $_SESSION['identity'] = $user;
    
                        } else {
                            $errors['login'] = 'Password errata, riprovare';
                        }
                    } else {
                        $errors['login'] = 'Utente non trovato';
                    }
                } else {
                    $errors['login'] = 'Inserire la password';
                }
            
            }else{
                $errors['login'] = $validate_email['error'];
            }

           

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
            }

            Utils::route('home');
        }
    }


    public function logout()
    {
        if ($_SESSION['identity']) {

            Utils::deleteCookies();
            session_destroy();
           
            Utils::route('home');
        }
    }


    public function change()
    {
        require 'views/users/change.php';
    }

    public function change_password()
    {
        require 'views/users/change_password.php';
    }



    public function contacts()
    {
        require 'views/contacts/contacts.php';
    }


    ////////   procedura reset password utente  ///////////////

    public function email_reset(){
        require 'views/users/forget_password.php';
    }


    public function verify_token(){
        require 'views/users/token.php';
    }


    public function send_token(){
  
        if(isset($_POST) || isset($_SESSION['token']['email'])){
 
            $email = $_POST['email'];

            $user = new User();
            $verify = $user->verify_email($email);
        
            if($verify != false){
                if($verify->id == 1 || $verify->id > 8){
                    $_SESSION['token']['email'] = $email; 
            
                    $token = rand(1,9);
                    for($i=1; $i<=5; $i++){
                        $number = rand(1,9);
                        $token = $token.$number;
                    }        

                    $_SESSION['token']['code'] = $token;
                    
                    require 'views/emails/email_reset.php';              
      
                    Utils::route('user-token');
                                          
                }else
                    $_SESSION['error'] = "I dati di questo Utente non possono essere modificati";
                 
            }else{   // se l'utente con questa email non è presente nel database....
                $_SESSION['error'] = "Nessun Utente risulta registrato con questa email";
            }  

                Utils::route('back');
        }
    }
 

  
    public function reset_password(){
         require 'views/users/reset_password.php';
    } 


    public function new_password(){
        if(isset($_POST)){
           
            $password = $_POST['password'];
            $confirm =  $_POST['confirm'];
            $email = $_SESSION['token']['email'];

            if($password == $confirm){
                $user = new User();
                $user->setPassword($password);
                $user->modify_password($email);

                Utils::delete_token();

                $_SESSION['reset'] = "<div class='allerts'>Password resettata</div>";
                Utils::route('home');
            
            }else{
                $_SESSION['error'] = "Hai digitato due password diverse, devi scrivere la stessa password in entrambi i campi";
                Utils::route('back');
            }
        }
    }



}


