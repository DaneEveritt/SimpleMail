<?php

namespace Tests\Feature;

use Tests\TestCase;

class BaseControllerTest extends TestCase
{
    /**
     * Test that the index view is returned.
     */
    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }
}
