<?php
require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Construct the Google verification API request link.
    $params = array();
    $params['secret'] = '6LebNgETAAAAAN-NwBnJf29JcA4dRTPmN-1A-uDb'; // Secret key
    if (!empty($_POST) && isset($_POST['g-recaptcha-response'])) {
        $params['response'] = urlencode($_POST['g-recaptcha-response']);
    }
    $params['remoteip'] = $_SERVER['REMOTE_ADDR'];

    $params_string = http_build_query($params);
    $requestURL = 'https://www.google.com/recaptcha/api/siteverify?' . $params_string;

    // Get cURL resource
    $curl = curl_init();

    // Set some options
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $requestURL,
    ));

    // Send the request
    $response = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);

    $response = @json_decode($response, true);

    if ($response["success"] == true) {                       // If captcha matches and is true.

        $mail->isSMTP();                                      // Set mailer to use SMTP

        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['phone'];
        $message = $_POST['message'];

        date_default_timezone_set('Asia/Calcutta');
        $time = date("H:i:s Y-m-d");

        $mail->Host = 'localhost';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'ani@productclicker.com';                 // SMTP username
        $mail->Password = 'aniketvishal123';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->From = 'ani@productclicker.com';
        $mail->FromName = 'Productclicker Site mail';
        $mail->addAddress('aniketpawar07@gmail.com');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo("$email");
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = " $enq from $name";
        $mail->Body    =  "$message <br><br> <b>Complete Details of this enquiry:</b> <br>
<b>Name: </b>$name<br>
<b>Email: </b>$email<br>
<b>Contact No: </b>$number<br>
<b>Sent on: </b>$time";

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo "We have recieved your message. We will get back to you in few days.";
        }
    } else {
        echo "Please verify that you're not a robot and try again.";
    }
}
?>
