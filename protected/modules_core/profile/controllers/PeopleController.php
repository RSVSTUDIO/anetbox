<?php

class PeopleController extends Controller
{
    const UserFilterFriends = 1;
    const UserFilterBanned = 2;
    
    const PageLimit = 10;
    
    public $filterId = 0;

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
    
    public function init()
    {
        $this->filterId = Yii::app()->request->getQuery('filter');
        parent::init();
    }

    /**
     * Action Index
     */
    public function actionIndex()
    {
        $users = $this->getUsers();
        $this->render('index', ['users' => $users]);
    }
    
    public function actionSearch()
    {
        $data = ['status' => false];
        
        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {                
                $users = $this->getUsers();
                
                if ($users) {
                    $data['status'] = true;
                    $data['users'] = $this->renderPartial('application.modules_core.profile.views.people.user-table', ['users' => $users, 'filterId' => $this->filterId], true);
                }
            }
        }

        JsonReturn::view($data);
    }
    
    /**
     * Get users
     * @return array
     */
    private function getUsers()
    {
        $uid = Yii::app()->user->id;
        $query = Yii::app()->request->getParam('q');
        $page = (int) Yii::app()->request->getParam('page');
        $offset = $page * self::PageLimit;

        $criteria = new CDbCriteria();
        $criteria->order = 't.firstname+0 asc, t.lastname+0 asc';
        $criteria->offset = $offset;
        $criteria->limit = self::PageLimit;
        $criteria = $this->setUsersFilter($criteria, $uid);

        if (!empty($query)) {
            $criteria->with = 'user';
            $criteria->addSearchCondition('t.firstname', $query, true, 'OR');
            $criteria->addSearchCondition('t.lastname', $query, true, 'OR');
            $criteria->addSearchCondition('t.title', $query, true, 'OR');
            $criteria->addSearchCondition('t.about', $query, true, 'OR');
            $criteria->addSearchCondition('user.email', $query, true, 'OR');
        }

        $users = Profile::model()->findAll($criteria);

        if ($users) {
            foreach ($users as &$user) {
                $friend = UserFriend::model()->setUser($uid, $user->user_id)->find();
                if ($friend) {
                    $user->friendStatus = $friend->status();
                }
            }
        }

        return $users;
    }
    
    /**
     * Set filter
     * @param CDbCriteria $criteria
     * @param integer $uid
     * @return \CDbCriteria
     */
    private function setUsersFilter(CDbCriteria $criteria, $uid)
    {
        switch ($this->filterId) {
            case self::UserFilterFriends:
                $criteria = $this->setUsersFilterFriends($criteria, $uid);
                break;
            
            case self::UserFilterBanned:               
                $criteria = $this->setUsersFilterBanned($criteria, $uid);
                break;

            default:
                $criteria = $this->setUsersFilterAll($criteria, $uid);
                break;
        }

        return $criteria;
    }
    
    /**
     * Set filter All
     * @param CDbCriteria $criteria
     * @param integer $uid
     * @return \CDbCriteria
     */
    private function setUsersFilterAll(CDbCriteria $criteria, $uid)
    {
        $excludes = UserBan::model()->bannedIdisByUser($uid);
        $excludes[] = $uid;

        $criteria->having = 't.user_id not in (' . implode(',', $excludes) . ')';

        return $criteria;
    }
    
    /**
     * Set filter Friends
     * @param CDbCriteria $criteria
     * @param integer $uid
     * @return \CDbCriteria
     */
    private function setUsersFilterFriends(CDbCriteria $criteria, $uid)
    {
        $includes = UserFriend::model()->getFriendIncludesWithoutBanIdis($uid);
        if (count($includes) === 0) {
            $includes = [0]; //by default, the non-existent user
        }

        $criteria->having = 't.user_id in (' . implode(',', $includes) . ')';

        return $criteria;
    }
    
    /**
     * Set filter Banned
     * @param CDbCriteria $criteria
     * @param integer $uid
     * @return \CDbCriteria
     */
    private function setUsersFilterBanned(CDbCriteria $criteria, $uid)
    { 
        $includes = UserBan::model()->bannedIdisByUser($uid);
        if(count($includes) === 0){
            $includes = [0]; //by default, the non-existent user
        }
        
        $criteria->having = 't.user_id in (' . implode(',', $includes) . ')';

        return $criteria;
    }

    public function actionBan()
    {
        $data = [
            'status' => false,
            'message' => Yii::t('ProfileModule.base', '<strong>Error:</strong> Failed to ban user!')
        ];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $uid = Yii::app()->user->id;
                $bid = Yii::app()->request->getParam('id');

                if ($uid > 0 && $bid > 0) {
                    $params = [
                        'user_id' => $uid,
                        'banned_id' => $bid,
                    ];

                    $model = UserBan::model()->findByAttributes($params);

                    if (empty($model)) {
                        $model = new UserBan();
                        $model->setAttributes($params);

                        if ($model->save(false)) {
                            $data['status'] = true;
                            $data['message'] = '';
                        }
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionUnban()
    {
        $data = [
            'status' => false,
            'message' => Yii::t('ProfileModule.base', '<strong>Error:</strong> Failed to unban user!')
        ];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $uid = Yii::app()->user->id;
                $bid = Yii::app()->request->getParam('id');

                if ($uid > 0 && $bid > 0) {
                    $params = [
                        'user_id' => $uid,
                        'banned_id' => $bid,
                    ];

                    $model = UserBan::model()->deleteAllByAttributes($params);

                    if ($model) {
                        $data['status'] = true;
                        $data['message'] = '';
                    }
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionFriend()
    {
        $data = [
            'status' => false,
            'message' => Yii::t('ProfileModule.people', '<strong>Error:</strong> Failed to action!'),
            'header' => '',
            'link' => ''
        ];

        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {
                $uid = Yii::app()->user->id;
                $fid = Yii::app()->request->getParam('id');
                $type = Yii::app()->request->getParam('type');

                if ($uid > 0 && $fid > 0) {
                    $model = UserFriend::model()->setUser($uid, $fid)->find();

                    if ($this->filterId == self::UserFilterFriends) {
                        if ($type == UserFriend::actionRemove) {
                            //remove firend
                            $this->friendDelete($model, $data);
                        }
                    } else {
                        if ($type == UserFriend::actionConfirm) {
                            //confirm request
                            if ($model) {
                                $this->friendConfirm($model, $data);
                            }
                        } else if ($type == UserFriend::actionRevoke || $type == UserFriend::actionReject) {
                            //revoke or reject request
                            $this->friendDelete($model, $data);
                        } else if ($type == UserFriend::actionSend) {
                            //send request
                            if ($model) {
                                $this->friendConfirm($model, $data);
                            } else {
                                $model = new UserFriend();
                                $model->user_id = $uid;
                                $model->friend_id = $fid;

                                if ($model->save()) {
                                    $data['status'] = true;
                                    $data['message'] = '';
                                    $data['link'] = $this->renderPartial('application.modules_core.profile.views.people.user-friend-link', ['status' => UserFriend::statusSentRequest, 'filterId' => $this->filterId], true);
                                }
                            }
                        }
                    }
                }
            }
        }
        
        JsonReturn::view($data);
    }

    /**
     * friend delete
     * @param object $model
     * @param array $data
     */
    private function friendDelete($model, &$data)
    {
        if ($model && $model->delete()) {
            $data['status'] = true;
            $data['message'] = '';
            $data['link'] = $this->renderPartial('application.modules_core.profile.views.people.user-friend-link', ['status' => null, 'filterId' => $this->filterId, 'user' => null], true);
        }
    }
    
    /**
     * friend confirm
     * @param object $model
     * @param array $data
     */
    private function friendConfirm($model, &$data)
    {
        if ($model->accept === 'y') {
            $data['status'] = true;
            $data['message'] = '';
            $data['header'] = Yii::t('ProfileModule.people', 'friend');
        } else {
            if ($model->saveAttributes(['accept' => 'y'])) {
                $data['status'] = true;
                $data['message'] = '';
                $data['header'] = Yii::t('ProfileModule.people', 'friend');
            }
        }
    }
    
    public function actionMessage()
    {
        $messageId = 0;
        $fromId = Yii::app()->user->id;
        $toId = Yii::app()->request->getQuery('id');

        // Get message id and user count
        $query = Yii::app()->db->createCommand()
            ->select([
                'm.id',
                '(' .
                    Yii::app()->db->createCommand()
                    ->select('count(umc.user_id)')
                    ->from(UserMessage::model()->tableName() . ' as umc')
                    ->where('umc.message_id = m.id')
                    ->getText()
                . ') as user_count'
            ])
            ->from(Message::model()->tableName() . ' as m')
            ->join(UserMessage::model()->tableName() . ' as um1', 'um1.message_id = m.id')
            ->join(UserMessage::model()->tableName() . ' as um2', 'um2.message_id = m.id')
            ->where('um1.user_id = :from_id AND um2.user_id = :to_id')
            ->orWhere('um1.user_id = :to_id AND um2.user_id = :from_id')
            ->group('m.id')
            ->bindParam(':from_id', $fromId)
            ->bindParam(':to_id', $toId);

        $message = $query->queryRow();

        if ($message && !empty($message['id']) && $message['user_count'] == 2) {
            $messageId = $message['id'];
        } else {
            $userFrom = User::model()->findByPk($fromId);
            $userTo = User::model()->findByPk($toId);

            // create dialogue
            $modelMessage = new Message();
            $modelMessage->title = Yii::t('ProfileModule.people', 'Dialogue {userFrom} with {userTo}', [
                    '{userFrom}' => $userFrom->displayName,
                    '{userTo}' => $userTo->displayName,
            ]);
            $modelMessage->created_by = $modelMessage->updated_by = $fromId;

            if ($modelMessage->save()) {
                //add user from
                $modelUserMessage_from = new UserMessage();
                $modelUserMessage_from->message_id = $modelMessage->id;
                $modelUserMessage_from->user_id = $fromId;
                $modelUserMessage_from->is_originator = 1;
                $modelUserMessage_from->created_by = $modelUserMessage_from->created_by = $fromId;

                //add user to
                $modelUserMessage_to = new UserMessage();
                $modelUserMessage_to->message_id = $modelMessage->id;
                $modelUserMessage_to->user_id = $toId;
                $modelUserMessage_to->is_originator = 0;
                $modelUserMessage_to->created_by = $modelUserMessage_to->created_by = $fromId;

                if ($modelUserMessage_from->save() && $modelUserMessage_to->save()) {
                    $messageId = $modelMessage->id;
                }
            }
        }

        if ($messageId > 0) {
            return Yii::app()->request->redirect(
                    Yii::app()->createUrl('//mail/mail/index', ['id' => $messageId])
            );
        } else {
            return Yii::app()->request->redirect(
                    Yii::app()->createUrl('//mail/mail/index')
            );
        }
    }

}
