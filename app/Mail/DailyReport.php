<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyReport extends Mailable
{
    use Queueable, SerializesModels;
    public $trial_path;
    public $income_path;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trial_path,$income_path)
    {
        $this->trial_path = $trial_path;
        $this->income_path = $income_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Financtics Daily Report')->view('Emails.reports')->attach($this->trial_path)->attach($this->income_path);//->attach($this->path)
    }
}
