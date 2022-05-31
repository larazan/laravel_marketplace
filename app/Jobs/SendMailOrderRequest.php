<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailOrderRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $user;
    protected $cs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $user, $cs)
    {
        //
        $this->order = $order;
		$this->user = $user;
		$this->cs = $cs;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $orderRequestEmail = new \App\Mail\OrderRequest($this->order);
		
		Mail::to($this->user->email)->cc($this->cs)->send($orderRequestEmail);
    }
}
