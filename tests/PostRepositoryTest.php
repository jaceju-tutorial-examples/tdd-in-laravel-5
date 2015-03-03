<?php

use App\Repositories\PostRepository;
use App\Post;

class PostRepositoryTest extends TestCase
{
    const POST_COUNT = 100;

    /**
     * @var PostRepository
     */
    protected $posts = null;

    /**
     * 預塞資料供測試用
     */
    protected function seedData()
    {
        for ($i = 1; $i <= self::POST_COUNT; $i ++) {
            Post::create([
                'title' => 'subject ' . $i,
                'body'  => 'body ' . $i,
            ]);
        }
    }

    public function setUp()
    {
        parent::setUp();
        $this->initDatabase();
        $this->seedData();
        $this->posts = new PostRepository();
    }

    public function tearDown()
    {
        $this->resetDatabase();
        $this->posts = null;
    }

    public function testFetchLatest10Posts()
    {
        $posts = $this->posts->latest10();
        $this->assertEquals(10, count($posts));

        // 確認是從 100 ~ 91 倒數
        $i = 100;
        foreach ($posts as $post) {
            $this->assertEquals('subject ' . $i, $post->title);
            $this->assertEquals('body ' . $i, $post->body);
            $i -= 1;
        }
    }
}
