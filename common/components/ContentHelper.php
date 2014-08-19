<?php
class ContentHelper extends CComponent
{

    public static function prepareStr($str) {
      return htmlentities(strip_tags($str), ENT_QUOTES, 'UTF-8', false);
    }

    public static function cutString($string, $length) {
        if(mb_strlen($string)) {
            $sCutStr = '';
            $aWords = explode(' ',$string);
            $count = 1;
            foreach($aWords as $word) {
                if(mb_strlen($sCutStr.' '.$word) <= $length) {
                    if($count === 1) $sCutStr = $word;
                    else $sCutStr .= ' '.$word;
                    $count++;
                } else {
                    break;
                }
            }
            return $sCutStr;
        } else {
            return $string;
        }
    }

    //cut string per whole words
    public static function cutStringEx($string, $length) {
        if ($length <= 2 || !mb_strlen($string, 'UTF-8')) 
            return $string;
        else {
            $sCutStr = '';
            $aWords = explode(' ',$string);
            $count = 1;
            foreach($aWords as $word) {
                if (mb_strlen($word, 'UTF-8') > $length)   //if word length larger then 2-nd param -
                    $word = mb_substr($word, 0, $length - 2, 'UTF-8');  //cut this word
                if(mb_strlen($sCutStr.' '.$word, 'UTF-8') <= $length) {
                    if($count === 1) 
                        $sCutStr = $word;
                    else 
                        $sCutStr .= ' '.$word;
                    $count++;
                } else {
                    break;
                }
            }
            return $sCutStr;
        } 
    }
    
}  
?>
