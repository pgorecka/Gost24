<?php

$from = 'info@gost24.com';

$sendTo = 'info@gost24.com';

$subject = 'Nowa wiadomość od';

$fields = array('company' => 'firma', 'nip' => 'NIP', 'name' => 'Imię', 'surname' => 'Nazwisko', 'email' => 'Email',
          'code' => 'Kod taryfy celnej', 'subject' => 'Temat', 'www' => 'www', 'message' => 'Wiadomość'); 

$okMessage = 'Wiadomość wysłana pomyślnie. Dziękujemy.';

$errorMessage = 'Wystąpił problem. Prosimy spróbować ponownie.';

error_reporting(0);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "Nowa wiadomość z serwisu www.gost24.com\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    

    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}



if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}

else {
    echo $responseArray['message'];
}
