<?php

namespace Tests\Unit\Jobs;

use App\Jobs\SendEmailJob;
use App\Mailables\NewMessageEmail;
use Cake\Chronos\Chronos;
use Exception;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Puz\DynamicMail\DynMailer;
use Tests\TestCase;

class SendEmailJobTest extends TestCase
{
    const TEST_FROM = 'test@example.com';
    const TEST_MESSAGE = 'A Message';
    const TEST_IP = '2.3.4.5';

    /**
     * @var \Puz\DynamicMail\DynMailer|\Mockery\Mock
     */
    private $dynmailer;

    /**
     * Setup tests.
     */
    protected function setUp()
    {
        parent::setUp();
        Bus::fake();

        config()->set('mail.driver', 'test-one');
        config()->set('mail.fallback', 'test-two');

        $this->dynmailer = Mockery::mock(DynMailer::class);
        $this->app->instance('puz.dynamic.mailer', $this->dynmailer);

        Chronos::setTestNow(Chronos::now(config('app.timezone')));
    }

    /**
     * Test that the default driver is used on the first go around.
     */
    public function testFirstIteration()
    {
        $this->dynmailer->shouldReceive('via')->with(config('mail.driver'))->once()->andReturnSelf();
        $this->dynmailer->shouldReceive('to')->with(config('mail.deliver_to'))->once()->andReturnSelf();
        $this->dynmailer->shouldReceive('send')->with(Mockery::type(NewMessageEmail::class))->once()->andReturnNull();

        $job = $this->getJob();
        $job->handle();

        $this->assertSame(Chronos::now()->toIso8601String(), $job->queueTime);
    }

    /**
     * Test that the fallback driver is used if the first attempt fails.
     */
    public function testFallbackDriverIsSet()
    {
        $this->getJob()->failed(new Exception('test'));

        Bus::assertDispatched(SendEmailJob::class, function ($job) {
            $this->assertSame(self::TEST_FROM, $job->data['from']);
            $this->assertSame(self::TEST_MESSAGE, $job->data['message']);
            $this->assertSame(self::TEST_IP, $job->data['ip']);
            $this->assertSame(Chronos::now()->toIso8601String(), $job->queueTime);
            $this->assertTrue($job->useFallback);

            return true;
        });
    }

    /**
     * Test that the fallback driver gets set and used correctly.
     */
    public function testSecondIteration()
    {
        $this->dynmailer->shouldReceive('via')->with(config('mail.driver'))->once()->andReturnSelf();
        $this->dynmailer->shouldReceive('via')->with(config('mail.fallback'))->once()->andReturnSelf();
        $this->dynmailer->shouldReceive('to')->with(config('mail.deliver_to'))->once()->andReturnSelf();
        $this->dynmailer->shouldReceive('send')->with(Mockery::type(NewMessageEmail::class))->once()->andReturnNull();

        $job = $this->getJob();
        $job->useFallback = true;
        $job->handle();

        $this->assertSame(Chronos::now()->toIso8601String(), $job->queueTime);
    }

    /**
     * Test that an exception is thrown if the fallback driver fails.
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Failed to send a message over the default and fallback email providers.
     */
    public function testExceptionThrownIfFallbackFails()
    {
        $job = $this->getJob();
        $job->useFallback = true;
        $job->failed(new Exception('test'));

        Bus::assertNotDispatched(SendEmailJob::class);
    }

    /**
     * Return an instance of the job for testing purposes.
     *
     * @return \App\Jobs\SendEmailJob
     */
    private function getJob(): SendEmailJob
    {
        return new SendEmailJob(self::TEST_FROM, self::TEST_MESSAGE, self::TEST_IP);
    }
}
