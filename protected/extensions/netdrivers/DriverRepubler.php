<?php

class DriverRepubler
{
    /**
     * Get authorize URL
     * @return string
     */
    public function authorizeUrl()
    {
        return '<strong>' . Yii::t('ProfileModule.base', 'Attention! This network still does not work!') . '</strong>';
    }
}
