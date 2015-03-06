<?php

use App\User;
use Illuminate\Support\Facades\Session;

class ArticleControllerTest extends TestCase {

    protected $repositoryMock = null;

    public function setUp()
    {
        parent::setUp();

        Session::start();
        $this->repositoryMock = Mockery::mock('App\Repositories\ArticleRepository');
        $this->app->instance('App\Repositories\ArticleRepository', $this->repositoryMock);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

	public function testArticleList()
	{
        $this->repositoryMock
            ->shouldReceive('latest10')
            ->once()
            ->andReturn('foo');

		$this->call('GET', '/articles');
		$this->assertResponseOk();

        // 應取得 articles 變數
        $this->assertViewHas('articles', 'foo');
	}

    public function testCreateArticleSuccess()
    {
        $this->userLoggedIn();

        $this->repositoryMock
            ->shouldReceive('create')
            ->once();

        Session::start(); // Start a session for the current test
        $this->call('POST', 'articles', [
            'title' => 'subject 999',
            'body' => 'body 999',
            '_token' => csrf_token(), // Retrieve current csrf token
        ]);

        $this->assertRedirectedToRoute('articles.index');
    }

    public function testAuthFailed()
    {
        $this->call('POST', 'articles', [
            '_token' => csrf_token(),
        ]);
        $this->assertRedirectedTo('auth/login');
    }

    public function testCreateArticleFails()
    {
        $this->userLoggedIn();

        $this->call('POST', 'articles', [
            '_token' => csrf_token(),
        ]);

        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
        $this->assertResponseStatus(302); // Should redirect to previous url
    }

    public function testCsrfFailed()
    {
        $this->call('POST', 'articles');
        $this->assertResponseStatus(500);
    }

}
