<?php

use Illuminate\Support\Facades\Request;

function setActive($route)
{
    return Request::route()->getName() == $route ? 'active' : '';
}


function setActiveParams($route)
{
    return Request::is($route) ? 'active' : '';
}

function setActiveFilter($parameters = [])
{
    $active = false;
    foreach ($parameters as $key => $parameter) {
        if (Request::query($key) == $parameter) {
            $active = true;
        } else {
            $active = false;
            break;
        }
    }

    return $active ? "active" : "";
}
