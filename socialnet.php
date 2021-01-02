<?php

session_start();

echo include($_SESSION['page']);
//echo __DIR__ . DIRECTORY_SEPARATOR . $_SESSION['page'];