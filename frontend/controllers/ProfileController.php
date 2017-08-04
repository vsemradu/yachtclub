<?php namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\UploadForm;
use common\models\PinField;
use common\models\PinImage;
use common\models\PinVessel;
use common\models\UserPin;
use common\models\Image;
use common\models\ReviewsSearch;
use yii\web\UploadedFile;
use yii\web\Session;
use frontend\helpers\ApiHelper;
use yii\filters\AccessControl;
use common\models\User;

class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create-pin', 'reviews', 'reviews', 'pins', 'ajax-delete-profile-photo', 'edit'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        return $this->render('index', [
                'userPages' => $user->userPages,
        ]);
    }

    public function actionCreatePin()
    {

        $session = new Session;
        $pinVessel = new PinVessel;
        $session->open();
        $pinField = new PinField;
        $pin = new UserPin;
        $image = new Image;
        $image->scenario = 'pins';
        $pinField->type_id = Yii::$app->request->get('type_id');
        $pin->type = Yii::$app->request->get('type_id');
        $lat = Yii::$app->request->get('lat');
        $lan = Yii::$app->request->get('lan');

        if (empty($lan)) {
            $lan = Yii::$app->request->get('PinModalForm')['lan'];
        }
        if (empty($lat)) {
            $lat = Yii::$app->request->get('PinModalForm')['lat'];
        }

        if (!empty($lat) && !empty($lan)) {
            $session['lat'] = $lat;
            $session['lan'] = $lan;
        } else {
            //Another if is not needed here. Remove it or add explanatory comments if it is needed.
            if (empty($session['lat']) OR empty($session['lan'])) {
                return $this->goHome();
            }
        }

        if (Yii::$app->request->post('save') == 'true') {
            if ($pinField->load(Yii::$app->request->post()) && $pin->load(Yii::$app->request->post())) {


                $pin->lat = $session['lat'];
                $pin->lan = $session['lan'];
                $pin->user_id = Yii::$app->user->id;


                if (User::hasBackendAccess()) {
                    $pin->approved = UserPin::APPROVED_TRUE;
                }else{
                    $pin->approved = UserPin::APPROVED_WAITING;
                    
                }
                //Transaction is probably required here.
                $image->upload_image = UploadedFile::getInstances($image, 'upload_image');
                if ($image->validate() && $pin->save() && $pinField->validate()) {


                    $pinField->pin_id = $pin->id;
                    $pinField->save();

 
                    if ($image->upload_image) {

                        foreach ($image->upload_image as $upload_image) {
                            $img = new Image;
                            $pinImage = new PinImage;
                            $img->upload_image = $upload_image;

                            $pinImage->image_id = $img->uploads();
                            $pinImage->pin_id = $pin->id;
                            $pinImage->save();
                        }
                    }

                    $session['lat'] = '';
                    $session['lan'] = '';

                    $pinVessel->load(Yii::$app->request->post());
                    $pinVessel->pin_id = $pin->id;
                    $pinVessel->save();

                    return $this->redirect(['/pin/view', 'id' => $pin->id]);
                }

                $image->upload_image = '';
            }
        }
        return $this->render('create_pin', [
                'pinField' => $pinField,
                'pin' => $pin,
                'image' => $image,
                'pinVessel' => $pinVessel
        ]);
    }

    public function actionReviews()
    {


        $searchModelReviews = new ReviewsSearch();

        $searchModelReviews->user_id = Yii::$app->user->id;

        $dataProviderReviews = $searchModelReviews->search(Yii::$app->request->queryParams);
        return $this->render('reviews', [
                'dataProviderReviews' => $dataProviderReviews
        ]);
    }

    public function actionPins()
    {

        $modelPins = UserPin::find()->where(['user_id' => Yii::$app->user->id])->all();
        $pinsMap = ApiHelper::generatePins($modelPins);
        $pinsList = ApiHelper::generateListPins($modelPins);
        return $this->render('pins', [
                'pins' => !empty($pinsMap) ? json_encode($pinsMap) : '',
                'pinsList' => $pinsList,
        ]);
    }

    public function actionAjaxDeleteProfilePhoto()
    {
        $user = Yii::$app->user->identity;
        if (!empty($user->userInfo->image_id)) {
            \common\models\Image::deleteImage($user->userInfo->image_id);
        }

        $user->userInfo->image_id = 0;
        //Save should be executed before delete. Otherwise when save() fails image will be already deleted. 404 will occure.
        $user->userInfo->save();
        Yii::$app->session->setFlash('success', Yii::t('success_message', 'Edit profile'));
        return;
    }

    public function actionEdit()
    {
        //$user should be the same as Yii::$app->user
        $user = \common\models\User::findIdentity(Yii::$app->user->id);
        $model = new \common\models\User();
        $modelInfo = new \common\models\UserInfo();
        $modelImage = new \common\models\Image();
        $modelImage->scenario = 'upload_profile';
        $modelInfo->scenario = 'update';
        $model->scenario = 'update';

        /* User photo */
        if (!empty(Yii::$app->request->post('update_photo'))) {
            $modelImage->upload_image = UploadedFile::getInstance($modelImage, 'upload_image');
            if ($modelImage->upload_image && $modelImage->validate()) {
                if (!empty($user->userInfo->image_id)) {
                    \common\models\Image::deleteImage($user->userInfo->image_id);
                }


                $user->userInfo->image_id = $modelImage->uploads();

                //Save should be executed before delete. Otherwise when save() fails image will be already deleted. 404 will occure.
                $user->userInfo->save();
                Yii::$app->session->setFlash('success', Yii::t('success_message', 'Your profile has been successfully edited'));
                return $this->refresh();
            }
        }
        /* User photo */



        /* User email */
        if ($model->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post('update_email'))) {
            if ($model->validate()) {
                $user->email = $model->email;
                $user->updateEmail();
                $user->save();
                Yii::$app->session->setFlash('success', Yii::t('success_message', 'Your email has been successfully edited'));
                return $this->refresh();
            }
        }
        /* User email */



        /* User paswword */
        if ($model->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post('update_password'))) {
            $model->scenario = 'update_password';
            if ($model->validate()) {
                if (!$user->validatePassword($model->old_password)) {
                    $model->addError('old_password', Yii::t('error', 'Old password wrong'));
                }
                if (empty($model->getErrors())) {
                    $user->setPassword($model->password);
                    $user->updatePasswordEmail();
                    $user->save();
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Your password has been successfully edited'));
                    return $this->refresh();
                }
            }
        }
        /* User paswword */



        /* User Info */
        if ($modelInfo->load(Yii::$app->request->post()) && !empty(Yii::$app->request->post('update_information'))) {
            if ($modelInfo->validate()) {
                $user->userInfo->first_name = $modelInfo->first_name;
                $user->userInfo->last_name = $modelInfo->last_name;
                $user->userInfo->location = $modelInfo->location;
                $user->userInfo->save();
                Yii::$app->session->setFlash('success', Yii::t('success_message', 'Your profile has been successfully edited'));
                return $this->refresh();
            }
        }
        /* User Info */

        return $this->render('edit', ['modelInfo' => $modelInfo, 'model' => $model, 'modelImage' => $modelImage, 'user' => $user]);
    }
}
