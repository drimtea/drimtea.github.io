
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

  <title>PHP Contact Form with JQuery Validation</title>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
 <script src="jquery-3.0.0.min.js" type="text/javascript"></script>
 <script src="jquery.validate.messages_ru.js" type="text/javascript"></script>
  <script src="jquery.validate.pack.js" type="text/javascript"></script>
<script type="text/javascript">
      $(document).ready(function(){
      $("#contactform").validate();
      });
  </script> 
<script type="text/javascript">
 <?php
  //Если форма отправлена
  if(isset($_POST['submit'])) {
 //Проверка Поля ИМЯ
  if(trim($_POST['contactname']) == '') {
  $hasError = true;
  } else {
  $name = trim($_POST['contactname']);
  }
 //Проверка поля ТЕМА
  if(trim($_POST['subject']) == '') {
  $hasError = true;
  } else {
  $subject = trim($_POST['subject']);
  }
 //Проверка правильности ввода EMAIL
  if(trim($_POST['email']) == '')  {
  $hasError = true;
  } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
  $hasError = true;
  } else {
  $email = trim($_POST['email']);
  }
 //Проверка наличия ТЕКСТА сообщения
  if(trim($_POST['message']) == '') {
  $hasError = true;
  } else {
  if(function_exists('stripslashes')) {
  $comments = stripslashes(trim($_POST['message']));
  } else {
  $comments = trim($_POST['message']);
  }
  }
 //Если ошибок нет, отправить email
  if(!isset($hasError)) {
  $emailTo = 'hazg@bk.ru'; //Сюда введите Ваш email
  $body = "Name: $name \n\nEmail: $email \n\nSubject: $subject \n\nComments:\n $comments";
  $headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
 mail($emailTo, $subject, $body, $headers);
  $emailSent = true;
  }
  }
  ?>
</script>

 <style type="text/css">
  body 

   {
   font-family:Arial, Tahoma, sans-serif;
   }
#contact-wrapper 
  {
  width:430px;
  border:1px solid #e2e2e2;
  background:#f1f1f1;
  padding:20px;
  }
#contact-wrapper div 
  {
  clear:both;
  margin:1em 0;
  }
#contact-wrapper label 
  {
  display:block;
  float:none;
  font-size:16px;
  width:auto;
  }
form#contactform input 
  {
  border-color:#B7B7B7 #E8E8E8 #E8E8E8 #B7B7B7;
  border-style:solid;
  border-width:1px;
  padding:5px;
  font-size:16px;
  color:#333;
  }
form#contactform textarea 
  {
  font-family:Arial, Tahoma, Helvetica, sans-serif;
  font-size:100%;
  padding:0.6em 0.5em 0.7em;
  border-color:#B7B7B7 #E8E8E8 #E8E8E8 #B7B7B7;
  border-style:solid;
  border-width:1px;
  }
 </style>
      </head>

<body>
  

      <div id="contact-wrapper">
   <form method="post" action="contact.php?success=ok" id="contactform">
<div>
    
<label for="name"><strong>Имя:</strong></label>
<input type="text" size="50" name="contactname" id="contactname" value="" class="required" />
</div>
 <div>
  <label for="email"><strong>Email:</strong></label>
  <input type="text" size="50" name="email" id="email" value="" class="required email" />
  </div>
 <div>
  <label for="subject"><strong>Контактный телефон:</strong></label>
  <input type="text" size="50" name="subject" id="subject" value="" class="required" />
  </div>
 <div>
  <label for="message"><strong>Message:</strong></label>
  <textarea rows="5" cols="50" name="message" id="message" class="required"></textarea>
  </div>
  <input type="submit" value="Send Message" name="submit" />
  </form>
  </div>
  </body>
  </html>