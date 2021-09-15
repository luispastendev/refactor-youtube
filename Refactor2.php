<?php 

class User implements SplSubject { 

    private $email; 
    private $username; 
    private $mobile; 
    private $password; 
    /** 
        * @var SplObjectStorage 
        */ 
    private $observers = NULL; 

    public function __construct($email, $username, $mobile, $password) { 
        $this->email = $email; 
        $this->username = $username; 
        $this->mobile = $mobile; 
        $this->password = $password; 

        $this->observers = new SplObjectStorage(); 
    } 

    public function attach(SplObserver $observer) { 
        $this->observers->attach($observer); 
    } 

    public function detach(SplObserver $observer) { 
        $this->observers->detach($observer);
    } 

    public function notify() { 
        $userInfo = array(   
            'username' => $this->username, 
            'password' => $this->password, 
            'email' => $this->email, 
            'mobile' => $this->mobile, 
        ); 
        foreach ($this->observers as $observer) { 
            $observer->update($this, $userInfo); 
        } 
    } 

    public function create() { 
        echo __METHOD__, PHP_EOL; 
        $this->notify(); 
    } 

    public function changePassword($newPassword) { 
        echo __METHOD__, PHP_EOL; 
        $this->password = $newPassword; 
        $this->notify(); 
    } 

    public function resetPassword() { 
        echo __METHOD__, PHP_EOL; 
        $this->password = mt_rand(100000, 999999); 
        $this->notify(); 
    } 

} 

class EmailSender implements SplObserver { 

   public function update(SplSubject $subject) { 
       if (func_num_args() === 2) { 
           $userInfo = func_get_arg(1); 
           echo "Se envió correctamente un correo electrónico a {$userInfo['email']}. El contenido es: Hola {$userInfo['username']}". 
                        "Su nueva contraseña es {$userInfo['password']}, manténgala segura.", PHP_EOL; 
       } 
   } 

} 


class MobileSender implements SplObserver { 

    public function update(SplSubject $subject) { 
        if (func_num_args() === 2) { 
            $userInfo = func_get_arg(1); 
            echo "Se envió correctamente un mobile a {$userInfo['mobile']}. El contenido es: Hola {$userInfo['username']}". 
                         "Su nueva contraseña es {$userInfo['password']}, manténgala segura", PHP_EOL; 
        } 
    } 

} 

class WebsiteSender implements SplObserver { 

    public function update(SplSubject $subject){
        if (func_num_args() === 2) { 
            $userInfo = func_get_arg(1); 
            echo "Se cambio la password para la cuenta {$userInfo['email']}". 
                    "Su nueva contraseña es {$userInfo['password']}, manténgala segura", PHP_EOL; 
        } 
    }
}
 
 

// header('Content-Type: text/plain'); 

// function __autoload($class_name) { 
//    require_once "$class_name.php"; 
// } 

$email_sender = new EmailSender(); 
$mobile_sender = new MobileSender(); 
$web_sender = new WebsiteSender(); 

$user = new User('usuario1@dominio.com', 'Zhang San', '13610002000', '123456'); 

  // Notificar a los usuarios por correo electrónico y SMS al crear usuarios
// $user->attach($email_sender); 
// $user->attach($mobile_sender); 
// $user->create($user); 
// echo PHP_EOL; 

//   // Si el usuario restablece la contraseña después de olvidar la contraseña, debe notificar al usuario a través de una pequeña nota
$user->attach($web_sender); 
$user->attach($email_sender); 
$user->resetPassword(); 
echo PHP_EOL; 

//   // El usuario ha cambiado la contraseña, pero no envía mensajes de texto a su teléfono móvil
// $user->detach($mobile_sender); 
// $user->changePassword('654321'); 
// echo PHP_EOL; 

