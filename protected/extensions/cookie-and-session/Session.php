<?php

/**
 * Session Extension
 */
class Session
{

    /**
     * Get session
     * @param string $name
     * @return mixed|null
     */
    static public function get($name)
    {
        if (isset(Yii::app()->session[$name])) {
            return Yii::app()->session->get($name);
        } else {
            return null;
        }
    }

    /**
     * Set session
     * @param string $name
     * @param mixed $value
     */
    static public function set($name, $value)
    {
        Yii::app()->session[$name] = $value;
    }

}
