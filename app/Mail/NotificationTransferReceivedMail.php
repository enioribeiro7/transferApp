<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationTransferReceivedMail extends Mailable
{
    use Queueable, SerializesModels;
    
    private $de;
    private $para;
    private $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(User $de, User $para, float $amount)
    {
        $this->de = $de;
        $this->para = $para;
        $this->amount = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Nova Transferência recebida!');
        $this->to($this->para->email, $this->para->name);

        return $this->view('mail.notificationTransferReceivedMail',[
            'de' => $this->de,
            'para' => $this->para,
            'amount' => $this->amount,

        ]);
    }
}
