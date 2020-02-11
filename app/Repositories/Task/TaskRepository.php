<?php

namespace App\Repositories\Task;

use App\Repositories\Task\TaskInterface;

use App\Task;

class TaskRepository implements TaskInterface
{

    /**
     * This function will retrieve all tasks from the tasks table.
     */

    public function viewTasks()
    {
        return Task::all();
    }

    /**
     * This function will create the new task into databse.
     */

    public function createTask($data)
    {
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        return $task;
    }

    /**
     * This function will update the task with task id
     */

    public function updateTask($data)
    {
        $updateTask = Task::findOrFail($data['id']);
        $updateTask->title = $data['title'];
        $updateTask->description = $data['description'];
        $updated = $updateTask->save();

        return $updated;
    }

    /**
     * This function will delete the task with task id.
     */

    public function deleteTaskById($id)
    {
        $deleteTask = Task::findOrFail($id);
        $deleted = $deleteTask->delete();

        return $deleted;
    }


}
