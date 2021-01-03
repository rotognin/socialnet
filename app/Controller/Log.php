<?php

/**
 * Classe para gravação de Log e mensagens na variável $_SESSION['message']
 */

 namespace App\Controller;

class Log
{
    private function __constructor(){}

    static function write($text)
    {
        $logFile = DIR['log'] . 'log.txt';
        $handle = fopen($logFile, 'a');
        $today = getdate();

        $datetime = $today['mday'] . '/' .
                    $today['mon'] . '/' .
                    $today['year'] . ' ' .
                    $today['hours'] . ':' .
                    $today['minutes'] . ':' .
                    $today['seconds'];

        $textLog = $datetime . ' - ' . $text . PHP_EOL;

        fwrite($handle, $textLog);
        fclose($handle);
    }

    static function message($text)
    {
        $_SESSION['message'] .= $text . PHP_EOL;
    }
}