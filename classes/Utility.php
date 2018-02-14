<?php

class Utility
{
    function arabicDate($time)
    {
        $months = ["Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر"];
        $days = ["Sat" => "السبت", "Sun" => "الأحد", "Mon" => "الإثنين", "Tue" => "الثلاثاء", "Wed" => "الأربعاء", "Thu" => "الخميس", "Fri" => "الجمعة"];
        $am_pm = ['AM' => 'صباحاً', 'PM' => 'مساءً'];
        
        $day = $days[date('D', $time)];
        $month = $months[date('M', $time)];
        $am_pm = $am_pm[date('A', $time)];
        $date = $day . ' ' . date('d', $time) . ' - ' . $month . ' - ' . date('Y', $time) . '   ' . date('h:i', $time) . ' ' . $am_pm;
        $numbers_ar = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
        $numbers_en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        return str_replace($numbers_en, $numbers_ar, $date);
    }
    
    public static function Objectify($array) {
        $object = new stdClass();
        foreach ($array as $key => $value)
        {
            $object->$key = $value;
        }
        return $object;
    }

    public static function pingGoogle() {
        $sitemap = 'www.google.com/webmasters/tools/ping?sitemap=gadgetoverflow.ga/sitemap';
        $data = file_get_contents("https://www.google.com/webmasters/tools/ping?sitemap={$sitemap}");
        return ( strpos($data,"Sitemap Notification Received") !== false ) ? TRUE : FALSE;
    }
    
    // public static function time2str($stamp) {
    //     return  date('d/m/Y', $stamp);
    // }
    
    public static function time2str($ts) {
        if(!ctype_digit($ts)) {
            $ts = strtotime($ts);
        }
        $diff = time() - $ts;
        if($diff == 0) {
            return 'now';
        } elseif($diff > 0) {
            $day_diff = floor($diff / 86400);
            if($day_diff == 0) {
                if($diff < 60) return 'just now';
                if($diff < 120) return '1 minute ago';
                if($diff < 3600) return floor($diff / 60) . ' minutes ago';
                if($diff < 7200) return '1 hour ago';
                if($diff < 86400) return floor($diff / 3600) . ' hours ago';
            }
            if($day_diff == 1) { return 'Yesterday'; }
            if($day_diff < 7) { return $day_diff . ' days ago'; }
            if($day_diff < 31) { return ceil($day_diff / 7) . ' weeks ago'; }
            if($day_diff < 60) { return 'last month'; }
            return date('F Y', $ts);
        } else {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if($day_diff == 0) {
                if($diff < 120) { return 'in a minute'; }
                if($diff < 3600) { return 'in ' . floor($diff / 60) . ' minutes'; }
                if($diff < 7200) { return 'in an hour'; }
                if($diff < 86400) { return 'in ' . floor($diff / 3600) . ' hours'; }
            }
            if($day_diff == 1) { return 'Tomorrow'; }
            if($day_diff < 4) { return date('l', $ts); }
            if($day_diff < 7 + (7 - date('w'))) { return 'next week'; }
            if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' weeks'; }
            if(date('n', $ts) == date('n') + 1) { return 'next month'; }
            return date('F Y', $ts);
        }
    }
}


?>