<?php

namespace TL\CoreBundle\Services;

class Calculator
{

    public function age($today, $birthday)
    {
        $result = ($today->getTimestamp() - $birthday->getTimestamp())/365/30/24/60/2;
        return floor($result);
    }

    public function price($age, $type, $isReduced)
    {
        $price = 0;

        if ($age >= 60) {
            $price = 12;
        } else if($age < 12 && $age >= 4) {
            $price = 8;
        } else if($age < 4) {
            $price = 0;
        } else if($isReduced === true) {
            $price = 10;
        } else {
            $price = 16;
        }

        if ($type === 'halfDay') {
            return $price/2;
        } else {
            return $price;
        }
    }

}
