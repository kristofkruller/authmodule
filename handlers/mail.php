<?php
// composer
include_once dirname(__DIR__)."/vendor/autoload.php";

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Exceptions\MailerSendValidationException;
use MailerSend\Exceptions\MailerSendException;

class Mail {
  public static function sendMail($data) {
    if($data == null) {
      throw new MailerSendException("Átadott data (sendMail) üres");
    } else if (MAIL_API_KEY == "" || MAIL_API_KEY == null) {
      throw new MailerSendException("Mail api key nincs beállítva");
    } else {
      $mailersend = new MailerSend(['api_key' => MAIL_API_KEY]);
    }

    $recipients = [
      new Recipient($data['to'], $data['name']),
    ];

    $email = (new EmailParams())
      ->setFrom(SENDER_MAIL)
      ->setFromName('Authmodule')
      ->setRecipients($recipients)
      ->setSubject('Jelszó visszaállítás - Authmodule')
      ->setHtml($data['html_body'])
      ->setText('Jelszó visszaállításához kérlek kövesd az alábbi linket');

    try {
      $mailersend->email->send($email);
    } catch (MailerSendValidationException $e) {
      print_r($e->getResponse()->getBody()->getContents());
    }
  }
}