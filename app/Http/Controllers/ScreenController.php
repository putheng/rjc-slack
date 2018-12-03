<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JonnyW\PhantomJs\Client;

class ScreenController extends Controller
{
    public function index()
    {
		$client = Client::getInstance();
	    
	    $width  = 1200;
	    $height = 1000;
	    $top    = 0;
	    $left   = 0;
	    $path = public_path('file.jpg');
	    $client->getEngine()->setPath(app_path('bin/bin/phantomjs'));
	    
	    $url = 'https://docs.google.com/spreadsheets/d/1jjmA7ITK84I7JAL4mYQZIXSF9FrFnEgAK6V17IA_-gc/edit?usp=sharing';

	    $request = $client->getMessageFactory()
	    		->createCaptureRequest($url, 'GET');
	    $request->setOutputFile($path);
	    $request->setViewportSize($width, $height);
	    $request->setCaptureDimensions($width, $height, $top, $left);

	    /** 
	     * @see JonnyW\PhantomJs\Http\Response 
	     **/
	    $response = $client->getMessageFactory()->createResponse();

	    // Send the request
	    $client->send($request, $response);
    }
}
