<?php

class NetworksController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Action Index
     */
    public function actionIndex($networkId = 0)
    {
        $uploadForm = null;
        $authorizeUrl = null;
        $myNetworksIdis = [];
        $site = [];
        $referrals = [];


        if ($networkId > 0) {
            $myNetworksIdis = UserSiteInstruments::model()->getIdsByUserGuid(Yii::app()->user->guid);
            $network = UserInstruments::model()->findByPk($networkId);
            $site = UserInstrumentsData::model()->getSiteCounters(Yii::app()->user->guid, $networkId);
            $referrals = UserReferralData::model()->getReferralCounters(Yii::app()->user->guid, $networkId);

            Cookie::set('user' . Yii::app()->user->id . '/profile/networks/show', $networkId);

            if (preg_match('/^Driver/', $network->driver)) {
                eval('$driver = new ' . $network->driver . '();');

                if (method_exists($driver, 'fileUploadForm')) {
                    $uploadForm = $driver->fileUploadForm($this, ['//profile/networks/uploadFile', 'id' => $networkId]);
                }
                if (method_exists($driver, 'authorizeUrl')) {
                    $authorizeUrl = $driver->authorizeUrl();
                }
            }
        } else {
            if (Cookie::get('user' . Yii::app()->user->id . '/profile/networks/show') > 0) {
                $networkId = Cookie::get('user' . Yii::app()->user->id . '/profile/networks/show');
            } else {
                $criteria = new CDbCriteria();
                $criteria->order = 'title asc';
                $criteria->limit = 1;

                $network = UserInstruments::model()->find($criteria);
                if (isset($network->id)) {
                    $networkId = $network->id;
                }
            }

            if ($networkId > 0) {
                $this->redirect(['//profile/networks/show', 'id' => $networkId]);
            }
        }

        $this->render('index', [
            'uploadForm' => $uploadForm,
            'authorizeUrl' => $authorizeUrl,
            'myNetworksIdis' => $myNetworksIdis,
            'network' => $network,
            'site' => $site,
            'referrals' => $referrals,
        ]);
    }

    /**
     * Action Show
     */
    public function actionShow()
    {
        $networkId = Yii::app()->request->getQuery('id');
        return $this->actionIndex($networkId);
    }

    public function actionUploadFile()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $networkId = Yii::app()->request->getQuery('id');

                if ($networkId > 0) {
                    $network = UserInstruments::model()->findByPk($networkId);

                    if (preg_match('/^Driver/', $network->driver)) {
                        eval('$driver = new ' . $network->driver . '();');

                        if (method_exists($driver, 'fileParser')) {
                            $ret = $driver->fileParser($networkId, $_FILES['file']);

                            $data['status'] = true;
                            $data['ret'] = $ret;
                        }
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionGetCompanySites()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $networkId = Yii::app()->request->getParam('id');
                $dateFrom = Yii::app()->request->getParam('from');
                $dateTo = Yii::app()->request->getParam('to');

                if ($guid && $networkId > 0) {
                    $res = UserInstrumentsData::model()->getSiteCountersByAjax($guid, $networkId, $dateFrom, $dateTo);

                    if ($res) {
                        $data = [
                            'status' => true,
                            'json' => $res,
                        ];
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionGetNetworkReferrals()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $networkId = Yii::app()->request->getParam('id');
                $dateFrom = Yii::app()->request->getParam('from');
                $dateTo = Yii::app()->request->getParam('to');

                if ($networkId > 0) {
                    $res = UserReferralData::model()->getReferralCountersByAjax($guid, $networkId, $dateFrom, $dateTo);

                    if ($res) {
                        $data = [
                            'status' => true,
                            'json' => $res,
                        ];
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

}
