<?php namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\UploadForm;
use common\models\PinField;
use common\models\PinImage;
use common\models\UserPin;
use common\models\Image;
use common\models\Reviews;
use common\models\ReviewsSearch;
use common\models\User;
use yii\web\UploadedFile;
use yii\web\Session;
use frontend\helpers\ApiHelper;
use yii\filters\AccessControl;

class PinController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view'],
                    ],
                ],
            ],
        ];
    }

    public function actionView($id)
    {

        $pin = UserPin::findOne($id);

        if (empty($pin->id)) {
            return $this->goHome();
        }
        if (($pin->approved == UserPin::APPROVED_FALSE OR $pin->approved == UserPin::APPROVED_WAITING) && $pin->user_id != Yii::$app->user->id) {
            return $this->goHome();
        }
        $image = new Image();
        $reviews = new Reviews();
        $reviews->scenario = 'pin';
        $reviews->type = Reviews::TYPE_PIN;

        //Check for empty($pin) required also.
        if (empty($pin->id)) {
            return $this->goHome();
        }

        $searchModelReviews = new ReviewsSearch();
        $searchModelReviews->approved = Reviews::APPROVED_TRUE;
        $searchModelReviews->pin_id = $id;
        $dataProviderReviews = $searchModelReviews->search(Yii::$app->request->queryParams);
        if ($reviews->load(Yii::$app->request->post())) {
            $reviews->user_id = Yii::$app->user->id;
            $reviews->pin_id = $id;
            $reviews->type = Reviews::TYPE_PIN;
            $reviews->date_create = time();
            //Such logic should be moved into model.
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
                //TODO: It is better to use review status for checking instead.
                if (User::hasBackendAccess()) {
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review is added'));
                } else {
                    Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review is added. Waiting for approved'));
                }

                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('view', [
                'pin' => $pin,
                'reviews' => $reviews,
                'image' => $image,
                'dataProviderReviews' => $dataProviderReviews,
        ]);
    }
}
