<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Services\Task\TaskService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    protected $task;
    protected $taskService;

    public function __construct(Task $task,TaskService $taskService)
    {
        $this->task = $task;
        $this->taskService = $taskService;
    }

    /**
     *  get all task data and display from the getAllTasks service method
     */

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return redirect('/task');
    }

    /**
     * store the task into tasks table using the storeTask method from the TaskService
     */

    public function store(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
        );

        $validator = validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/task/create')->withInput()->withErrors($validator);
        }

        $this->taskService->storeTask($request->all());

        return redirect('/task');
    }

    /**
     * update the the task using updateTask method of TaskService
     */

    public function update(Request $request)
    {
        $task = $this->taskService->updateTask($request);
    }

    /**
     * delete the task using deleteTask method of TaskService.
     */

    public function delete($id)
    {
        $this->taskService->deleteTask($id);
        return redirect('/task');
    }
}
