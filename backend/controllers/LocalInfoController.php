<?php namespace backend\controllers;

use Yii;
use common\models\Busines;
use common\models\Image;
use common\models\LocalInfo;
use common\models\LocalInfoBusines;
use common\models\LocalInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * LocalInfoController implements the CRUD actions for LocalInfo model.
 */
class LocalInfoController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => '\common\models\User::hasBackendAccess'
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionAjaxDeleteFonPhoto()
    {


        $local_id = Yii::$app->request->get('local_id');
        $photo_id = Yii::$app->request->get('photo_id');

        if (!empty($local_id) && !empty($photo_id)) {
            Image::deleteImage($photo_id);
            $model = $this->findModel($local_id);
            if (!empty($model->id)) {
                //TODO: Use MySQL Foreign Key onDelete - SetNull instead.
                $model->image_id = 0;
                $model->save();
            }
        }
    }

    public function actionAjaxBuissiness()
    {
        $ne_lat = Yii::$app->request->get('ne_lat');
        $sw_lat = Yii::$app->request->get('sw_lat');
        $ne_lng = Yii::$app->request->get('ne_lng');
        $sw_lng = Yii::$app->request->get('sw_lng');

        $businesses = Busines::getBusinessesByArea($ne_lat, $sw_lat, $ne_lng, $sw_lng);
        return json_encode($businesses);
    }

    /**
     * Lists all LocalInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocalInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new LocalInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LocalInfo();
        $businesList = ArrayHelper::map(Busines::find()->all(), 'id', 'business_name');



        $image = new Image();





        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $image->upload_image = UploadedFile::getInstance($image, 'upload_image');

            if ($image->upload_image && $image->validate()) {
                if (!empty($model->image_id)) {
                    Image::deleteImage($model->image_id);
                }
                $model->image_id = $image->uploads();
            }
            $model->save();


            if (!empty(Yii::$app->request->post('LocalInfo')['featured_id'])) {
                foreach (Yii::$app->request->post('LocalInfo')['featured_id'] as $featured) {
                    $modelLocalInfoBusines = new LocalInfoBusines;
                    $modelLocalInfoBusines->business_id = $featured;
                    $modelLocalInfoBusines->local_info_id = $model->id;
                    $modelLocalInfoBusines->type = LocalInfoBusines::TYPE_FEATURE;
                    $modelLocalInfoBusines->save();
                }
            }
            if (!empty(Yii::$app->request->post('LocalInfo')['local_id'])) {
                foreach (Yii::$app->request->post('LocalInfo')['local_id'] as $local) {
                    $modelLocalInfoBusines = new LocalInfoBusines;
                    $modelLocalInfoBusines->business_id = $local;
                    $modelLocalInfoBusines->local_info_id = $model->id;
                    $modelLocalInfoBusines->type = LocalInfoBusines::TYPE_LOCAL;
                    $modelLocalInfoBusines->save();
                }
            }
            Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Local page is successfully created.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                    'model' => $model,
                    'businesList' => $businesList,
                    'image' => $image,
            ]);
        }
    }

    /**
     * Updates an existing LocalInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);



        $model->local_id = ArrayHelper::map($model->localInfoBusinesLocal, 'busines.id', 'busines.id');
        $model->featured_id = ArrayHelper::map($model->localInfoBusinesFeature, 'busines.id', 'busines.id');
        $image = new Image();
        $businesList = Busines::getBusinessesByArea($model->area_box_ne_lat, $model->area_box_sw_lat, $model->area_box_ne_lng, $model->area_box_sw_lng);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $image->upload_image = UploadedFile::getInstance($image, 'upload_image');

            if ($image->upload_image && $image->validate()) {
                if (!empty($model->image_id)) {
                    Image::deleteImage($model->image_id);
                }
                $model->image_id = $image->uploads();
            }
            //TODO: Check if model is saved successfully and inform user about error or stop script if not.
            $model->save();


            if (!empty($model->localInfoBusines)) {
                foreach ($model->localInfoBusines as $localInfoBusines) {
                    $localInfoBusines->delete();
                }
            }

            if (!empty(Yii::$app->request->post('LocalInfo')['featured_id'])) {
                foreach (Yii::$app->request->post('LocalInfo')['featured_id'] as $featured) {
                    $modelLocalInfoBusines = new LocalInfoBusines;
                    $modelLocalInfoBusines->business_id = $featured;
                    $modelLocalInfoBusines->local_info_id = $model->id;
                    $modelLocalInfoBusines->type = LocalInfoBusines::TYPE_FEATURE;
                    $modelLocalInfoBusines->save();
                }
            }
            if (!empty(Yii::$app->request->post('LocalInfo')['local_id'])) {
                foreach (Yii::$app->request->post('LocalInfo')['local_id'] as $local) {
                    $modelLocalInfoBusines = new LocalInfoBusines;
                    $modelLocalInfoBusines->business_id = $local;
                    $modelLocalInfoBusines->local_info_id = $model->id;
                    $modelLocalInfoBusines->type = LocalInfoBusines::TYPE_LOCAL;
                    $modelLocalInfoBusines->save();
                }
            }

            Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Local page is successfully edited.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                    'model' => $model,
                    'businesList' => $businesList,
                    'image' => $image,
            ]);
        }
    }

    /**
     * Deletes an existing LocalInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Local page is successfully deleted.'));
        return $this->redirect(['index']);
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
