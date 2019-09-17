<?php

class Mail
{
    // Отправка письма
    public static function send($to, $subject, $message)
    {
        $encoding = "utf-8";

        // Mail header
        $header = "Content-type: text/html; charset=" . $encoding . " \r\n";
        $header .= "From: " . SITE_NAME . " <" . MAIL_ADMIN . "> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

        return mail($to, $subject, $message, $header, "-f" . MAIL_ADMIN);
    }

    // Отправка письма о публикации изображения объекта
    public static function sendAboutPublishImage($email, $name, $idObject, $idCulture)
    {
        $emailsPath = ROOT . '/config/emails.php';
        $emails = include($emailsPath);

        $message =
            "<html>
            <head>
                <title></title>
            </head>
            <body>
                <p>{$emails['emailAboutPublishImage']}</p>
            </body>
            </html>";
        $message = str_replace('%NAME%', $name, $message);
        $link = '<a href="' . USER_SITE_URL . '/object/object-' . $idObject . '/culture-' . $idCulture . '">Перейти</a>';
        $message = str_replace('%LINK%', $link, $message);

        return Mail::send($email, 'Ваше изображение было опубликовано - ' . SITE_NAME, $message);
    }
}