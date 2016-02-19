<?php

/**
 * Language switcher
 */
class LangController extends Controller
{
    public function actionIndex()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $lang = Yii::app()->request->getParam('lang');

                if (isset(Yii::app()->params['availableLanguages'][$lang])) {
                    Cookie::set('language', $lang);
                    $data['status'] = true;
                }
            }
        }

        JsonReturn::view($data);
    }

}
