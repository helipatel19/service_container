# Laravel Service Container for task management

### What is service container in Laravel

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

Now, set up the database in the ``.env`` file.

We will create service container for task management. In order to create that we need to make following files.

1. Model File

2. Controller File

3. Migration File.
    

       php artisan make:model Task -mc

Above command will create Model , Controller as well as Migration file.

Modify the up() method of the migration file.

Now, go to the terminal and hit the following command.

       php artisan migrate
  
**Step 2 : Create TaskService and TaskServiceProvider**

1. Create a directories with the name **Services** and **Repositories**.
2. Create **TaskServiceProvider.php** and **TaskService.php** files into Services directory as well as **TaskInterface.php** and **TaskRepository** files inside Repositories directory.
3. Register TaskService into TaskServiceProvider's register method like below.


        public function register()
        {
           $this->app->bind(TaskService::class, function($app) {
                    return new TaskService($app[ TaskInterface::class ]);
           });
        }
        
provides() method will return TaskService.
 
        public function provides()
        {
           return [TaskService::class];
        }
        
In addition to this, we will register TaskServiceProvider into the providers array of the config.php file.

4. In our next step, we will define method for viewing all the tasks into TaskInterface.php


        public function viewTasks;
     
   TaskRepository will extend the methods of TaskInterface

        public function viewTasks()
        {
           return Task::all();
        }
        
   We can now use this method into TaskService through the taskRepo instance of TaskRepository.

        public function getAllTasks()
        {
           return $this->taskRepo->viewTasks();
        }

  Create an instance of TaskService and use it inside index method of TaskController.

   We will also need a route file that points to the tasks url. Go to your route file web.php which is located under routes folder and add a GET route for the tasks url.
    
        Route::get('/task', 'TaskController@index');

  Next, we have used getAllTasks() method of TaskServices to view all the tasks.

        public function index()
        {
            $tasks = $this->taskService->getAllTasks();
            return $tasks;
        }
        
5. Not only this, we have also defined method inside TaskInterface to store the task .

    
    public function createTask($taskId);

   TaskRepository will extend this method and it will perform create task operation .

        public function createTask($data)
        {
            $task = Task::create([
                    'title' => $data['title'],
                   'description' => $data['description'],
            ]);
               
            return $task;
        }
   
   We can now use this method into TaskService through the taskRepo instance of TaskRepository.

        public function storeTask(array $parameters)
        {
            return $this->taskRepo->createTask($parameters);
        }
    
   Create an instance of TaskService and use it inside store method of TaskController.
   
   Go to your route file ``web.php`` which is located under routes folder and add a POST route for the store task process.
       
        Route::post('/task/store', 'TaskController@store');
   
   Next, we have used storeTask() method of TaskServices to add task.

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
            
            // this will call the method storeTask from TaskService
            $this->taskService->storeTask($request->all());
    
            return redirect('/task');
        }

   Now,check this output in your browser.

### Test cases:

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
    
Now, we have created another test case for adding tasks.

         public function user_can_add_tasks(){
            
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

Run the tests, and you should get green !
