<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepository;
use App\Task;

class TaskService
{

    /**
     * @var $taskRepo
     */

    private $taskRepo;

    /**
     * Create a new service instance.
     *
     * @param TaskRepository $taskRepo
     */
    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    /**
     * get all tasks from the task table.
     *
     * @return array
     */
    public function getAllTasks()
    {
        return $this->taskRepo->viewTasks();
    }

    /**
     * @param array $parameters
     * @return mixed|object
     */
    public function storeTask(array $parameters)
    {
        return $this->taskRepo->createTask($parameters);
    }

    /**
     * @param array $attr
     * @return mixed|object
     */

    public function updateTask($attr)
    {
        return $this->taskRepo->updateTask($attr);
    }

    /**
     * @param $id
     * @return mixed|object
     */

    public function deleteTask($id)
    {
        return $this->taskRepo->deleteTaskById($id);
    }


}
