<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */

namespace GreatOwl\Application;

use Slim\Http\Request;
use Slim\Http\Response;

class Main
{
    public function __invoke(Request $request, Response $response, $arguments)
    {
        $response->write('this is just the beginning of my application');

        foreach ($arguments as $argument) {
            $response->write("\n $argument");
        }
    }
}
