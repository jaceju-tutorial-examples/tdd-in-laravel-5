<?php

use App\User;
use Illuminate\Support\Facades\Session;

class PostControllerTest extends TestCase {

    protected $postMock = null;

    public function setUp()
    {
        parent::setUp();

        Session::start();
        $this->postMock = Mockery::mock('App\Repositories\PostRepository');
        $this->app->instance('App\Repositories\PostRepository', $this->postMock);
    }

    public function tearDown()
    {
        Mockery::close();
    }

	public function testPostList()
	{
        $this->postMock
            ->shouldReceive('latest10')
            ->once()
            ->andReturn('foo');

		$this->call('GET', '/posts');
		$this->assertResponseOk();

        // 應取得 posts 變數
        $this->assertViewHas('posts', 'foo');
	}

    public function testCreatePostSuccess()
    {
        $this->userLoggedIn();

        $this->postMock
            ->shouldReceive('create')
            ->once();

        Session::start(); // Start a session for the current test
        $this->call('POST', 'posts', [
            'title' => 'subject 999',
            'body' => 'body 999',
            '_token' => csrf_token(), // Retrieve current csrf token
        ]);

        $this->assertRedirectedToRoute('posts.index');
    }

    public function testAuthFailed()
    {
        $this->call('POST', 'posts', [
            '_token' => csrf_token(),
        ]);
        $this->assertRedirectedTo('auth/login');
    }

    public function testCreatePostFails()
    {
        $this->userLoggedIn();

        $this->call('POST', 'posts', [
            '_token' => csrf_token(),
        ]);

        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
        $this->assertResponseStatus(302); // Should redirect to previous url
    }

    public function testCsrfFailed()
    {
        $this->call('POST', 'posts');
        $this->assertResponseStatus(500);
    }

}
