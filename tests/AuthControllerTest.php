<?php

use Illuminate\Support\Facades\Session;

class AuthControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Session::start();
    }

    public function testLoginInvalidInput()
    {
        $this->call('POST', 'auth/login', [
            '_token' => csrf_token(),
        ]);

        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
        $this->assertResponseStatus(302); // Should redirect to previous url
    }

    public function testLoginSuccess()
    {
        // Mock Auth Guard Object
        $guardMock = Mockery::mock('Illuminate\Auth\Guard');
        $this->app->instance('Illuminate\Contracts\Auth\Guard', $guardMock);

        /* @see App\Http\Middleware\RedirectIfAuthenticated */
        $guardMock
            ->shouldReceive('check')
            ->once()
            ->andReturn(false);

        /* @see Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers */
        $guardMock
            ->shouldReceive('attempt')
            ->once()
            ->andReturn(true);

        $this->call('POST', 'auth/login', [
            'email'    => 'jaceju@gmail.com',
            'password' => 'password',
            '_token'   => csrf_token(),
        ]);

        $this->assertRedirectedTo('home');
    }

    public function testLoginFailed()
    {
        // Mock Auth Guard Object
        $guardMock = Mockery::mock('Illuminate\Auth\Guard');
        $this->app->instance('Illuminate\Contracts\Auth\Guard', $guardMock);

        /* @see App\Http\Middleware\RedirectIfAuthenticated */
        $guardMock
            ->shouldReceive('check')
            ->once()
            ->andReturn(false);

        /* @see Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers */
        $guardMock
            ->shouldReceive('attempt')
            ->once()
            ->andReturn(false);

        $this->call('POST', 'auth/login', [
            'email'    => 'jaceju@gmail.com',
            'password' => 'password',
            '_token'   => csrf_token(),
        ]);

        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
        $this->assertRedirectedTo('auth/login');
    }
}
