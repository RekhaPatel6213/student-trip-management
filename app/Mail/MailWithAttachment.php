<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Storage;

class MailWithAttachment extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from($this->content->from)->subject($this->content->subject);

        if (isset($this->content->replyTo) && !empty($this->content->replyTo)) {
            $email = $email->replyTo($this->content->replyTo);
        }

        if (isset($this->content->cc) && !empty($this->content->cc)) {
            $email = $email->cc($this->content->cc);
        }

        if (isset($this->content->bcc) && !empty($this->content->bcc)) {
            $email = $email->bcc($this->content->bcc);
        }

        if ( !is_string($this->content->file) && !empty($this->content->file) && count($this->content->file) > 0) {
            foreach ($this->content->file as $files) {
                $mime_type = Storage::mimeType('public/mail/' . $files);
                $email->attachFromStorage('public/mail/' . $files, substr($files, strpos($files, '_')), [
                    'mime' => $mime_type,
                ]);
            }
        } elseif ( !empty($this->content->file) && is_string($this->content->file) ) {
            $files = str_replace('["','', str_replace('"]','',$this->content->file));
            $mime_type = Storage::mimeType('public/mail/' . $files);
            $email->attachFromStorage('public/mail/' . $files, substr($files, strpos($files, '_')), [
                'mime' => $mime_type,
            ]);
        }

        $email->view('email.mailWithAttachment')->with(['data' => $this->content->data, 'content' => $this->content, 'file' => $this->content->file]);
    }
}
