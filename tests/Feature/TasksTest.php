<?php

namespace Tests\Feature;

use App\User;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /** @test */

    public function user_can_view_tasks(){

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        //Given we have an task in database
        $task = factory('App\Task')->make();

        //When user visit the task page
        $response = $this->get('/task'); // your route to get article

        // an user should be able to view tasks
        $response->assertRedirect('/task');

    }

    /** @test */

    public function user_can_add_tasks(){

       $this->withoutExceptionHandling();
       $this->withoutMiddleware();

        //Given we have an authenticated user
        //And a task object
        $task = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
                         ->withSession(['id' => $user->id])
                         ->post('/task/store', $task);

        //When user submits post request to create task endpoint
        //It gets stored in the database
        $response->assertRedirect('/task');
    }

    /** @test */

    public function user_can_update_the_task(){
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();

        //Given we have a signed in user
        $this->actingAs(factory('App\User')->create());

        //And a task which is created by the user
        $task = factory('App\Task')->create();

        //When the user hit's the endpoint to update the task
        $response = $this->put('/task/update/'.$task->id, $task->toArray());

        //The task should be updated in the database.
        $response->assertOk();
    }

    /** @test */

    public function user_can_delete_the_task()
    {
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $task = factory('App\Task')->create();

        $response = $this->put('/task/delete/'.$task->id);

        //The task should be deleted from the database.
        $response->assertRedirect('/task');

    }

}
