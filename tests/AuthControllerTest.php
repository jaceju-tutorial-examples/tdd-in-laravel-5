<?php

use Illuminate\Support\Facades\Session;

class AuthControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Session::start();
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
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
        $this->doesLoginPass(true);
    }

    public function testLoginFailed()
    {
        $this->doesLoginPass(false);
    }

    public function testLogout()
    {
        $this->userLoggedIn();

        // Mock Auth Guard Object
        $guardMock = Mockery::mock('Illuminate\Auth\Guard');
        $this->app->instance('Illuminate\Contracts\Auth\Guard', $guardMock);

        /* @see App\Http\Middleware\RedirectIfAuthenticated */
        $guardMock
            ->shouldReceive('logout')
            ->once();

        $this->call('GET', 'auth/logout');

        $this->assertRedirectedTo('/');
    }

    public function testRegister()
    {

    }

    protected function doesLoginPass($pass)
    {
        // Mock Auth Guard Object
        $guardMock = Mockery::mock('Illuminate\Contracts\Auth\Guard');
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
            ->andReturn($pass);

        $this->call('POST', 'auth/login', [
            'email'    => 'jaceju@gmail.com',
            'password' => 'password',
            '_token'   => csrf_token(),
        ]);

        if ($pass) {
            $this->assertRedirectedTo('home');
        } else {
            $this->assertHasOldInput();
            $this->assertSessionHasErrors();
            $this->assertRedirectedTo('auth/login');
        }
    }
}
