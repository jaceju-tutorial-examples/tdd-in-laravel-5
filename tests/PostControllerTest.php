<?php

class PostControllerTest extends TestCase {

    public function tearDown()
    {
        Mockery::close();
    }

	public function testPostList()
	{
        $postMock = Mockery::mock('App\Repositories\PostRepository');

        $postMock
            ->shouldReceive('latest10')
            ->once()
            ->andReturn('foo');

        $this->app->instance('App\Repositories\PostRepository', $postMock);

		$this->call('GET', '/');
		$this->assertResponseOk();

        // 應取得 posts 變數
        $this->assertViewHas('posts', 'foo');
	}
}
