<?php

class JsonReturn
{

    /**
     * Return json
     * @param array $data
     */
    static public function view($data)
    {
        header('Content-Type: application/json;');
        echo(CJSON::encode($data));
        Yii::app()->end();
    }

}
