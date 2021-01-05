<?php

/**
 * Classe para filtrar entradas em campos
 */

namespace app\Controller;

class Filters
{
    static function commomText($text)
    {
        $pattern = '/[^A-Za-z0-9 .,\']/'; // melhorar esse padrão (Adicionar acentuação)
        //Log::write($text . ' - ' . (string) preg_match($pattern, $text));
        return (preg_match($pattern, $text) == 0);
    }

    static function alphaNumbers($text)
    {
        $pattern = '/[^A-Za-z0-9]/';
        //Log::write($text . ' - ' . (string) preg_match($pattern, $text));
        return (preg_match($pattern, $text) == 0);
    }

    
}