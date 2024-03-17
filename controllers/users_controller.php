<?php

class Users_controller
{

    public function save()
    {
        if (isset($_POST['register']) || isset($_POST['change'])) {
            $errors = array();
            $user = new User();

          if(!isset($_GET['editPassword'])){
        
            /*   NOME   */
            if (isset($_POST['name']) && !empty($_POST['name'])) {
                $name = $_POST['name'];

                if (is_string($name) && !preg_match("/[0-9]/", $name)) {
                    $user->setName($name);
                } else {
                    $errors['name'] = 'Non possono essere presenti numeri nel campo NOME';
                }
            } else {
                $errors['name'] = 'Non puoi lasciare il campo NOME vuoto';
            }

            /*  COGNOME */
            if (isset($_POST['surname']) && !empty($_POST['surname'])) {
                $surname = $_POST['surname'];

                if (is_string($surname) && !preg_match("/[0-9]/", $surname)) {
                    $user->setSurname($surname);
                } else {
                    $errors['surname'] = 'Non possono essere presenti numeri nel campo COGNOME';
                }
            } else {
                $errors['surname'] = 'Non puoi lasciare il campo COGNOME vuoto';
            }

            /*  GENERE  */
            if (isset($_POST['gender'])) {
                $gender = $_POST['gender'];
                if ($gender) {
                    $user->setGender($gender);
                }
            }

            /*  EMAIL  */
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = $_POST['email'];

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

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
                } else {
                    $errors['email'] = 'Immettere una email valida';
                }
            } else {
                $errors['email'] = 'Non puoi lasciare il campo EMAIL vuoto';
            }
   

            /*  IMMAGINE AVATAR  */
            if (isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['name'] != '') {
                $image = $_FILES['image'];
                $image_name = $image['name'];
                $image_type = $image['type'];
                $image_tmp = $image['tmp_name'];

                if ($image_type == 'image/jpg' || $image_type == "image/jpeg" || $image_type == "image/png" || $image_type == "image/gif") {
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
                    
                        $errors['password'] = 'Devi riempire tutti e tre i campi per poter cambiare password';
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

                    $_SESSION['change'] = 'Modifiche effettuate';
                }
            } else {
                if (!isset($_SESSION['identity'])) {
                    $_SESSION['errors'] = $errors;
                } else if (isset($_SESSION['identity'])) {
                    $_SESSION['errors_change'] = $errors;
                }
            }

            global $host;

            if (!isset($_SESSION['identity'])) {
                echo "<h2>... Registrazione in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php' </script>";
           
            } else if (isset($_SESSION['identity'])) {

                if(isset($_GET['editPassword'])){
                    echo "<h2>... Modifica dati in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=change_password' </script>";

                }else{
                    echo "<h2>... Modifica dati in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=change' </script>";
                }
            }
        }
    }



    public function login()
    {
        if (isset($_POST['login'])) {

            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
                $email = $_POST['email'];
                $password_login = $_POST['password'];

                $user_class = new User();
                $user = $user_class->verify_email($email);

                $errors = array();
                if ($user) {

                    $verify = password_verify($password_login, $user->password);

                    if ($verify) {

                       $_SESSION['identity'] = $user;

                    } else {
                        $errors['login'] = 'Email o password errati, riprovare';
                    }
                } else {
                    $errors['login'] = 'Utente non trovato';
                }
            } else {
                $errors['login'] = 'Compilare entrambi i campi';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
            }

            global $host;
            echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php' </script>";
        }
    }


    public function logout()
    {
        if ($_SESSION['identity']) {
            session_destroy();

            global $host;
            echo "<h2>... Chiusura sessione in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?ending=eseguito' </script>";
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


    public function role()
    {
        require 'views/users/role.php';
    }


    public function new_role()
    {
        if (isset($_POST['role'])) {
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $role = $_POST['chose_role'];

            $user_class = new User();
            $user = $user_class->search_User_byElements($name, $surname, $email);

            if ($user != false) {
                if($user->id <= 8 && $user->id != $_SESSION['identity']->id && $user->id != 1){
                    $user_class->modify_role($role, $user->id);
                    $_SESSION['role'] = 'Ruolo modificato';

                }else{
                    $_SESSION['error_role'] = 'Non è possibile modificare il ruolo di questo Utente';
                }
               
            } else {
                $_SESSION['error_role'] = 'Utente non trovato';
            }

            global $host;
            echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=role' </script>";
        }
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
 
        global $host;
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
        
                    echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=verify_token' </script>";
          
                }else{
                    $_SESSION['token_error'] = "<div class='errors'> All'utente associato a questa email non possono essere modificati i dati </div>";
                    echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=email_reset' </script>";
                }
       
        }else{   // se l'utente con questa email non è presente nel database....
            $_SESSION['token_error'] = "<div class='errors'> Nessun Utente registrato con questa email, digitare correttamente oppure effettuare la registrazione </div>";
            echo "<h2>... Caricamento in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=email_reset' </script>";
         } 
      } 
    }


  
    public function reset_password(){
         require 'views/users/reset_password.php';
    }


    public function new_password(){
        if(isset($_POST)){
            global $host;
            $password = $_POST['password'];
            $confirm =  $_POST['confirm'];
            $email = $_SESSION['token']['email'];

            if($password == $confirm){
                $user = new User();
                $user->setPassword($password);
                $user->modify_password($email);

                Utils::delete_token();

                $_SESSION['reset'] = "<div class='allerts'>Password resettata</div>";
                echo "<h2>... Modifica password in corso, stai venendo reindirizzato alla HOME ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php' </script>";
            
            }else{
                $_SESSION['token_error'] = "<div class='errors'> Hai digitato due password diverse, devi scrivere la stessa password in entrambi i campi </div>";
                echo "<h2>... Modifica password in corso ... </h2> <script> window.location.href = 'https://$host/progetti/progetto_vendita/index.php?controller=Users_controller&action=reset_password' </script>";
            }
        }
           
        
    }



}
