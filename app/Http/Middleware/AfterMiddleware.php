<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Http;

class AfterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // // Define the path to the Node.js script
        // $scriptPath = base_path('scripts/node-enhance.mjs');

        // // Command to execute the Node.js script
        // // The HTML content is passed as a command-line argument
        // $command = "node {$scriptPath} " . escapeshellarg($response->getContent());

        // // Run the process
        // $processResult = Process::run($command);

        // // Check if the process was successful and get the output
        // if ($processResult->successful()) {
        //     $minifiedOutput = $processResult->output();
        //     $response->setContent($minifiedOutput);
        // } else {
        //     dd($command, $processResult->output());
        //     // Handle the error appropriately
        //     // Log error or take necessary action
        // }

        // make post request to http://127.0.0.1:6998/api/enhance with the content of $response->getContent() as body
        $url = 'http://127.0.0.1:6998/api/html';
        // Use  Illuminate\Support\Facades\Http to make the POST request with current response as body

        $newResponse = Http::post($url, [
            'html' => $response->getContent(),
            'enhance' => true,
            'minify' => true
        ]);


        // dd($newResponse->body());
        // get the response from the post request and set it as the content of the response
        $response->setContent($newResponse->body());

        return $response;
    }
}
