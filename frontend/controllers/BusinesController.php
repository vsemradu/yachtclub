<?php namespace frontend\controllers;

use Yii;
use common\models\ReviewReply;
use common\models\Busines;
use common\models\BusinessImage;
use common\models\BusinessPin;
use common\models\Image;
use common\models\UserPin;
use common\models\PinField;
use common\models\Reviews;
use common\models\User;
use common\models\ReviewsSearch;
use common\models\BusinessHappyHour;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * BusinesController implements the CRUD actions for Busines model.
 */
class BusinesController extends Controller
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
                        'actions' => ['view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['ajax-claim', 'ajax-delete-photo', 'ajax-delete-fon-photo', 'type', 'type-step-two', 'type-step-three', 'update', 'delete', 'ajax-happy-hours', 'ajax-delete-happy-hours'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAjaxDeleteHappyHours()
    {

        $happy_hour_id = Yii::$app->request->get('happy_hour_id');
        $business_id = Yii::$app->request->get('business_id');


        $model = Busines::find()->where(['id' => $business_id, 'user_id' => \Yii::$app->user->id])->one();
        if (!empty($model->id)) {
            $businessHappyHour = BusinessHappyHour::find()->where(['business_id' => $business_id, 'id' => $happy_hour_id])->one();
            if (!empty($businessHappyHour->id)) {
                $businessHappyHour->delete();
            }
        }
    }

    public function actionAjaxHappyHours()
    {

        $model = new BusinessHappyHour();

        return $this->renderAjax('_ajax_happy_hour', [
                'model' => $model,
                'remove' => true,
        ]);
    }

    public function actionAjaxClaim()
    {
        $business_id = Yii::$app->request->get('business_id');

        if (!empty($business_id)) {

            $business = $this->findModel($business_id);
            $business->owner = Busines::OWN_TRUE;
            $business->user_id = \Yii::$app->user->id;
            if(!$business->save()){
                
                   Yii::error('Error save AjaxClaim file BusinesController');
            }
        }
    }

    public function actionAjaxDeletePhoto()
    {
        $business_id = Yii::$app->request->get('business_id');
        $business_photo_id = Yii::$app->request->get('business_photo_id');
        if (!empty($business_id) && !empty($business_photo_id)) {
            $business = $this->findModel($business_id);
            if (!empty($business->id) && $business->user_id == \Yii::$app->user->id) {
                $businessImage = BusinessImage::findOne($business_photo_id);
                if (!empty($businessImage->image_id)) {
                    Image::deleteImage($businessImage->image_id);
                }
                $businessImage->delete();
            }
        }
    }

    public function actionAjaxDeleteFonPhoto()
    {

        $business_id = Yii::$app->request->get('business_id');
        $photo_id = Yii::$app->request->get('photo_id');

        if (!empty($business_id) && !empty($photo_id)) {
            Image::deleteImage($photo_id);
            $business = $this->findModel($business_id);
            if (!empty($business->id)) {
                $business->image_id = 0;
                $business->save();
            }
        }
    }

    /**
     * Lists all Busines models.
     * @return mixed
     */
    public function actionType()
    {

        $type_id = Yii::$app->request->get('type_id');
        $type_text = Yii::$app->request->get('type_text');
        $owner = Yii::$app->request->get('owner');

        return $this->render('type', [
                'type_id' => $type_id,
                'type_text' => $type_text,
                'owner' => $owner,
        ]);
    }

    public function actionTypeStepTwo()
    {
        $type_id = Yii::$app->request->post('type_id');
        $type_text = Yii::$app->request->post('type_text');
        $owner = Yii::$app->request->post('owner');
        if (empty($type_id)) {
            return $this->redirect(['type']);
        }
        return $this->render('type-step-two', [
                'type_id' => $type_id,
                'type_text' => $type_text,
                'owner' => $owner,
        ]);
    }

    public function actionTypeStepThree()
    {
        $type_id = Yii::$app->request->post('type_id');
        $type_text = Yii::$app->request->post('type_text');
        $owner = Yii::$app->request->post('owner');
        $private = Yii::$app->request->post('private', Busines::PRIVATE_FALSE);



        if (empty($type_id)) {
            return $this->redirect(['type']);
        }
        $happyHours = [];
        $image = new Image();
        $imageFon = new Image();
        $business = new Busines();
        $businessPin = new BusinessPin();

        if ($business->load(Yii::$app->request->post())) {
            $business->owner = $owner;
            $business->type_text = $type_text;
            $business->type_id = $type_id;
            $business->user_id = \Yii::$app->user->id;
            $business->owner_id = \Yii::$app->user->id;
            $business->private = $private;

            $image->upload_image = UploadedFile::getInstances($image, 'upload_image');
            $imageFon->name = Yii::$app->request->post('Image')['name'];
            $business->date_create = time();


            /* BusinessHappyHour validate */
            if (!empty(Yii::$app->request->post('BusinessHappyHour'))) {
                $happyHours = array();
                foreach (Yii::$app->request->post('BusinessHappyHour') as $businessHappyHour) {


                    $modelHappyHour = new BusinessHappyHour();
                    $modelHappyHour->week = $businessHappyHour['week'];
                    $modelHappyHour->special = $businessHappyHour['special'];
                    $modelHappyHour->validate();


                    if (!empty($modelHappyHour->getErrors())) {
                        $errorsHappyHours[] = $modelHappyHour->getErrors();
                    }


                    $happyHours[] = $modelHappyHour;
                }
                $hapHour = 1;
            }
            /* BusinessHappyHour validate */



            if ($business->save() && empty($errorsHappyHours)) {



                /* BusinessHappyHour save */
                if (!empty(Yii::$app->request->post('BusinessHappyHour'))) {
                    $happyHours = array();
                    foreach (Yii::$app->request->post('BusinessHappyHour') as $businessHappyHour) {
                        $modelHappyHour = new BusinessHappyHour();
                        $modelHappyHour->week = $businessHappyHour['week'];
                        $modelHappyHour->special = $businessHappyHour['special'];
                        $modelHappyHour->business_id = $business->id;
                        $modelHappyHour->save();
                        $happyHours[] = $modelHappyHour;
                    }
                    $hapHour = 1;
                }
                /* BusinessHappyHour save */


                /* Image upload */
                if ($image->upload_image) {
                    foreach ($image->upload_image as $upload_image) {

                        $img = new Image;
                        $businessImage = new BusinessImage;
                        $img->upload_image = $upload_image;
                        if ($img->validate()) {
                            //link() is probably a better solution for such cases
                            $businessImage->image_id = $img->uploads();
                            $businessImage->business_id = $business->id;
                            $businessImage->save();
                        }
                    }
                }
                /* Image upload */




                if (!empty($imageFon->name) && $imageFon->save()) {

                    $business->image_id = $imageFon->id;
                    $business->save();
                }

                if (!empty($business->pin_id)) {
                    $userPin = PinField::find()->where(['name' => $business->pin_id])->one();
                    if (!empty($userPin)) {
                        //link() is probably a better solution for such cases
                        $businessPin->pin_id = $userPin->pin_id;
                        $businessPin->business_id = $business->id;
                        $businessPin->save();
                    }
                }

                \Yii::$app->getSession()->setFlash('business_id', $business->id);
                return $this->redirect(['type']);
            }
        }
        $dataPins = ArrayHelper::map(UserPin::find()->where(['user_id' => \Yii::$app->user->id])->all(), 'id', 'pinField.name');


        if (empty($hapHour)) {
            $happyHours = [];
        }
        return $this->render('type-step-three', [
                'type_id' => $type_id,
                'happyHours' => $happyHours,
                'type_text' => $type_text,
                'owner' => $owner,
                'image' => $image,
                'imageFon' => $imageFon,
                'business' => $business,
                'private' => $private,
                'dataPins' => !empty($dataPins) ? $dataPins : [],
        ]);
    }

    /**
     * Updates an existing Busines model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $business = $this->findModel($id);
        if (empty($business->id) OR $business->user_id != \Yii::$app->user->id) {
            return $this->goHome();
        }
        $happyHours = $business->businessHappyHour;

        $image = new Image();
        $imageFon = new Image();

        $businessPin = new BusinessPin();
        $dataPins = ArrayHelper::map(UserPin::find()->where(['user_id' => \Yii::$app->user->id])->all(), 'id', 'pinField.name');


        //Transaction might be required here.
        if ($business->load(Yii::$app->request->post())) {

            $image->upload_image = UploadedFile::getInstances($image, 'upload_image');
            $imageFon->name = Yii::$app->request->post('Image')['name'];
            /* BusinessHappyHour validate */
            if (!empty(Yii::$app->request->post('BusinessHappyHour'))) {
                $happyHours = array();
                foreach (Yii::$app->request->post('BusinessHappyHour') as $key => $businessHappyHour) {


                    if (is_string($key)) {
                        $modelHappyHour = new BusinessHappyHour();
                    } else {
                        $modelHappyHour = BusinessHappyHour::findOne($key);
                    }
                    $modelHappyHour->week = $businessHappyHour['week'];
                    $modelHappyHour->special = $businessHappyHour['special'];
                    $modelHappyHour->validate();


                    if (!empty($modelHappyHour->getErrors())) {
                        $errorsHappyHours[] = $modelHappyHour->getErrors();
                    }


                    $happyHours[] = $modelHappyHour;
                }
                $hapHour = 1;
            }
            /* BusinessHappyHour validate */


            if ($business->save() && empty($errorsHappyHours)) {


                /* BusinessHappyHour save */
                if (!empty(Yii::$app->request->post('BusinessHappyHour'))) {
                    $happyHours = array();
                    foreach (Yii::$app->request->post('BusinessHappyHour') as $key => $businessHappyHour) {

                        if (is_string($key)) {
                            $modelHappyHour = new BusinessHappyHour();
                        } else {
                            $modelHappyHour = BusinessHappyHour::findOne($key);
                        }

                        $modelHappyHour->week = $businessHappyHour['week'];
                        $modelHappyHour->special = $businessHappyHour['special'];
                        $modelHappyHour->business_id = $business->id;
                        $modelHappyHour->save();
                        $happyHours[] = $modelHappyHour;
                    }
                    $hapHour = 1;
                }
                /* BusinessHappyHour save */



                if ($image->upload_image) {
                    foreach ($image->upload_image as $upload_image) {
                        $img = new Image;
                        $businessImage = new BusinessImage;
                        $img->upload_image = $upload_image;
                        if ($img->validate()) {
                            $businessImage->image_id = $img->uploads();
                            $businessImage->business_id = $business->id;
                            $businessImage->save();
                        }
                    }
                }

                if (!empty($imageFon->name) && $imageFon->save()) {

                    $business->image_id = $imageFon->id;
                }

                if (!empty($business->pin_id)) {
                    $userPin = PinField::find()->where(['name' => $business->pin_id])->one();
                    if (!empty($userPin->pin_id)) {
                        $businessPin->pin_id = $userPin->pin_id;
                        $businessPin->business_id = $business->id;
                        $businessPin->save();
                    }
                }
                $business->save();

                return $this->redirect(['view', 'id' => $business->id]);
            }
        }

        if (empty($hapHour)) {
            $happyHours = $business->businessHappyHour;
            ;
        }
        return $this->render('update', [
                'image' => $image,
                'happyHours' => $happyHours,
                'imageFon' => $imageFon,
                'business' => $business,
                'dataPins' => !empty($dataPins) ? $dataPins : [],
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $image = new Image();
        $reviews = new Reviews();

        $reviewReply = new ReviewReply();
        $reviews->type = Reviews::TYPE_BUSINESS;
        $week_id = Yii::$app->request->get('week_id', BusinessHappyHour::WEEK_MONDAY);


        $reviewReply->type = Reviews::TYPE_BUSINESS;
        $reviewReply->date_create = time();
        if ($reviewReply->load(Yii::$app->request->post()) && $reviewReply->save()) {
            Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review reply sent'));
            return $this->redirect(['view', 'id' => $id]);
        }



        $searchModelReviews = new ReviewsSearch();
        $searchModelReviews->business_id = $id;
        $searchModelReviews->approved = Reviews::APPROVED_TRUE;
        $dataProviderReviews = $searchModelReviews->search(Yii::$app->request->queryParams);
        
        
        if ($reviews->load(Yii::$app->request->post())) {
            $reviews->user_id = Yii::$app->user->id;
            $reviews->business_id = $id;
            $reviews->type = Reviews::TYPE_BUSINESS;
            $reviews->date_create = time();

            if (User::hasBackendAccess()) {
                $reviews->approved = Reviews::APPROVED_TRUE;
            } else {
                $reviews->approved = Reviews::APPROVED_WAITING;
            }
            if ($reviews->validate()) {
                $reviews->save();




                $image->upload_image = UploadedFile::getInstances($image, 'upload_image');
                if ($image->upload_image) {
                    foreach ($image->upload_image as $upload_image) {
                        $img = new Image;
                        $reviewImage = new \common\models\ReviewImage;
                        $img->upload_image = $upload_image;
                        if ($img->validate()) {

                            $reviewImage->image_id = $img->uploads();
                            $reviewImage->review_id = $reviews->id;
                            $reviewImage->save();
                        }
                    }
                }
                if (User::hasBackendAccess()) {
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review is added'));
                } else {
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review is added. Waiting for approved'));
                }
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        $dataProviderBusinessHappyHours = new \yii\data\ActiveDataProvider([
            'query' => BusinessHappyHour::find()->where([
                'business_id' => $model->id,
                'week' => $week_id,
            ])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => \Yii::$app->params['businessHappyHoursPageSize'],
            ],
        ]);

        return $this->render('view', [
                'model' => $model,
                'reviews' => $reviews,
                'image' => $image,
                'dataProviderReviews' => $dataProviderReviews,
                'dataProviderBusinessHappyHours' => $dataProviderBusinessHappyHours,
                'week_id' => $week_id,
        ]);
    }

    /**
     * Deletes an existing Busines model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = Busines::find()->where(['id' => $id, 'user_id' => \Yii::$app->user->id])->one();
        if (!empty($model->id)) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Busines model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Busines the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Busines::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
