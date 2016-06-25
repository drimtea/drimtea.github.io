

/*class Mailer 
{ 

    public $to;     
    public $subject;    
    public $from;
 
# Конструктор. Пока пустой.         
   function __construct();

# Метод формирования адреса "кому"   
   function createTo($to) 
   { 
       $this->to = $to; 
   } 
# Метод формирования адреса "от кого"   
   function createFrom($from) 
   { 
       $this->from = trim(preg_replace('/[\r\n]+/', ' ', $from)); 
   }    
# Метод формирования темы письма     
   function createSubject($subject) 
   { 
       $this->subject = '=?utf-8?b?'. base64_encode($subject) .'?='; 
   } 
# Метод формирования заголовков       
   function createHeader() 
   { 
       $header = "Content-type: text/plain; charset=\"utf-8\"\r\n"; 
       $header .= "From: ". $from ." <". $from ."> \r\n";  
       $header .= "MIME-Version: 1.0\r\n"; 
       $header .= "Date: ". date('D, d M Y h:i:s O') ."\r\n"; 
    
       $this->headers = $header; 
   } 
# Отправка  
   function sendMail($message) 
   { 
      if(mail($this->to, $this->subject, $message, $this->headers, '-f'. $this->from )) 
          return true; 
      else 
          return false;   
   } 

} 

    $to = 'U-English@mail.ru';     
    $subject = 'Заполнена контактная форма с '.$_SERVER['HTTP_REFERER']; 
    $from = 'hazg@bk.ru';     
    $message =  "Имя: ".$_POST['nameFF']."\nEmail: ".$_POST['contactFF']."\nIP: ".$_SERVER['REMOTE_ADDR']."\nТелефон: ".$_POST['telFF']."\nГород: ".$_POST['cityFF']; 

     
    $mail = new Mailer(); 
    $mail -> createTo($to); 
    $mail -> createFrom($from); 
    $mail -> createSubject($subject); 
    $mail -> createHeader(); 
    $mail -> sendMail($message);*/

<?
if (array_key_exists('nameFF', $_POST)) {
   $to = 'U-English@mai.ru';
   $from = 'hazg@bk.ru'
   $subject = 'Заполнена контактная форма с '.$_SERVER['HTTP_REFERER'];
   $subject = '=?utf-8?b?'. base64_encode($subject) .'?=';
   $headers = "Content-type: text/plain; charset=\"utf-8\"\r\n";
   $headers .= "From: <". $from .">\r\n";
   $headers .= "MIME-Version: 1.0\r\n"; 
   $headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";
   $message = "Имя: ".$_POST['nameFF']."\nEmail: ".$_POST['contactFF']."\nIP: ".$_SERVER['REMOTE_ADDR']."\nТелефон: ".$_POST['telFF']."\nГород: ".$_POST['cityFF'];
   mail($to, $subject, $message, $headers,'-f'.$from);
   echo $_POST['nameFF'];
}

?>
