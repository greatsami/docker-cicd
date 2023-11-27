<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\Response;

it('it should publish a post', function () {
    Queue::fake();
    Notification::fake();

    $user = User::factory()->create();
    $post = Post::factory()->unpublished()->create();

    $this->actingAs($user);

    $response1 = $this->patchJson(route('posts.publish', ['post' => $post]), []);
    $response1->assertStatus(Response::HTTP_NO_CONTENT);

    $response2 = $this->getJson(route('posts.show', ['post' => $post]));
    $response2->assertStatus(Response::HTTP_OK);
});

it('it should return 404 if post is unpublished', function () {
    $user = User::factory()->create();
    $post = Post::factory()->unpublished()->create();

    $this->actingAs($user);

    $response1 = $this->getJson(route('posts.show', ['post' => $post]));
    $response1->assertStatus(Response::HTTP_NOT_FOUND);
});
