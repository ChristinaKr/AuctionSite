<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 11/03/2018
 * Time: 13:28
 * @param $to
 * @param $subject
 * @param $html
 * @param $text
 */

include_once 'html_email.php';

// Using SendGrid to increase reliability of delivery
//Source: https://sendgrid.com/docs/Integrate/Code_Examples/v2_Mail/php.html
function send_email($to, $subject, $text)
{
    $from = "luke.harries.17@ucl.ac.uk";


    $url = 'https://api.sendgrid.com/';
    $from = 'luke.harries.17@ucl.ac.uk';
// To be set in MAMP file
    $user = getenv('SENGRID_USERNAME');
    $pass = getenv('SENGRID_PASSWORD');

    $params = array(
        'api_user' => $user,
        'api_key' => $pass,
        'to' => $to,
        'subject' => $subject,
        'html' => get_html_email($subject, $text),
        'text' => $text,
        'from' => $from,
    );


    $request = $url . 'api/mail.send.json';

// Generate curl request
    $session = curl_init($request);
// Tell curl to use HTTP POST
    curl_setopt($session, CURLOPT_POST, true);
// Tell curl that this is the body of the POST
    curl_setopt($session, CURLOPT_POSTFIELDS, $params);
// Tell curl not to return headers, but do return the response
    curl_setopt($session, CURLOPT_HEADER, false);
// Tell PHP not to use SSLv3 (instead opting for TLS)
    curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
    curl_exec($session);
    curl_close($session);

}