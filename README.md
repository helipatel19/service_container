# Laravel Service Container for task management

### Understanding Laravel service container

The Laravel service container is a powerful tool for managing class dependencies and performing dependency injection.You can create object automatically using laravel service container instead of creating manually.

### How To Bind Services In Laravel
We need to register any service container with laravel app by using register method of the service provider.We can register a binding using the bind method, passing the class or interface name that we wish to register along with a Closure that returns an instance of the class.

Following are the available options laravel provides to bind services :

- Simple Bindings
- Binding Singleton
- Binding Instances
- Binding Primitives
- Binding Interfaces To Implementations
- Contextual Binding
- Extending Binding

### Create Custom Laravel Service Container


**Step 1 : Install Fresh Laravel Project**

    composer create-project –prefer-dist  laravel/laravel service_container

Now, set up the database in the .env file.

We will create service container for task management. In order to create that we need to make following files.

1. Model File

2. Controller File

3. Migration File
        
        
    php artisan make:model Task -mc

Above command will create Model , Controller as well as Migration file.

Modify the up() method of the migration file.

Now, go to the terminal and hit the following command.

    php artisan migrate
  
**Step 2 : Create TaskService and TaskServiceProvider**

1. create a directories with the name **Services.** and **Repositories**.
2. create **TaskServiceProvider.php** and **TaskService.php** files into Services directory as well as **TaskInterface.php** and **Taskrepository** files inside Repositories directory.
3. register TaskService into provider's register method like below.


        public function register()
        {
           $this->app->bind(TaskService::class, function ($app) {
                return new TaskService($app[ TaskInterface::class ]);
           });
        }
        
Get the services provided by the provider.
    
    public function provides()
        {
           return [TaskService::class];
        }
        
In addition to this, we will register TaskServiceProvider into the providers array of the config.php file.

4. In our next step, we will define method into TaskInterface.php

         public function viewTasks();
   
   TaskRepository will extend the methods of TaskInterface
     
        public function viewTasks()
        {
            return Task::all();
        }
    
    we can now use this method into TaskService throgh the taskRepo .
   
       public function getAllTasks()
       {
          return $this->taskRepo->viewTasks();
       }

5. create an instance of TaskService and use it inside index method of TaskController.

  we will also need a route file that points to the tasks url. Go to your route file web.php which is located under routes folder and add a GET route for the tasks url.
    
    Route::get('/', 'TaskController@index');

Next, we have used getAllTasks() method of TaskServices to view all the tasks.

        public function index()
        {
            $tasks = $this->taskService->getAllTasks();
            return $tasks;
        }

You can check this output in your browser.

### Test case:

Here, we have created a test case to verify that user can view tasks:
        
        public function user_can_view_tasks(){
                
                $this->actingAs(factory('App\User')->create());
                
                //Given we have an task in database
                $task = factory('App\Task')->make();
        
                //When user visit the task page
                $response = $this->get('/task'); 
        
                // an user should be able to view tasks
                $response->assertOk();
        
            }
            
Run the test, and you should get green !
