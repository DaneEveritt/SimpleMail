<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Jobs\SendEmailJob;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Response;

class RestController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Bus\Dispatcher
     */
    private $dispatcher;

    /**
     * RestController constructor.
     *
     * @param \Illuminate\Contracts\Bus\Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle a request to send a new message to the defined application email.
     * Pushes the email message onto the queue worker and returns the user
     * back to the application homepage.
     *
     * @param \App\Http\Requests\SendMessageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendMessageRequest $request): Response
    {
        $this->dispatcher->dispatch(new SendEmailJob(
            $request->input('email'),
            $request->input('message'),
            $request->ip()
        ));

        return redirect()->route('index');
    }
}
