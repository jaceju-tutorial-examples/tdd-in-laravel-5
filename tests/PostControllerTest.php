<?php

class PostControllerTest extends TestCase {

	public function testPostList()
	{
		$this->call('GET', '/');
		$this->assertResponseOk();
	}

}
