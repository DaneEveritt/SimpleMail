<?php

namespace App\Jobs;

use App\Http\Requests\SendMessageRequest;
use App\Mailables\NewMessageEmail;
use Cake\Chronos\Chronos;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * @var bool
     */
    protected $useFallback = false;

    /**
     * @var array
     */
    public $data;

    /**
     * @var string
     */
    public $queueTime;

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
     * Set the job to use the fallback email provider.
     *
     * @return $this
     */
    public function useFallbackProvider()
    {
        $this->useFallback = true;

        return $this;
    }

    /**
     * Send the email using the defined provider.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        // If using fallback set the correct driver.
        if ($this->useFallback) {
            config()->set('mail.driver', config('mail.fallback_driver', 'log'));
        }

        $mailer->to(config('mail.deliver_to'))
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
        Log::error($exception);

        if ($this->useFallback) {
            throw new Exception('Failed to send a message over the default and fallback email providers.');
        }

        $job = new self($this->data['from'], $this->data['message'], $this->data['ip']);
        $job->useFallbackProvider();

        app()->make(Dispatcher::class)->dispatch($job);
    }
}
