<?php

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



// Route::get('/', function()
// {
//     return View::make('admin.home');
// });
// Route::get('about', function()
// {
//     return View::make('admin.about');
// });
// Route::get('projects', function()
// {
//     return View::make('admin.projects');
// });
// Route::get('contact', function()
// {
//     return View::make('admin.contact');
// });

Auth::routes();
Route::get('/', function () {
    return redirect('admin/home');
});


Route::group(['prefix' => 'admin/',  'middleware' => 'auth'], function()
{
	Route::get('home', 'HomeController@index')->name('home');

	Route::get('levels', function () {
	    return view('admin.levels');
	});
	Route::get('courses', function () {
	    return view('admin.courses');
	});
	Route::get('subjects', function () {
	    return view('admin.subjects');
	});
	Route::get('chapters', function () {
	    return view('admin.chapters');
	});
});

Route::group(['prefix' => 'api',  'middleware' => 'auth'], function(){
	Route::get('/levels','admin\LevelsController@allLevel');
	Route::post('/level','admin\LevelsController@addLevel');
	Route::get('/level/{id}','admin\LevelsController@getLevel');
	Route::post('/level/{id}','admin\LevelsController@editLevel');
	Route::delete('/level/{id}','admin\LevelsController@deleteLevel');

});

Route::group(['prefix' => 'api',  'middleware' => 'auth'], function(){
	Route::get('/courses', 'admin\CoursesController@allCourses');
	Route::get('/course/{id}', 'admin\CoursesController@getCourse');
	Route::post('/course', 'admin\CoursesController@addCourse');
	Route::post('/course/{id}', 'admin\CoursesController@editCourse');
	Route::delete('/course/{id}','admin\CoursesController@deleteCourse');
	
	Route::get('/level/{id}/courses','admin\CoursesController@coursesByLevel');
});

Route::group(['prefix' => 'api',  'middleware' => 'auth'], function(){
	Route::get('/subjects', 'admin\SubjectsController@allSubjects');
	Route::get('/subject/{id}', 'admin\SubjectsController@getSubject');
	Route::post('/subject', 'admin\SubjectsController@addSubject');
	Route::post('/subject/{id}', 'admin\SubjectsController@editSubject');
	Route::delete('/subject/{id}','admin\SubjectsController@deleteSubject');
	
	Route::get('/course/{id}/subjects','admin\SubjectsController@subjectsByCourse');
});

Route::group(['prefix' => 'api',  'middleware' => 'auth'], function(){
	Route::get('/chapters', 'admin\ChaptersController@allChapters');
	Route::get('/chapter/{id}', 'admin\ChaptersController@getChapter');
	Route::post('/chapter', 'admin\ChaptersController@addChapter');
	Route::post('/chapter/{id}', 'admin\ChaptersController@editChapter');
	Route::delete('/chapter/{id}','admin\ChaptersController@deleteChapter');
});


