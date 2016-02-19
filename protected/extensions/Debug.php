<?php

class Debug
{

    /**
     * Export dump
     * @param mixed $var
     * @param boolean $isDie
     */
    static public function dump($var, $isDie = true)
    {
        echo('<pre>');
        print_r($var);
        echo('</pre>');

        if ($isDie === true) {
            die();
        }
    }

}
