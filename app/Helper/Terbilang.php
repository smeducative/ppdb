<?php

namespace App\Helper;

class Terbilang
{
    public function convert($number)
    {
        $number = str_replace('.', '', $number);
        if (! is_numeric($number)) {
            throw new Exception('Please input number.');
        }
        $base = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
        $numeric = ['1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1];
        $unit = ['kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', ''];
        $str = null;
        $i = 0;
        if ($number == 0) {
            $str = 'nol';
        } else {
            while ($number != 0) {
                $count = (int) ($number / $numeric[$i]);
                if ($count >= 10) {
                    $str .= $this->convert($count).' '.$unit[$i].' ';
                } elseif ($count > 0 && $count < 10) {
                    $str .= $base[$count].' '.$unit[$i].' ';
                }
                $number -= $numeric[$i] * $count;
                $i++;
            }
            $str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
            $str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
            $str = preg_replace('/\s{2,}/', ' ', trim($str));
        }

        return $str;
    }
}
