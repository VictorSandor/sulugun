<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstn = htmlspecialchars($_POST['firstn']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Ваш email, на который будет отправляться письмо
    $to = "sandorikviktor@gmail.com";
    
    // Тема письма
    $subject = "New Message from Contact Form";

    // Сообщение для отправки
    $body = "Name: $firstn\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Message: $message\n";

    // Заголовки
    $headers = "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Отправка email
    if (mail($to, $subject, $body, $headers)) {
        echo "Thank you for contacting us! We will get back to you soon.";
    } else {
        echo "There was an error sending your message. Please try again later.";
    }
}
?>