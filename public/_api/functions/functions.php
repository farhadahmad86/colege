<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 17-Jan-19
 * Time: 4:56 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function format($decimal, $precision = 2) {
    return number_format( (float) $decimal, $precision, '.', ',');
}

function formatAsDecimal($decimal, $precision = 2) {
    return number_format( (float) $decimal, $precision, '.', '');
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789ABCDEFGHIJKLMNOPQRSTUWXYZ`~!@#$%^&*()_+=-{}][:\"|\';<>?/.,";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 13; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

function uniqueHashCode($length = 13) {
    // unique id gives 13 chars, but you could adjust it to your needs.
    $bytes = mt_rand();
    if (function_exists("random_bytes")) {
        try {
            $bytes = random_bytes(ceil($length / 2));
        } catch (Exception $e) {
            $bytes = mt_rand();
        }
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    }
    return substr(bin2hex($bytes), 0, $length);
}

function randomNumbers($length = 11) {
    $alphabet = "0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

function generateUPCWithCheckDigit($randomNumber, $companyCode = null) {

    $oddTotal = 0;
    $evenTotal = 0;

    if ($companyCode != null && $companyCode != "") {
        $randomNumber = $companyCode . $randomNumber;
    }

    for ($i = 0; $i < strlen($randomNumber); $i++) {
        if ((($i + 1) % 2) == 0) {
            $evenTotal += $randomNumber[$i];
        } else {
            $oddTotal += $randomNumber[$i];
        }
    }

    $sum = (3 * $oddTotal) + $evenTotal;

    $checkDigit = $sum % 10;

    return $randomNumber . (($checkDigit > 0) ? 10 - $checkDigit : $checkDigit);
}

function makHash($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function checkHash($password, $hash) {
    $match = password_verify($password, $hash);
    return ($match == 1) ? 1 : 0;
}

function getClientIp() {
    $ipAddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipAddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipAddress = 'UNKNOWN';
    return $ipAddress;
}

function notNull($value, $defaultValue = "") {
    return is_null($value) ? $defaultValue : $value;
}

function notEmpty($value, $defaultValue = "") {
    return ($value == "") ? $defaultValue : $value;
}

function notNullOrEmpty($value, $defaultValue = "") {
    return (is_null($value) || $value == "") ? $defaultValue : $value;
}

function generateEmployeeCode($id, $name) {
    $code = 'AAAA';
    $l = explode(" ", $name);
    $c = count($l);
    if ($c == 1) {
        $code = $name[0] . $name[0] . $name[0] . $name[0];
    } elseif ($c == 2) {
        $code = $l[0][0] . $l[1][0] . $l[1][0] . $l[1][0];
    } elseif ($c == 3) {
        $code = $l[0][0] . $l[1][0] . $l[2][0] . $l[2][0];
    } elseif ($c == 4) {
        $code = $l[0][0] . $l[1][0] . $l[2][0] . $l[3][0];
    }
    $code .= "-";
    $code .= str_pad($id, 4, '0', STR_PAD_LEFT);
    return strtoupper($code);
}

function trim_all( $str , $what = NULL , $with = ' ' ) {
    if( $what === NULL ) {
        //  Character      Decimal      Use
        //  "\0"            0           Null Character
        //  "\t"            9           Tab
        //  "\n"           10           New line
        //  "\x0B"         11           Vertical Tab
        //  "\r"           13           New Line in Mac
        //  " "            32           Space

        $what   = "\\x00-\\x20";    //all white-spaces and control chars
    }

    return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}

function replaceFirst($from, $to, $string) {
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $string, 1);
}

function replaceLast($from, $to, $string) {
//    $str = $string;
//    if(($pos = strrpos($str, $from)) !== false) {
//        $search_length  = strlen($str);
//        $str = substr_replace($str ,$to ,$pos ,$search_length);
//    }
//    return $str;

    $pos = strrpos($string, $from);

    if($pos !== false)
    {
        $string = substr_replace($string, $to, $pos, strlen($from));
    }

    return $string;
}

function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) . "" === $startString . "");
}

function endsWith($string, $endString) {
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function getDateOrNull($date) {
    if ($date == "" || $date == "null" || $date == "NULL") {
        return "NULL";
    }
    return "'$date'";
}

function isLastDayOfMonth($dayEndDate) {

    $lastDay = false;

    try {

        $currentDate = new DateTime($dayEndDate);
        $currentDate->modify('last day of this month');
        $currentDate = $currentDate->format('Y-m-d');

        if ($currentDate === $dayEndDate) {
            $lastDay = true;
        }

    } catch (Exception $e) {}

    return $lastDay;
}

function isFirstDayOfMonth($dayEndDate) {

    $firstDay = false;

    try {

        $currentDate = new DateTime($dayEndDate);
        $currentDate->modify('first day of this month');
        $currentDate = $currentDate->format('Y-m-d');

        if ($currentDate === $dayEndDate) {
            $firstDay = true;
        }

    } catch (Exception $e) {}

    return $firstDay;
}

function getFirstDayOfMonth($dayEndDate) {

    try {

        $currentDate = new DateTime($dayEndDate);
        $currentDate->modify('first day of this month');
        $currentDate = $currentDate->format('Y-m-d');

        return $currentDate;

    } catch (Exception $e) {}

    return null;
}

function getLastDayOfMonth($dayEndDate) {

    try {

        $currentDate = new DateTime($dayEndDate);
        $currentDate->modify('last day of this month');
        $currentDate = $currentDate->format('Y-m-d');

        return $currentDate;

    } catch (Exception $e) {}

    return null;
}

function number_to_word($num) {

    $minus = false;

    if ($num < 0) {
        $num = abs($num);
        $minus = true;
    }

    $numbers = explode('.', $num);
    $num = $numbers[0];

    if( ctype_digit( $num ) ) {

        $words  = array( );

        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );

        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');

        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');

        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');

        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );

        foreach( $num_levels as $num_part ) {

            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' /*. ( $hundreds == 1 ? '' : 's' )*/ . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';

            if( $tens < 20 ) {
                $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = ( int ) ( $tens / 10 );
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = ( int ) ( $num_part % 10 );
                $singles = ' ' . $list1[$singles] . ' ';
            }

            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        }

//        $commas = count( $words );
//
//        if( $commas > 1 ) {
//            $commas = $commas - 1;
//        }

        $words = implode( ', ' , $words );

        //Some Finishing Touch
        //Replacing multiples of spaces with one space
        $words  = trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );
//        if( $commas ) {
//            $words = replaceLast( ', ' , ' and' , $words );
//        }

        if ($minus) {
            $words = "Negative " . $words;
        }

        $afterDot = "Only";
        if (isset($numbers[1])) {
            $num2 = $numbers[1];
            if ($num2 > 0)
                $afterDot = " (dot) " . dot_to_word($num2) . " Paisa(s) Only";
        }

        return $words . " Rupees " . $afterDot;
    }

    return '';
}

function dot_to_word($num) {

    $numbers = explode('.', $num);
    $num = $numbers[0];

    if( ctype_digit( $num ) ) {

        $words  = array( );

        $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );

        $list1  = array('','one','two','three','four','five','six','seven',
            'eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen');

        $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',
            'seventy','eighty','ninety','hundred');

        $list3  = array('','thousand','million','billion','trillion',
            'quadrillion','quintillion','sextillion','septillion',
            'octillion','nonillion','decillion','undecillion',
            'duodecillion','tredecillion','quattuordecillion',
            'quindecillion','sexdecillion','septendecillion',
            'octodecillion','novemdecillion','vigintillion');

        $num_length = strlen( $num );
        $levels = ( int ) ( ( $num_length + 2 ) / 3 );
        $max_length = $levels * 3;
        $num    = substr( '00'.$num , -$max_length );
        $num_levels = str_split( $num , 3 );

        foreach( $num_levels as $num_part ) {

            $levels--;
            $hundreds   = ( int ) ( $num_part / 100 );
            $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' /*. ( $hundreds == 1 ? '' : 's' )*/ . ' ' : '' );
            $tens       = ( int ) ( $num_part % 100 );
            $singles    = '';

            if( $tens < 20 ) {
                $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = ( int ) ( $tens / 10 );
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = ( int ) ( $num_part % 10 );
                $singles = ' ' . $list1[$singles] . ' ';
            }

            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        }

        $words = implode( ', ' , $words );

        $words  = trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );

        return $words;
    }

    return '';
}
