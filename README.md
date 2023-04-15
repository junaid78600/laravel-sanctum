# Laravel Sanctum 
What is Laravel Sanctum ?
Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform..

### You have to just follow a few steps to get following web services
##### Login API
##### Details API




## Getting Started
### Step 1: setup database in .env file

```` 
DB_DATABASE=laravel_sanctum
DB_USERNAME=root
DB_PASSWORD=
````

## Step 2:Install Laravel Sanctum.

````
composer require laravel/sanctum
````

## Step 3:Publish the Sanctum configuration and migration files .

````
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

````

## Step 4:Run your database migrations.

````
php artisan migrate

````

## Step 5:Add the Sanctum's middleware.

````
../app/Http/Kernel.php

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

...

    protected $middlewareGroups = [
        ...

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    ...
],

````

## Step 6:To use tokens for users.

````
../app/Models/User.php

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
}

````

## Step 7:Let's create the seeder for the User model

```` 
php artisan make:seeder UsersTableSeeder
````

## Step 8:Now let's insert as record

```javascript 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
...
...
DB::table('users')->insert([
    'name' => 'Junaid Akhtar',
    'email' => 'junaid@gmail.com',
    'password' => Hash::make('12345')
]);
````

## Step 9:To seed users table with user

```javascript 
php artisan db:seed --class=UsersTableSeeder
````


## Step 10:  create a controller :


```javascript 
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    // 

    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }
}



````

## Step 11:  create a Comman controller with Model Country:

```javacript
        <?php

        namespace App\Http\Controllers;

        use Illuminate\Http\Request;
        use App\Models\Country;

        class CommonController extends Controller
        {
        public function index(Request $request)
        {
                $data = Country::all();
                $response = [
                    'data' => $data,
                    'message' => 'Fetch Succesfully'
                ];
            
                return response($response, 201);

        }
        }

````


## Step 12: create a login route in the routes/api.php file

    ````
            Route::post("login",[UserController::class,'index']);
    ````

## Step 13:Open Postman and hit login api

    
![login](https://user-images.githubusercontent.com/45033213/230798537-742739f8-9a22-4f80-8a12-2e7be46c2b1f.PNG)



## Step 14: Make Details API or any other with secure route  

```javascript
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::get("country",[CommonController::class,'index']);
    });
 ````


## Step 15: Add Bearer Token into Postman Authorization tab 

  token fetch from login Api with is showing at point 12

![bearer](https://user-images.githubusercontent.com/45033213/230798812-1dea2beb-d5d3-4249-8c70-61c1c58dbdc6.PNG)


## Response of the Api

![res](https://user-images.githubusercontent.com/45033213/230798862-b4577bfe-0365-4263-ba9b-28f1ae2440e2.PNG)


## if not use token then the Response

![no_auth](https://user-images.githubusercontent.com/45033213/230798910-db48d411-53e0-4199-9c11-1a69413498b1.PNG)

