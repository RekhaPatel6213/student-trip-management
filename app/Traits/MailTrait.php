<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate;
use App\Mail\MailWithAttachment;

trait MailTrait {

    public static function customEmailSend($data)
    {
        $fromMail = $data['fromMail'];
        $toMail = $data['toMail'];
        $subject = $data['subject'];
        $message = $data['message'];
        $attachFile = isset($data['attachFile']) ? $data['attachFile'] : null;
        $ccMail = isset($data['CcMail']) ? $data['CcMail'] : null;
        $bccMail = isset($data['BccMail']) ? $data['BccMail}'] : null;

        //Send Trigger Email
        self::sendEmail($fromMail, $toMail, $subject, $message, $attachFile, $ccMail, $bccMail, null );
    }

    public static function emailTemplateMapping($templateName, $mappingData, $subject = null)
    {
        $emailTemplate = EmailTemplate::where('name', EmailTemplate::TEMPLATE[$templateName])->first();

        $fromMail = $mappingData['fromMail'] ?? $emailTemplate->from_email;

        $toMail = $mappingData['toMail'];
        $subject = $subject ?? strtr($emailTemplate->subject,  $mappingData);
        $message = strtr($emailTemplate->message,  $mappingData);
        $attachFile = isset($mappingData['attachFile']) ? $mappingData['attachFile'] : null;
        $ccMail = isset($mappingData['{CcMail}']) ? $mappingData['{CcMail}'] : null;
        $bccMail = isset($mappingData['{BccMail}']) ? $mappingData['{BccMail}'] : null;
        $data = $mappingData['data'] ?? null;

        //Send Trigger Email
        self::sendEmail($fromMail, $toMail, $subject, $message, $attachFile, $ccMail, $bccMail, null );
    }


	public static function sendEmail($from, $to, $subject, $description, $file = null, $cc = null, $bcc = null, $data = null, $replyTo = '')
    {
        libxml_use_internal_errors(true);
        $mailObject = new \stdClass();
        $mailObject->from = $from;
        $mailObject->subject = $subject;
        $mailObject->description = $description;
        $mailObject->data = $data;
        $mailObject->file = $file;
        $mailObject->replyTo = $replyTo;
        $mailObject->cc = $cc;
        $mailObject->bcc = $bcc;

        $mail = Mail::to($to);
        if ($cc !== null) {
            $mail = $mail->cc(is_array($cc) ? $cc : [$cc]);
        }
        if ($bcc !== null) {
            $mail = $mail->bcc(is_array($bcc) ? $bcc : [$bcc]);
        }
        return $mail->queue(new MailWithAttachment($mailObject));
    }
}