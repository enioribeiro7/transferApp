<?php

namespace App\Jobs;

use App\Mail\NotificationTransferReceivedMail;
use App\Mail\NotificationTransferSentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationTransferEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $tries = 3;
    
    private $de;
    private $para;
    private $amount;

    public function __construct(User $de, User $para, float $amount)
    {
        $this->de = $de;
        $this->para = $para;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new NotificationTransferSentMail($this->de, $this->para, $this->amount));
        Mail::send(new NotificationTransferReceivedMail($this->de, $this->para, $this->amount));
    }
    
    public function trigger(User $from, User $to, float $amount)
    {
        self::dispatch($from, $to, $amount)->delay(now()->addSeconds('15'));
    }

}
