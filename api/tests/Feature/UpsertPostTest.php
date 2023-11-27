<?php

use Symfony\Component\HttpFoundation\Response;

it('it should create a new post', function () {
    $user = \App\Models\User::factory()->create();
    $data = \App\Models\Post::factory()->published()->make([
        'title' => 'Test post',
        'headline' => 'Test headline',
        'content' => 'Test content',
    ])->toArray();

    $this->actingAs($user);

    $response = $this->postJson(route('posts.store'), $data);
    $response->assertStatus(Response::HTTP_CREATED);

    expect($data['title'])->toBe('Test post');
});

it('it should update a post', function () {
    $user = \App\Models\User::factory()->create();
    $post = \App\Models\Post::factory()->published()->create([
        'title' => 'Test post',
        'headline' => 'Test headline',
        'content' => 'Test content',
    ]);
    $this->actingAs($user);

    $response = $this->patchJson(
        route('posts.update', ['post' => $post]),
        [
            'title' => 'Updated post title',
            'headline' => 'Test headline',
            'content' => 'Updated content',
        ]
    );

    $response->assertStatus(Response::HTTP_NO_CONTENT);

    $post = $this->getJson(route('posts.show', ['post' => $post]))->json('data');
    $this->assertEquals('Updated post title', $post['title']);
    $this->assertEquals('Test headline', $post['headline']);
    $this->assertEquals('Updated content', $post['content']);
});
