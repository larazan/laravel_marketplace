<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailOrderReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $user)
    {
        //
        $this->order = $order;
		$this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $tes = env('TES_EMAIL');

        $orderReceivedEmail = new \App\Mail\OrderReceived($this->order);
		
		Mail::to($tes)->send($orderReceivedEmail);
		// Mail::to($this->user->email)->send($orderReceivedEmail);
    }
}
