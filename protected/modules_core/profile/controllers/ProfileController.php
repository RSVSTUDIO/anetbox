<?php

class ProfileController extends Controller
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
        $guid = Yii::app()->user->guid;
        $user = User::model()->findByAttributes(array('guid' => $guid));

        if ($user == null) {
            throw new CHttpException(404, Yii::t('UserModule.behaviors_ProfileControllerBehavior', 'User not found!'));
        }

        $site = UserSite::model()->findAllByAttributes(['user_id' => $guid]);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition('friend_id = :friend_id');
        $criteria->addCondition('accept = :accept');
        $criteria->params = ['friend_id' => $user->id, ':accept' => 'n'];
        
        $excludes = UserBan::model()->bannedIdisByUser($user->id);
        if(!empty($excludes)){
            $criteria->addNotInCondition('user_id', $excludes);
        }
        
        $friendRequest = UserFriend::model()->findAll($criteria);

        $this->render('index', ['user' => $user, 'site' => $site, 'friendRequest' => $friendRequest]);
    }

}
