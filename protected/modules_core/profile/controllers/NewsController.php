<?php

class NewsController extends Controller
{
    
    const PageLimit = 10;

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
        $news = $this->getNews();

        $networks = UserInstruments::model()->getInstruments(['id', 'title']);
        $networks = CHtml::listData($networks, 'id', 'title');

        $this->render('index', [
            'news' => $news,
            'networks' => $networks,
            'networkId' => $networkId
        ]);
    }

    /**
     * Action Network
     */
    public function actionNetwork()
    {
        $networkId = Yii::app()->request->getQuery('id');
        return $this->actionIndex($networkId);
    }
    
    public function actionSearch()
    {
        $data = ['status' => false];
        
        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->request->isPostRequest) {                
                $news = $this->getNews();
                
                if ($news) {
                    $data['status'] = true;
                    $data['news'] = $this->renderPartial('application.modules_core.profile.views.news.news-table', ['news' => $news], true);
                }
            }
        }

        JsonReturn::view($data);
    }
    
    /**
     * Get news
     * @return array
     */
    private function getNews()
    {
        $networkId = Yii::app()->request->getQuery('id');
        $page = (int) Yii::app()->request->getParam('page');
        $offset = $page * self::PageLimit;

        $criteria = new CDbCriteria();
        $criteria->offset = $offset;
        $criteria->limit = self::PageLimit;

        if($networkId > 0){
            $criteria->addColumnCondition(['instrument_id' => $networkId]);
        }

        $news = News::model()->findAll($criteria);

        return $news;
    }
    
    /**
     * Add news
     */
    public function actionAdd()
    {
        $data = ['status' => false];

        if (Yii::app()->user->isNewsAdmin()) {            
            if (Yii::app()->request->isAjaxRequest) {
                if (Yii::app()->request->isPostRequest) {
                    $params = Yii::app()->request->getParam('news');
                    $id = Yii::app()->request->getParam('id');

                    if (is_array($params) && isset($params['instrument_id'])) {
                        // add or update news
                        if ($id > 0) {
                            $model = News::model()->findByPk($id);
                        } else {
                            $model = new News();
                        }

                        $model->instrument_id = $params['instrument_id'];
                        $model->title = $params['title'];
                        $model->short_text = $params['short_text'];
                        $model->full_text = $params['full_text'];
                        $model->url = $params['url'];

                        if ($model->validate()) {
                            $model->save();

                            $data = [
                                'status' => true,
                                'url' => Yii::app()->createUrl('//profile/news/network', ['id' => $params['instrument_id']]),
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
    
    /**
     * Edit news
     */
    public function actionEdit()
    {
        $data = ['status' => false];

        if (Yii::app()->user->isNewsAdmin()) {
            if (Yii::app()->request->isAjaxRequest) {
                $id = Yii::app()->request->getQuery('id');

                $news = News::model()->findByPk($id);

                if ($news) {
                    $data = [
                        'status' => true,
                        'id' => $news->id,
                        'instrument_id' => $news->instrument_id,
                        'title' => $news->title,
                        'short_text' => $news->short_text,
                        'full_text' => $news->full_text,
                        'url' => $news->url,
                    ];
                }
            }
        }

        JsonReturn::view($data);
    }

    public function actionShow()
    {
        $data = ['status' => false];

        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getQuery('id');

            $news = News::model()->findByPk($id);

            if ($news) {
                $data = [
                    'status' => true,
                    'title' => $news->uinstrument->title . ': ' . $news->title,
                    'text' => empty($news->full_text) ? $news->short_text : $news->full_text,
                    'url' => (empty($news->url) ? '' : (Yii::t('ProfileModule.base', 'URL') . ': ' . CHtml::link(StringHelper::truncate($news->url, 50), $news->url, ['target' => '_blank'])))
                ];
            }
        }

        JsonReturn::view($data);
    }

    public function actionDelete()
    {
        $data = [
            'status' => false,
            'message' => Yii::t('ProfileModule.base', '<strong>Error:</strong> Failed to delete news!')
        ];
        
        if (Yii::app()->user->isNewsAdmin()) {            
            if (Yii::app()->request->isAjaxRequest) {
                if (Yii::app()->request->isPostRequest) {                
                    $id = Yii::app()->request->getParam('id');

                    if(News::model()->deleteByPk($id)){
                        $data = [
                            'status' => true,
                            'message' => ''
                        ];
                    }
                }
            }
        } 
        
        JsonReturn::view($data);
    }

}
