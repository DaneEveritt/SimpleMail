<?php

namespace App\Mailables;

use Cake\Chronos\Chronos;
use DateTime;
use Illuminate\Mail\Mailable;

class NewMessageEmail extends Mailable
{
    public $request;

    public $queueTime;

    /**
     * NewMessageEmail constructor.
     *
     * @param array  $data
     * @param string $queueTime
     */
    public function __construct(array $data, string $queueTime)
    {
        $this->data = $data;
        $this->queueTime = $queueTime;
    }

    public function build()
    {
        return $this->replyTo(array_get($this->data, 'from'))
            ->subject('New Message from ' . config('app.name'))
            ->markdown('email.message', [
                'from' => array_get($this->data, 'from'),
                'message' => array_get($this->data, 'message'),
                'ip' => array_get($this->data, 'ip'),
                'sentAt' => Chronos::createFromFormat(DateTime::ISO8601, $this->queueTime, config('app.timezone'))->toDateTimeString(),
            ]);
    }
}
