<?php

class IRB_Mailer   
{   
    public $to;  
    public $from;      
    public $subject;      
    public $message;
    public $errors = array();      
    private $boundary;      
    private $headers;      
    private $multipart;  
    

/**  
* Constructor.     
* @param string $message        
* @Establishes a symbol of carrying over of a line and dividers 
*/          
   public function __construct($message = false)   
   {   
      $this->boundary = '=='. uniqid(time());  
              
      if($message)                     
          $this->message    = $message;                   
      else  
          $this->errors[] = 'There is no message text';                              
   } 
      
/**  
* Sets message type to HTML.  
* Устанавливает HTML формат сообщения  
* @access public           
* @return void  
*/    
   public function setHtml($set = false)   
   {      
      
      $this->headers  =  "--". $this->boundary ."\r\n";  
      $this->headers .= "Content-type: text/plain; charset=\"utf-8\"\r\n";   
      $this->headers .= "Content-Transfer-Encoding: base64\r\n\r\n";  
       
      if($set) 
      {      
          $this->multipart  = $this->headers;   
          $this->multipart .= chunk_split(base64_encode(strip_tags($this->message))) ."\r\n";    
          $this->multipart .= "--". $this->boundary ."\r\n";        
          $this->multipart .= "Content-type: text/plain; charset=\"utf-8\"\r\n";  
          $this->multipart .= "Content-Transfer-Encoding: base64\r\n\r\n";  
          $this->multipart .= chunk_split(base64_encode($this->message)) ."\r\n"; 
      } 
      else  
      { 
          $this->multipart  = $this->headers . chunk_split(base64_encode($this->message)) ."\r\n";  
      }     
   } 
      
/**  
* Adds a "To" address..  
* Устанавливает адрес "Кому"  
* @access public  
* @param string  $to           
* @return void  
*/     
   public function createTo($to = '')   
   {   
      if(empty($to))   
           $this->errors[] = 'There is no addressee';    
      elseif(!$this->checkEmail($to))  
           $this->errors[] = 'The e-mail address is not correct';   
       else  
           $this->to = $to;  
   }  
      
/**  
* Adds a "From" address.  
* Устанавливает адрес "От кого"  
* @access public  
* @param string  $from           
* @return void  
*/     
   public function createFrom($from = false)   
   {   
      if($from)      
         $this->from = trim(preg_replace('/[\r\n]+/', ' ', $from));   
      else   
         $this->errors[] = 'There is no sender';         
   }       
      
/**  
* Adds a Subject.  
* Устанавливает тему сообщения  
* @access public  
* @param string  $subject           
* @return void  
*/      
   public function createSubject($subject = false)   
   {   
      if($subject)   
          $this->subject = '=?utf-8?b?'. base64_encode($subject) .'?=';   
      else   
          $this->errors[] = 'There is no theme';         
   } 
          
/**  
* Deduces a script error.  
* Проверка корректности электронного адреса  
* @param string  $to      
* @access private     
* @return string or boolean  
*/        
   private function checkEmail($to)   
   {   
       if (function_exists("filter_var"))  
           return filter_var($to, FILTER_VALIDATE_EMAIL); 
       else 
           return preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+\.)+[a-z]{2,4}$/i", $to); 
   }     
        
/**   
* Method of formation of headings  
* Метод формирования заголовков   
* @access private    
* @param string  $subject            
* @return void   
*/             
   private function createHeader()  
   {  
       $header = "Content-type: multipart/alternative; boundary=\"". $this->boundary ."\"\r\n";            
       $header .= "From: ". $this->from ." <". $this->from ."> \r\n";  
       $header .= "MIME-Version: 1.0\r\n"; 
       $header .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";
         return $header;    
   }  
        
/**  
* Deduces a script error.  
* Диагностика ошибок      
* @access private     
* @return string or boolean  
*/       
   private function checkData()   
   {   
      if(count($this->errors))    
          return implode(PHP_EOL, $this->errors);   
      else   
          return false;     
   }        
        
/**  
* Sends mail using the PHP mail() function.  
* Отправляет письмо используя PHP функцию  mail()     
* @access public     
* @return string   
*/     
   function sendMail()  
   {           
           
         if(!$error = $this->checkData())  
         {     
            $header = $this->createHeader();  
                     
            if(!mail($this->to, $this->subject, $this->multipart, $header, '-f'. $this->from))  
                return 'Letter sending is impossible';  
            else  
                return NULL;  
        }  
        else  
        {  
            return $error;  
        }  
   }    
} 

   
////////////////////////////////////////////////////////////////////////////// 
    $to = 'U-English@mail.ru';       
    $subject = 'Табе пакет';   
    $from = 'hazg@bk.ru';       
    $message = '<h1 style="color:blue">Вот такое вот письмо</h1>';   

       
    $mail = new IRB_Mailer($message);   
    $mail -> setHtml(true);   
    $mail -> createTo($to);   
    $mail -> createFrom($from);   
    $mail -> createSubject($subject);   
    $error = $mail -> sendMail();   
    echo  nl2br($error);
