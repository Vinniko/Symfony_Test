<?php

namespace App\Traits;

trait WordsGeneratingTrait
{
    public function GenerateTask(int $maxLength = 1, int $minLength = 1, $aplhabet = "abcdefghijklmnopqrstuvwxyz 1234567890!@#$%^&*()-=_+[]{}\|,<.>/"){
            $length = rand($minLength, $maxLength);
            $result = "";
            for($i = 0; $i < $length; $i++){
                $result += $aplhabet[rand(0, strlen($aplhabet))];
            }
            return $result;
    }

    public function GenerateWord(int $maxLength = 10, int $minLength = 1, $aplhabet = "abcdefghijklmnopqrstuvwxyz"){
        $length = rand($minLength, $maxLength);
        $result = "";
        for($i = 0; $i < $length; $i++){
            $result .= $aplhabet[rand(0, strlen($aplhabet) - 1)];
        }
        return $result;
    }
}
