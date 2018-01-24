<?php

namespace App\Jobs;

use App\Mailables\NewMessageEmail;
use Cake\Chronos\Chronos;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * @var array
     */
    public $data;

    /**
     * @var string
     */
    public $queueTime;

    /**
     * Maximum number of times this job can be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * @var bool
     */
    public $useFallback = false;

    /**
     * SendEmailJob constructor.
     *
     * @param string $from
     * @param string $message
     * @param string $ip
     */
    public function __construct(string $from, string $message, string $ip)
    {
        $this->data = [
            'from' => $from,
            'message' => $message,
            'ip' => $ip,
        ];

        $this->queueTime = Chronos::now(config('app.timezone'))->toIso8601String();
    }

    /**
     * Send the email using the defined provider.
     */
    public function handle()
    {
        /** @var \Puz\DynamicMail\DynMailer $mailer */
        $mailer = app()->make('puz.dynamic.mailer');
        $service = $mailer->via(config('mail.driver'));

        // If using fallback set the correct driver.
        if ($this->useFallback) {
            $service = $mailer->via(config('mail.fallback', 'log'));
        }

        $service->to(config('mail.deliver_to'))
            ->send(new NewMessageEmail($this->data, $this->queueTime));
    }

    /**
     * If the job fails push a new job onto the queue to attempt sending this
     * message using the fallback email provider. If this job failed on the
     * faillback provider log an exception.
     *
     * @param \Exception $exception
     * @throws \Exception
     */
    public function failed(Exception $exception)
    {
        if ($this->useFallback) {
            throw new Exception('Failed to send a message over the default and fallback email providers.');
        }

        $job = new self($this->data['from'], $this->data['message'], $this->data['ip']);
        $job->useFallback = true;

        app()->make(Dispatcher::class)->dispatch($job);
    }
}
