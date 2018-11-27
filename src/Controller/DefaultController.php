<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DefaultController 
{
    public function indexAction(Request $request)
    {
        return new Response('<b>Default Home Page</b>', 200);
    }
    
    public function testAction(Request $request)
    {
        return new Response('<b>test Action page</b>', 200);
    }
}