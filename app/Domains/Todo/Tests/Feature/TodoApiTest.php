<?php

namespace App\Domains\Todo\Tests\Feature;

use App\Domains\Todo\Database\Models\Todo;
use App\Domains\Todo\Enums\TodoStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route_returns_models(): void
    {

        Todo::factory()->pending()->count(10)->create();

        $response = $this->get(route('todos.index'));

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');

        $this->assertDatabaseCount('todos', 10);
    }
    public function test_show_shows_model(): void
    {

        $todo = Todo::factory()->pending()->create();

        $response = $this->get(route('todos.show',$todo->getKey()));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $todo->getKey()
                ]
            ]);


    }
    public function test_index_route_returns_filtered_models(): void
    {

        Todo::factory()->pending()->count(5)->create();
        Todo::factory()->inProgress()->count(10)->create();
        Todo::factory()->done()->count(15)->create();


        $response = $this->get(route('todos.index',[
            'status' => TodoStatusEnum::PENDING->value
        ]));

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');


        $response = $this->get(route('todos.index',[
            'status' => TodoStatusEnum::IN_PROGRESS->value
        ]));

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');

        $response = $this->get(route('todos.index',[
            'status' => TodoStatusEnum::DONE->value,
            'limit' => 15,
        ]));

        $response->assertStatus(200)
            ->assertJsonCount(15, 'data');

    }

    public function test_store_route_stores_successfully(): void
    {
        $request = [
            'title' => 'Workout',
            'description' => '45 Minutes'
        ];

        $response = $this->post(route('todos.store'), $request);

        $response
            ->assertStatus(ResponseAlias::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    'title' => 'Workout'
                ]
            ]);

        $this->assertDatabaseCount('todos', 1);
    }

    public function test_update_route_updates_title_successfully(): void
    {
        $todo = Todo::factory()->pending()->create();

        $request = [
            'title' => 'Workout',
            'description' => '45 Minutes',
            'status' => 5
        ];
        $response = $this->patch(route('todos.update', $todo->getKey()), $request);

        $response
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson([
                'data' => [
                    'title' => 'Workout',
                    'status' => 'In Progress',
                    'done_at' => null
                ]
            ]);

        $this->assertDatabaseCount('todos', 1);
    }

    public function test_update_route_updates_done_at_on_done_status_successfully(): void
    {
        $todo = Todo::factory()->pending()->create();

        $request = [
            'title' => 'Workout',
            'description' => '45 Minutes',
            'status' => 10
        ];

        $response = $this->patch(route('todos.update', $todo->getKey()), $request);

        $response
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson([
                'data' => [
                    'title' => 'Workout',
                    'status' => 'Done',
                ]
            ]);

        $todo->refresh();

        $this->assertTrue($todo->done_at !== null);
    }

    public function test_delete_route_deletes_not_done_todo_successfully(): void
    {
        $todo = Todo::factory()->pending()->create();

        $response = $this->delete(route('todos.destroy', $todo->getKey()));

        $response
            ->assertStatus(ResponseAlias::HTTP_OK);

        $this->assertSoftDeleted('todos', ['id' => $todo->getKey()]);
    }

    public function test_delete_route_deletes_done_todo_should_throw_error(): void
    {
        $todo = Todo::factory()->done()->create();

        $response = $this->delete(route('todos.destroy', $todo->getKey()));

        $response
            ->assertStatus(ResponseAlias::HTTP_BAD_REQUEST);

        $this->assertDatabaseHas('todos', ['id' => $todo->getKey()]);
    }
}
