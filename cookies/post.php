<?php

$cookie_content = 'false';

if(isset($_POST['marketing']) && $_POST['marketing'] == 'on'){
 $cookie_content = 'true';
 echo json_encode('ok');

}else{
 echo json_encode('off');
}

setcookie('identity','identity', time()+(60*180), '/');
setcookie('marketing',$cookie_content.'-'.date('H-i'), time()+(60*13), '/');