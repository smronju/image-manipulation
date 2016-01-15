<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('image', function(){
	
	// File from url/input field
	$file = file_get_contents('http://landscapelook.com/wp-content/uploads/2015/11/growing_images_of_flowers_and_nature_hd.jpg');
	$image = Image::make($file);

	$fileName = 'flower.jpg';
	$path = public_path().'/uploads';

	// Check if uploads folder exists otherwise create one
	File::exists($path) or File::makeDirectory($path);

	// Save the file original file
	$image->save($path.'/'.$fileName);
	
	// return $image->response('jpg', 100);

	// Croping image width, height, x-cordinate, y-cordinate
	// $image->crop(300, 300);
	
	// Save cropped image
	// $image->crop(300, 300)->save($path.'/cropped-image.jpg');
	
	// Crop & resize combined
	// $image->fit(300);
	
	// Save fit image
	// $image->fit(300)->save($path.'/fitted-image.jpg');
	
	// Add callback functionality to retain maximal original image size
	// $image->fit(400, 250, function ($constraint) {
	// 	$constraint->upsize();
	// });

	// Save fit image
	$image->fit(400, 250, function ($constraint) {
		$constraint->upsize();
	})->save($path.'/fitted-image.jpg');

	// Resize the image to a width of 300 and constrain aspect ratio (auto height)
	// $image->resize(300, null, function($constraint){
	// 	$constraint->aspectRatio();
	// });

    // create response and add encoded image data
    return Response::make($image->encode('jpg'))->header('content-type', 'image/jpg');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
