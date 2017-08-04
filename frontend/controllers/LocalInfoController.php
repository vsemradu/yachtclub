<?php namespace frontend\controllers;

use Yii;
use common\models\LocalInfo;
use common\models\LocalInfoImage;
use common\models\LocalInfoComment;
use common\models\LocalInfoCommentSearch;
use common\models\Image;
use common\models\LocalInfoSearch;
use common\models\Busines;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\UserPin;
use frontend\helpers\ApiHelper;
use common\models\BusinessHappyHour;

/**
 * LocalInfoController implements the CRUD actions for LocalInfo model.
 */
class LocalInfoController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'view-entry', 'view-weather-tides', 'view-nautic-navigation', 'view-business-services', 'view-local-life'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['ajax-delete-localinfo-comment', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAjaxDeleteLocalinfoComment($id)
    {

        if (Yii::$app->request->isAjax && !empty(\Yii::$app->user->id)) {

            $model = LocalInfoComment::findOne($id);

            if (empty($model)) {
                return 'null';
            }

            if (Yii::$app->user->id != $model->user_id) {
                return 'null';
            }
            $model->delete();
            return 'true';
        }
    }

    /**
     * Displays a single LocalInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {


        $model = $this->findModel($id);

        if (empty($model->id)) {
            return $this->goHome();
        }
        $image = new Image;


        $image->upload_image = UploadedFile::getInstances($image, 'upload_image');

        if ($image->upload_image) {
            foreach ($image->upload_image as $upload_image) {

                $img = new Image;
                $localInfoImage = new LocalInfoImage;
                $img->upload_image = $upload_image;
                if ($img->validate()) {
                    $localInfoImage->image_id = $img->uploads();
                    $localInfoImage->local_info_id = $model->id;
                    $localInfoImage->save();
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('success_message', 'Photo is added'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('view', [
                'model' => $model,
                'image' => $image,
        ]);
    }

    public function actionViewEntry($id)
    {
        if (empty($id)) {
            return $this->goHome();
        }
        $model = $this->findModel($id);

        if (empty($model->id)) {
            return $this->goHome();
        }
        $localInfoComment = new LocalInfoComment();

        if (!empty(\Yii::$app->user->id)) {
            if ($localInfoComment->load(Yii::$app->request->post())) {
                $localInfoComment->user_id = \Yii::$app->user->id;
                $localInfoComment->local_info_id = $model->id;
                $localInfoComment->date_create = time();
                $localInfoComment->type = LocalInfoComment::TYPE_COMMENT;
                if ($localInfoComment->validate()) {
                    $localInfoComment->save();
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Comment is added'));
                    return $this->redirect(['view-entry', 'id' => $model->id]);
                }
            }
        }


        $dataProviderLocalInfoComment = new ActiveDataProvider([
            'query' => LocalInfoComment::find()
                ->andwhere([
                    'local_info_id' => $model->id,
                ])
                ->andwhere([
                    'type' => LocalInfoComment::TYPE_COMMENT,
                ])
                ->orderBy('date_create DESC'),
            'pagination' => [
                'pageSize' => \Yii::$app->params['localLifeCommentPageSize'],
            ],
        ]);


        $businesList = Busines::getBusinessesByAreaType($model->area_box_ne_lat, $model->area_box_sw_lat, $model->area_box_ne_lng, $model->area_box_sw_lng, Busines::TYPE_PORT);


        return $this->render('view_entry', [
                'model' => $model,
                'localInfoComment' => $localInfoComment,
                'dataProviderLocalInfoComment' => $dataProviderLocalInfoComment,
                'businesList' => $businesList,
        ]);
    }

    public function actionViewWeatherTides($id)
    {
        if (empty($id)) {
            return $this->goHome();
        }
        $model = $this->findModel($id);

        if (empty($model->id)) {
            return $this->goHome();
        }



        return $this->render('view_weather_tides', [
                'model' => $model,
        ]);
    }

    public function actionViewNauticNavigation($id)
    {
        if (empty($id)) {
            return $this->goHome();
        }
        $model = $this->findModel($id);


        $type_id = Yii::$app->request->get('type_id', UserPin::TYPE_ANCHORAGES);
        if (empty($model->id)) {
            return $this->goHome();
        }

        $pinsList = UserPin::getPinsByAreaType($model->area_box_ne_lat, $model->area_box_sw_lat, $model->area_box_ne_lng, $model->area_box_sw_lng, $type_id);
        $pins = ApiHelper::generatePins($pinsList);
        

        return $this->render('view_nautic_navigation', [
                'model' => $model,
                'type_id' => $type_id,
                'pinsList' => $pinsList,
                'pins' => !empty($pins) ? json_encode($pins) : '',
        ]);
    }

    public function actionViewBusinessServices($id)
    {
        if (empty($id)) {
            return $this->goHome();
        }
        $model = $this->findModel($id);


        $type_id = Yii::$app->request->get('type_id', Busines::TYPE_MARINA);
        if (empty($model->id)) {
            return $this->goHome();
        }


        $businesList = Busines::getBusinessesByAreaType($model->area_box_ne_lat, $model->area_box_sw_lat, $model->area_box_ne_lng, $model->area_box_sw_lng, $type_id, 'list');


        $business = ApiHelper::generateBusiness($businesList);
        return $this->render('view_business_services', [
                'model' => $model,
                'type_id' => $type_id,
                'businesList' => $businesList,
                'business' => !empty($business) ? json_encode($business) : '',
        ]);
    }

    public function actionViewLocalLife($id)
    {
        if (empty($id)) {
            return $this->goHome();
        }
        $model = $this->findModel($id);


        if (empty($model->id)) {
            return $this->goHome();
        }
        $week_id = Yii::$app->request->get('week_id', BusinessHappyHour::WEEK_MONDAY);
        $localInfoComment = new LocalInfoComment();

        if (!empty(\Yii::$app->user->id)) {
            if ($localInfoComment->load(Yii::$app->request->post())) {
                $localInfoComment->user_id = \Yii::$app->user->id;
                $localInfoComment->local_info_id = $model->id;
                $localInfoComment->date_create = time();
                $localInfoComment->type = LocalInfoComment::TYPE_TIP_TRICK;
                if ($localInfoComment->validate()) {
                    $localInfoComment->save();
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Tip or Trick is added'));
                    return $this->redirect(['view-local-life', 'id' => $model->id]);
                }
            }
        }

        $businessHappyHours = $model->happyHourByWeek($week_id)->all();
        $dataProviderLocalInfoComment = new ActiveDataProvider([
            'query' => LocalInfoComment::find()
                ->andwhere([
                    'local_info_id' => $model->id,
                ])
                ->andwhere([
                    'type' => LocalInfoComment::TYPE_TIP_TRICK,
                ])
                ->orderBy('date_create DESC'),
            'pagination' => [
                'pageSize' => \Yii::$app->params['localLifePageSize'],
            ],
        ]);
        return $this->render('view_local_life', [
                'model' => $model,
                'businessHappyHours' => $businessHappyHours,
                'week_id' => $week_id,
                'localInfoComment' => $localInfoComment,
                'dataProviderLocalInfoComment' => $dataProviderLocalInfoComment,
        ]);
    }

    /**
     * Finds the LocalInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LocalInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LocalInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
