<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Estimate;
use Auth;
use Config;

class EstimateGenerated extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * The data instance.
    *
    * @var array
    */
   public $estimate;
   public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Estimate $estimate, $request)
    {
        $this->estimate = $estimate;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Config::set('mail.username', Auth::user()->email);
        Config::set('mail.password', Auth::user()->email_password);
        Config::set('mail.from', ['address' => Auth::user()->email, 'email_password' => Auth::user()->email_password]);
        return $this->view('emails.estimate')
                ->subject($this->request->input('subject'))
                ->attach($this->request->input('pdf'));
    }
}
