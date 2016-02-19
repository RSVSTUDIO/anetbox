<?php

class CabinetController extends Controller
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
    public function actionIndex()
    {
        $site = UserInstrumentsData::model()->getSiteCounters(Yii::app()->user->guid);
        $referrals = UserReferralData::model()->getReferralCounters(Yii::app()->user->guid);
        $this->render('index', [
            'site' => $site,
            'referrals' => $referrals
        ]);
    }

    public function actionGetSites()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $dateFrom = Yii::app()->request->getParam('from');
                $dateTo = Yii::app()->request->getParam('to');

                if ($guid) {
                    $res = UserInstrumentsData::model()->getSiteCountersByAjax($guid, 0, $dateFrom, $dateTo);

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

    public function actionGetReferrals()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $dateFrom = Yii::app()->request->getParam('from');
                $dateTo = Yii::app()->request->getParam('to');

                $res = UserReferralData::model()->getReferralCountersByAjax($guid, 0, $dateFrom, $dateTo);

                if ($res) {                        
                    $data = [
                        'status' => true,
                        'json' => $res,
                    ];
                }
            }
        }

        JsonReturn::view($data);
    }

}
