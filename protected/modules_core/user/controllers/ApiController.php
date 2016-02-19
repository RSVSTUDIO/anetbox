<?php

class ApiController extends Controller
{

    public function actionAdsense()
    {
        $code = Yii::app()->request->getParam('code');

        $this->render('adsense', [
            'code' => $code
        ]);
    }

    public function actionYandexToken()
    {        
        $this->render('yandexToken', []);
    }

    public function actionYandexSession()
    {
        $key1 = 'cookie key "Session_id"';
        $key2 = 'cookie key "sessionid2"';

        $this->render('yandexSession', [
            'sessionKey1' => $key1,
            'sessionKey2' => $key2,
        ]);
    }

    public function actionTeaserNetSession()
    {
        $key = 'cookie key "PHPSESSID"';

        $this->render('teaserNetSession', [
            'sessionKey' => $key,
        ]);
    }

    public function actionActionTeaserSession()
    {
        $key = 'cookie key "PHPSESSID"';

        $this->render('actionTeaserSession', [
            'sessionKey' => $key,
        ]);
    }

    public function actionLitresSession()
    {
        $key = 'cookie key "SID"';

        $this->render('litresSession', [
            'sessionKey' => $key,
        ]);
    }
}

?>
