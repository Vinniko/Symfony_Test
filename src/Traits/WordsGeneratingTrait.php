<?php

namespace App\Traits;

trait WordsGeneratingTrait
{
    public function generateTask(int $maxLength = 1, int $minLength = 1, $alphabet = "abcdefghijklmnopqrstuvwxyz 1234567890!@#$%^&*()-=_+[]{}\|,<.>/"){
            $length = rand($minLength, $maxLength);
            $result = "";
            for($i = 0; $i < $length; $i++){
                $result += $alphabet[rand(0, strlen($alphabet))];
            }
            return $result;
    }

    public function generateWord(int $maxLength = 10, int $minLength = 1, $alphabet = "abcdefghijklmnopqrstuvwxyz"){
        $length = rand($minLength, $maxLength);
        $result = "";
        for($i = 0; $i < $length; $i++){
            $result .= $alphabet[rand(0, strlen($alphabet) - 1)];
        }
        return $result;
    }
}
