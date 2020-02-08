<?php

namespace App\Repositories\Task;

interface TaskInterface
{

    /**
     * Create task in database
     */

    public function createTask($taskId);

    /**
     * Retrieve all the tasks.
     */

    public function viewTasks();

    /**
     * Update the tasks into database.
     */

    public function updateTask($data);

    /**
     * Delete the tasks by Id.
     */

    public function deleteTaskById($id);

}
