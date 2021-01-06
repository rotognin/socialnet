<?php

/**
 * Funções para formatação de Datas, Horas, e demais campos
 */

 function DateTime(string $dateTime)
 {
     // 2021-01-05 07:37:50
     // 01234567890123456789
     return substr($dateTime, 8, 2) . '/' .
            substr($dateTime, 5, 2) . '/' .
            substr($dateTime, 0, 4) . ' ' .
            substr($dateTime, 11, 5);
 }