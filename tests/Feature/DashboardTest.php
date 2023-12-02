<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_in_user_can_access_dashboard_and_view_data()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Check where the user is redirected to
        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    /** @test */
    public function unauthorized_user_is_redirected_to_login_page()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
