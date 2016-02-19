<?php

class AreasController extends Controller
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
     * @param integer $siteId
     */
    public function actionIndex($siteId = 0)
    {
        $instrumentsDropDown = [];
        $siteInstruments = [];
        $networkCTR = [];
        $networkData = [];

        if ($siteId > 0) {
            $site = UserSite::model()->find('user_id=:user_id and id=:id', [
                ':user_id' => Yii::app()->user->guid,
                ':id' => $siteId
            ]);

            $Idis = UserSiteInstruments::model()->getIdisBySiteId($siteId);
            $instrumentsDropDown = CHtml::listData(UserInstruments::model()->getInstruments(['id', 'title'], $Idis), 'id', 'title');
            $siteInstruments = UserInstruments::model()->getInstruments('*', [UserInstruments::AnetBoxId], $Idis);
            $siteInstruments = UserInstruments::model()->createType($siteInstruments);
            $networkCTR = UserInstrumentsData::model()->getNetworkCTR(Yii::app()->user->guid, $siteId);
            $networkData = $this->networkData(key($instrumentsDropDown));

            Cookie::set('user' . Yii::app()->user->id . '/profile/areas/show', $siteId);
        } else {
            if (Cookie::get('user' . Yii::app()->user->id . '/profile/areas/show') > 0) {
                $siteId = Cookie::get('user' . Yii::app()->user->id . '/profile/areas/show');
            } else {
                $site = UserSite::model()->find('user_id=:user_id', [':user_id' => Yii::app()->user->guid]);
                if (isset($site->id)) {
                    $siteId = $site->id;
                }
            }

            if ($siteId > 0) {
                $this->redirect(['//profile/areas/show', 'id' => $siteId]);
            }
        }

        $this->render('index', [
            'site' => $site,
            'instrumentsDropDown' => $instrumentsDropDown,
            'siteInstruments' => $siteInstruments,
            'networkCTR' => $networkCTR,
            'networkData' => $networkData
        ]);
    }

    /**
     * Action show site
     */
    public function actionShow()
    {
        $siteId = Yii::app()->request->getQuery('id');
        return $this->actionIndex($siteId);
    }

    /**
     * Action add
     */
    public function actionAdd()
    {
        $this->render('add');
    }

    public function actionDelSite()
    {
        $data = [
            'status' => false,
            'message' => Yii::t('ProfileModule.base', '<strong>Error:</strong> Failed to delete site!')
        ];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $id = (int) Yii::app()->request->getParam('id');

                if ($id > 0) {
                    if (UserSite::model()->deleteAllByAttributes(['id' => $id, 'user_id' => $guid])) {
                        $data['status'] = true;
                        $data['message'] = '';
                        Cookie::set('user' . Yii::app()->user->id . '/profile/areas/show', 0);
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    /**
     * Add site for user
     */
    public function actionAddSite()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $model = new UserSite();
                $params = Yii::app()->request->getParam('UserSite');

                if (is_array($params)) {
                    $model->title = $params['title'];
                    $model->url = $params['url'];
                    $model->description = $params['description'];
                    $model->setScenario('add');

                    if ($model->validate()) {
                        if ($model->save(false)) {
                            $model = UserSite::model()->findByPk($model->id);

                            $data = [
                                'status' => true,
                                'url' => Yii::app()->createUrl('//profile/areas/show', ['id' => $model->id]),
                                'site' => [
                                    'id' => $model->id,
                                    'title' => $model->title,
                                    'url' => $model->url,
                                    'description' => $model->description,
                                    'active' => $model->active
                                ]
                            ];
                        }
                    } else {
                        $data['errors'] = $model->getErrors();
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    /**
     * Confirm site code
     */
    public function actionConfirm()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $id = Yii::app()->request->getParam('id');

                $model = UserSite::model()->findByAttributes(['id' => $id, 'user_id' => $guid]);

                if (isset($model->id)) {
                    $istruments = UserSite::model()->searchInstruments($model->url, [UserInstruments::AnetBoxId]);

                    if (count($istruments) > 0) {
                        $model->code = $model->generateCode();
                        $model->update();

                        $data['status'] = true;
                        $data['url'] = Yii::app()->createUrl('//profile/areas/show', ['id' => $model->id]);
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    /**
     * Get site code
     */
    public function actionGetCode()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $model = new UserSite();
                $model->id = Yii::app()->request->getParam('id');
                $model->url = Yii::app()->request->getParam('url');

                if ($model->validate()) {
                    $data = [
                        'status' => true,
                        'code' => $model->getScript()
                    ];
                }
            }
        }

        JsonReturn::view($data);
    }

    /**
     * Add network
     */
    public function actionAddNetwork()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $params = Yii::app()->request->getParam('network');
                $guid = Yii::app()->user->guid;

                if (is_array($params) && isset($params['site_id'])) {
                    //check site owner
                    $site = UserSite::model()->findByAttributes([
                        'id' => $params['site_id'],
                        'user_id' => $guid
                    ]);

                    if (isset($site->id)) {
                        // add site instruments
                        $model = UserSiteInstruments::model()->findByAttributes([
                            'site_id' => $params['site_id'],
                            'instrument_id' => $params['instrument_id']
                        ]);

                        if (!$model) {
                            $model = new UserSiteInstruments();
                            $model->site_id = $params['site_id'];
                            $model->instrument_id = $params['instrument_id'];
                        }

                        $model->login = $params['login'];
                        $model->password = $params['password'];
                        $model->api_data = null;

                        if ($model->validate()) {
                            $model->save();
                            
                            //generate google api token
                            $modelInst = UserInstruments::model()->findByPk($model->instrument_id);
                            if (isset($modelInst->driver) && $modelInst->driver === 'DriverGoogleAdSense') {
                                (new DriverGoogleAdSense)->setUsiId($model->id)->geterateToken($model->password);
                            }

                            $data = [
                                'status' => true,
                                'url' => Yii::app()->createUrl('//profile/areas/show', ['id' => $params['site_id']]),
                            ];
                        } else {
                            $data['errors'] = $model->getErrors();
                        }
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionDelNetwork()
    {
        $data = [
            'status' => false,
            'message' => Yii::t('ProfileModule.base', '<strong>Error:</strong> Failed to delete network!')
        ];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $id = (int) Yii::app()->request->getParam('id');
                $site = (int) Yii::app()->request->getParam('site');

                if ($id > 0 && $site > 0) {
                    if (UserSiteInstruments::model()->deleteAllByAttributes(['site_id' => $site, 'instrument_id' => $id])) {
                        $data['status'] = true;
                        $data['message'] = '';
                        $data['url'] = Yii::app()->createUrl('//profile/areas/show', ['id' => $site]);
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionGetCompanyCTR()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $guid = Yii::app()->user->guid;
                $siteId = Yii::app()->request->getParam('id');
                $dateFrom = Yii::app()->request->getParam('from');
                $dateTo = Yii::app()->request->getParam('to');

                if ($guid && $siteId > 0) {
                    $res = UserInstrumentsData::model()->getNetworkCTR($guid, $siteId, $dateFrom, $dateTo);

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

    public function actionGetNetworkData()
    {
        $data = $this->networkData();

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $id = Yii::app()->request->getParam('id');
                $data = $this->networkData($id);
            }
        }

        JsonReturn::view($data);
    }

    /**
     * Get network data
     * @param integer $id
     * @return array
     */
    private function networkData($id = 0)
    {
        $data = [
            'login' => Yii::t('ProfileModule.base', 'Login'),
            'password' => Yii::t('ProfileModule.base', 'Password'),
            'url' => ''
        ];

        if ($id > 0) {
            $network = UserInstruments::model()->findByPk($id);

            if (isset($network->driver) && preg_match('/^Driver/', $network->driver)) {
                eval('$driver = new ' . $network->driver . '();');

                if (method_exists($driver, 'labelNetworkLogin')) {
                    $data['login'] = $driver->labelNetworkLogin();
                }
                if (method_exists($driver, 'labelNetworkPassword')) {
                    $data['password'] = $driver->labelNetworkPassword();
                }
                if (method_exists($driver, 'authorizeUrl')) {
                    $data['url'] = $driver->authorizeUrl();
                }
            }
        }

        return $data;
    }

}
