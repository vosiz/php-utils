<?php

namespace Vosiz\Utils;

class TimeFormat {

    const TIMESTAMP = "Y-m-d H:i:s";
    const MAX_MICRO_DIGITS = 6;

    /**
     * Creates timestamp string
     * @param string $format Date format
     * @param int $micro Microtime digits (limit = 6, dont use = 0)
     * @return string Formatted timestamp
     */
    public static function Create(string $format = "Y-m-d H:i:s", int $micro = self::MAX_MICRO_DIGITS): string
    {
        if ($micro > self::MAX_MICRO_DIGITS) {
            $micro = self::MAX_MICRO_DIGITS;
        }
    
        $microtime = microtime(true);
        $seconds = floor($microtime);
        $fraction = (int)(($microtime - $seconds) * pow(10, $micro));
        $datetime = date($format, (int)$seconds);

        if ($micro > 0) {
            $micro_fmt = "%0{$micro}d";
            $micro_part = '.' . sprintf($micro_fmt, $fraction);
            $datetime .= $micro_part;
        }
    
        return $datetime;
    }

    /**
     * Creates standart timestamp
     * @return string Timestamp
     */
    public static function TimeStamp() {

        return self::Create(self::TIMESTAMP, 0);
    }

    /**
     * Alias for Create
     */
    public static function Now() {  return self::Create();  }

}