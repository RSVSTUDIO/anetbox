<?php

/**
 * // Cookie Extension
 */
class Cookie
{

    /**
     * Get cookie
     * @param string $name
     * @return mixed|null
     */
    static public function get($name)
    {
        if (isset(Yii::app()->request->cookies[$name])) {
            return Yii::app()->request->cookies[$name]->value;
        } else {
            return null;
        }
    }

    /**
     * Set cookie
     * @param string $name
     * @param mixed $value
     * @param integer $expire Default value (60*60*24*365)
     */
    static public function set($name, $value, $expire = 31536000)
    {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = time() + $expire;
        Yii::app()->request->cookies[$name] = $cookie;
    }

}
