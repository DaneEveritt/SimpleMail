<?php

namespace Tests\Feature;

use App\Jobs\SendEmailJob;
use Cake\Chronos\Chronos;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class RestControllerTest extends TestCase
{
    /**
     * Setup tests.
     */
    protected function setUp()
    {
        parent::setUp();
        Bus::fake();
        Chronos::setTestNow(Chronos::now());
    }

    /**
     * Test valid message being provided.
     */
    public function testSuccessfulMessage()
    {
        $response = $this->post('/send', [
            'email' => 'test@example.com',
            'message' => 'My Message',
        ]);

        Bus::assertDispatched(SendEmailJob::class, function ($job) {
            $this->assertArrayHasKey('from', $job->data);
            $this->assertArrayHasKey('message', $job->data);
            $this->assertArrayHasKey('ip', $job->data);

            $this->assertSame('test@example.com', $job->data['from']);
            $this->assertSame('My Message', $job->data['message']);
            $this->assertSame('127.0.0.1', $job->data['ip']);

            $this->assertSame(Chronos::now()->toIso8601String(), $job->queueTime);

            return true;
        });

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test that validation occurs properly.
     *
     * @dataProvider invalidDataDataProvider
     */
    public function testInvalidData($data, $errors)
    {
        $response = $this->json('POST', '/send', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errors);
    }

    /**
     * Provide bad data to use in tests.
     *
     * @return array
     */
    public function invalidDataDataProvider(): array
    {
        return [
            [['email' => 'bad'], ['email', 'message']],
            [['email' => 'good@example.com'], ['message']],
            [['message' => ''], ['email', 'message']],
            [['message' => 'Test'], ['email']],
        ];
    }
}
