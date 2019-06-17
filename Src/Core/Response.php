<?php

namespace Previateri\Bolton\Core;

class Response
{
    public function __invoke($action, $params)
    {
        if (is_string($action)) {
            $action = explode("::", $action);
            $action[0] = new $action[0];
        }

       $response = call_user_func_array($action, $params);
       
       if (is_array($response)) {
           $response = json_encode($response, true);
       } else {
           $response = null;
       }

       print $response;
    }
}