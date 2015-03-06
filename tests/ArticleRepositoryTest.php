<?php

use App\Repositories\ArticleRepository;
use App\Article;

class ArticleRepositoryTest extends TestCase
{
    const ARTICLE_COUNT = 100;

    /**
     * @var ArticleRepository
     */
    protected $repository = null;

    /**
     * 預塞資料供測試用
     */
    protected function seedData()
    {
        for ($i = 1; $i <= self::ARTICLE_COUNT; $i ++) {
            Article::create([
                'title' => 'title ' . $i,
                'body'  => 'body ' . $i,
            ]);
        }
    }

    public function setUp()
    {
        parent::setUp();
        $this->initDatabase();
        $this->seedData();
        $this->repository = new ArticleRepository();
    }

    public function tearDown()
    {
        $this->resetDatabase();
        $this->repository = null;
    }

    public function testFetchLatest10Posts()
    {
        $posts = $this->repository->latest10();
        $this->assertEquals(10, count($posts));

        // 確認是從 100 ~ 91 倒數
        $i = 100;
        foreach ($posts as $post) {
            $this->assertEquals('title ' . $i, $post->title);
            $this->assertEquals('body ' . $i, $post->body);
            $i -= 1;
        }
    }

    public function testCreatePost()
    {
        $latestId = self::ARTICLE_COUNT + 1;

        $article = $this->repository->create([
            'title' => 'title ' . $latestId,
            'body'  => 'body ' . $latestId,
        ]);

        $this->assertEquals(self::ARTICLE_COUNT + 1, $article->id);
    }
}
