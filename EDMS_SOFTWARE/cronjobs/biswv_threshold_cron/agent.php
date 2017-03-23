<?php
require_once 'config.php';
require_once 'threshold_rule.php';
require_once 'threshold_log.php';
require_once 'curl_helper.php';
require_once 'PHPMailer/class.phpmailer.php';
//ob_start();
//require 'template/threshold_mail.php';
//define("MAIL_TEMPLATE", ob_get_clean());
date_default_timezone_set('Europe/Athens');
/**
 * Description of agent
 *
 * @author intelen
 */

///home/jedi_john/biswv_threshold_cron

class Agent {
    
   
    /**
     * current Datetime
     * @var DateTime
     */
    private $now;
    /**
     *
     * @var array of threshold rules
     */
    private $threshold_rules = array();
    private $notifications = array();
    /**
     *
     * @var array of users
     */
    private $users = array();
    /**
     *
     * @var boolean
     */
    private $debug = false;
    private $debug_start = 0;
    private $debug_end = 0;
    /**
     * Array populated by threshold rules to be sent to energy api
     * @var Array
     */
    private $checks = array();
    private $thresholds_prosessed = 0;
    private $triggered = 0;
    /**
     * 
     * @global type $config
     */
    public function __construct($debug = false,$mailSendTO = false,$subject = false,$dateSendTo=false) {
        $this->debug = $debug;
        $this->debug_start = microtime(true);
        global $config;
       
      
         
           $this->notify($mailSendTO,$subject,$dateSendTo);
            
         
      
        $this->debug_end = microtime(true);
        //find elapsed time in seconds 
        $elapsed = $this->debug_end - $this->debug_start;

        echo "<br/>\nTime Elapsed: $elapsed seconds\n<br/>";
        echo "Processed: $this->thresholds_prosessed thresholds\n<br/>";
        echo "Triggered: $this->triggered thresholds\n<br/>";
    }
    
  
    
    public function notify($mailSendTO,$subject,$dateSendTo){
      
            $templateData = '<h1 style="margin-bottom:20px">Some action is required from you</h1>';
            $templateData .= '<table class="table">';
            $templateData .= '<tr><td style="text-decoration:underline;">Date:</td><td style="color:red">'.$dateSendTo.'</td></tr>';
            $templateData .= '<tr><td style="text-decoration:underline;">Message:</td><td style="color:red">'.$subject.'</td></tr>';
            $templateData .=' <tr><td >Contact: info@vimsen.eu | All rights reserved © 2016 VIMSEN</td></tr>';
            $templateData .= '</table>';
            //$templateData .= '<a style="margin-top: 20px; float: left" href="https://bis-watt-volt.intelen.com/el/thresholds/building">Details</a>';
            
            include 'template/threshold_mail.php';
            
            $mail = new PHPMailer;

            $mail->IsSMTP();                                      // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;  // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = SMTP_USERNAME;                            // SMTP username
            $mail->Password = SMTP_PASSWORD;                           // SMTP password
            $mail->SMTPDebug  = SMTP_DEBUG;
             $mail->SMTPSecure = 'tls';                       /// Enable encryption, 'ssl' also accepted
            $mail->From = 'no-reply@intelen.com';
           // $mail->From = SMTP_USERNAME; //'no-reply@intelen.com';
            $mail->FromName = 'Vimsen';
            $mail->CharSet = 'UTF-8';
            
            /*
            $mail = new PHPMailer;
            $mail->IsSMTP();                                      // Set mailer to use SMTP
            $mail->Host = SMTP_HOST;  // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = SMTP_USERNAME;                            // SMTP username
            $mail->Password = SMTP_PASSWORD;                           // SMTP password
           // $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            $mail->SMTPSecure = 'tls';  
            
            $mail->From = 'no-reply@intelen.com';
            $mail->FromName = 'Intelen Inc';
            $mail->CharSet = 'UTF-8';
            */
            
            if (SEND_MAIL) 
            {                
                if (! empty(trim($mailSendTO)))
                {
                    $email = $mailSendTO;
                  
                        if (filter_var(trim($email), FILTER_VALIDATE_EMAIL))
                        {
                            $mail->AddAddress($email, $email);  // Add a recipient            
                        }
                   
                }                                
            }
            else
                $mail->AddAddress(MASTER_EMAIL, 'Vimsen');
    //        $mail->AddReplyTo('info@example.com', 'Information');
    //        $mail->AddCC('cc@example.com');
    ////        $mail->AddBCC('bcc@example.com');

            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    //        $mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //        $mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->IsHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Threshold message';
            $mail->Body    = $template;
            $mail->AltBody = 'VIMSEN Notification Alert.';

            // if there are email address added             
            if (count($mail->getToAddresses()) > 0)
            {
                if(!$mail->Send()) {
                   echo 'Message could not be sent to '.$mailSendTO.'.';
                   echo 'Mailer Error: ' . $mail->ErrorInfo;
    //               exit;
                } else {
                    echo 'Message has been sent to '.$mailSendTO.'.';
                }         
            }//end if
            else
            {
                error_log('No mail address found for threshold ID:'.$mailSendTO.'. ');
            }
     
    }
    
    
      public function SaveEmailId($nameBuilding, $threshold_id, $date) {


        $myfile = fopen("logs.out", "a") or die("Unable to open file!");
        $txt = "$nameBuilding, $threshold_id, $date";
        fwrite($myfile, "\n" . $txt);
        fclose($myfile);
    }

    public function ReadEmailId($id, $building_name, $date) {


        $return_value = "";

        $file_handle = fopen("logs.out", "r");

        while (!feof($file_handle)) {

            $line_of_text = fgetcsv($file_handle, 1024);


            IF ($line_of_text[1]) {

                //  echo "1 name)" . $line_of_text[0] . "-$building_name| 2 ID)" . $line_of_text[1] . "|$id 3 DATE)" . $line_of_text[2] . "||$date- <br>";

                IF ($id == $line_of_text[1]) {//and $line_of_text[0] == $building_name
                    $return_value = "on";
                    return $return_value;
                }
            }
        }
        fclose($file_handle);
    }
    
   
    
    /**
     * DEBUG FUNCTIONS
     */
    public function setDebug(){
        $this->debug = true;
    }
    


    

}

?>
