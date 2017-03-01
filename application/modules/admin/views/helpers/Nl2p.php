<?php
 
class Zend_View_Helper_nl2p extends Zend_View_Helper_Abstract
{
    public function nl2p($string, $class='') { 
        $class_attr = ($class!='') ? ' class="'.$class.'"' : ''; 
        return 
            '<p'.$class_attr.'>' 
            .preg_replace('#(<br\s*?/?>\s*?){2,}#', '</p>'."\n".'<p'.$class_attr.'>', nl2br($string, true)) 
            .'</p>'; 
    } 
}