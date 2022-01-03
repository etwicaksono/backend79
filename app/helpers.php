<?php
if (!function_exists("get_point")) {
    function get_point($desc, $amount)
    {
        $point = 0;

        switch (trim(strtolower($desc))) {
            case "beli pulsa":
                if ($amount > 10000 && $amount <= 30000) {
                    $amount -= 10000;
                    $point = $amount / 1000;
                } else if ($amount > 30000) {
                    $amount -= 30000;
                    $point = 20;
                    $point += ($amount / 1000) * 2;
                }
                break;
            case "bayar listrik":
                if ($amount > 50000 && $amount <= 100000) {
                    $amount -= 50000;
                    $point = $amount / 2000;
                } else if ($amount > 100000) {
                    $amount -= 100000;
                    $point = 25;
                    $point += ($amount / 2000) * 2;
                }
                break;
            default:

                break;
        }
        return $point;
    }
}