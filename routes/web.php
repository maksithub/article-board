<?php
use App\User;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/databoard', 'DataboardController@index')->name('index');

Route::get('/posts/{post}', 'DataboardController@post');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/queryboard', 'QueryboardController@index')->middleware('auth');
});

Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'auth'], function() {
    Route::resource('/blogs', 'BlogController');
    // Route::post('/blogs/{blog}/comment', 'CommentController@store');
    Route::resource('/blogs/{blog}/comments', 'CommentController');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::resource('/posts', 'PostController');
    Route::put('/posts/{post}/publish', 'PostController@publish')->middleware('admin');
    Route::resource('/categories', 'CategoryController', ['except' => ['show']]);
    Route::resource('/tags', 'TagController', ['except' => ['show']]);
    // Route::resource('/comments', 'CommentController', ['only' => ['index', 'destroy']]);
    Route::resource('/users', 'UserController', ['middleware' => 'admin', 'only' => ['index', 'destroy']]);
});

Route::get('/queries', function(Request $request){
    $user_id = $request->user_id;
    if(!empty($user_id)){
        $userString = $user_id;
        $jar_path = app_path('Decrypt/decrypt.jar');
        exec('java -jar '.$jar_path.' '.$userString.' 2>&1', $d_result);
        if(!empty($d_result)){
            $user = User::where('username', $d_result)->first();
            if(empty($user)){
                $mask_str = substr($d_result[0], 0, 2).'***'.substr($d_result[0], -2);
                $arg = [
                    'name'=> $mask_str,
                    'email'=>$d_result[0].'@email.com',
                    'username'=> $d_result[0],
                    'password'=>Hash::make($d_result[0])
                ];
                User::create($arg);
                $user = User::where('username', $d_result)->first();
            }
        }else{
            abort(403, "그런 이용자는 없습니다.");
        }
    }
    if(!empty($user)){
        Auth::login($user);
    }
    return redirect('/queryboard');
})->middleware('userParam');

Route::get('/', function(Request $request){
    $user_id = $request->user_id;
    if(!empty($user_id)){
        $userString = $user_id;
        $jar_path = app_path('Decrypt/decrypt.jar');
        exec('java -jar '.$jar_path.' '.$userString.' 2>&1', $d_result);

        if(!empty($d_result)){
            $user = User::where('username', $d_result)->first();
            if(empty($user)){
                $mask_str = substr($d_result[0], 0, 2).'***'.substr($d_result[0], -2);
                $arg = [
                    'name'=> $mask_str,
                    'email'=>$d_result[0].'@email.com',
                    'username'=> $d_result[0],
                    'password'=>Hash::make($d_result[0])
                ];
                User::create($arg);
                $user = User::where('username', $d_result)->first();
            }
        }else{
            abort(403, "그런 이용자는 없습니다.");
        }
    }

    if(!empty($user)){
        Auth::login($user);
    }
    return redirect('/databoard');
})->middleware('userParam');