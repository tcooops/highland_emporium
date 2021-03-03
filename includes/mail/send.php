<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json; charset=UTF-8');
$results = [];
$visitor_name = '';
$visitor_email = '';
$visitor_reason = '';
$visitor_message = '';

if (isset($_POST['firstname'])) {
    $visitor_name = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
} else {
    $results['message'] = 'First name is blank';
    echo json_encode($results);
    exit;
}

if (isset($_POST['lastname'])) {
    $visitor_name = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
} else{
    $results['message'] = 'Last name is blank';
    echo json_encode($results);
    exit;
}

if (isset($_POST['email'])) {
    $visitor_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
}else{
    $results['message'] = 'Email is blank';
    echo json_encode($results);
    exit;
}

if (isset($_POST['phone'])) {
    $visitor_email = filter_var($_POST['phone'], FILTER_VALIDATE_EMAIL);
}else{
    $results['message'] = 'Phone number is blank';
    echo json_encode($results);
    exit;
}

/* if (isset($_POST['reason'])) { 
    $visitor_reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING); 
}else{
    $results['message'] = 'First name is blank';
    echo json_encode($results);
    exit;
} */

if (isset($_POST['message'])) {
    $visitor_message = filter_var(htmlspecialchars($_POST['message']), FILTER_SANITIZE_STRING);
}else{
    $results['message'] = 'First name is blank';
    echo json_encode($results);
    exit;
}

$results['name'] = $visitor_name;
$results['message'] = $visitor_message;


$email_subject = sprintf('Inquiry From %s Regarding: %s', $visitor_name, $visitor_reason);
// this I figured out on my own based off this class build.

$email_recipient = 'tessa.m.cooper@gmail.com'; // this is your TO email
$email_message = sprintf('Name: %s, Email: %s, Message: %s', $visitor_name, $visitor_email, $visitor_message);

$email_headers = array(
    'From'=>'noreply@highlandemporium.com',
    'Reply-To'=>$visitor_email,
);


$email_result = mail($email_recipient, $email_subject, $email_message, $email_headers);
    if($email_result){
        $results['message'] = sprintf('Thank you for contacting us, %s! We will be in touch with you very soon.', $visitor_name);
    }else{
        $results['message'] = sprintf('Uh oh! Something went wrong. Please try again!');
    }

// spit out in json

echo json_encode($results);