<?php

session_start();

function autoload($class)
{
    include_once($class . 'php');
}
spl_autoload_register('autoload');

