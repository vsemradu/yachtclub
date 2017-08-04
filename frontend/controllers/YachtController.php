<?php namespace frontend\controllers;

use Yii;
use common\models\BlogPost;
use common\models\BlogPostSearch;
use common\models\Yacht;
use common\models\YachtImage;
use common\models\YachtSearch;
use common\models\ReviewReply;
use common\models\YachtSeason;
use common\models\YachtBlog;
use common\models\CrewMember;
use common\models\CrewMemberRole;
use common\models\YachtCrew;
use common\models\YachtInquireForm;
use common\models\Reviews;
use common\models\ReviewsSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Image;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use yii\filters\AccessControl;

/**
 * YachtController implements the CRUD actions for Yacht model.
 */
class YachtController extends Controller
{

    public function actions()
    {
        return [
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => $_SERVER['DOCUMENT_ROOT'] . 'frontend/web/uploads',
            ]
        ];
    }

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
//                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'ajax-get-yacht', 'ajax-crew', 'ajax-season',],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['ajax-delete-crewmember', 'ajax-delete-season', 'ajax-delete-photo', 'ajax-delete-fon-photo', 'create', 'update', 'delete-blog', 'delete', 'fileapi-upload'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAjaxGetYacht()
    {
        if (Yii::$app->request->isAjax) {


            $id = Yii::$app->request->post('id');
            if (empty($id)) {
                return;
            }

            $model = Yacht::findOne(['id' => $id]);
            if (empty($model->id)) {
                return;
            }

            $data['name'] = $model->name;
            $data['draft'] = $model->draft;
            $data['length'] = $model->length;
            $data['beam'] = $model->beam;
            $data['air_draft'] = $model->air_draft;
            $data['type_yacht'] = Yacht::itemAlias('type_yacht', $model->yacht_type_id);
            return json_encode($data);
        }
        return;
    }

    /**
     * Displays a single Yacht model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $searchModelBlogPost = new BlogPostSearch();
        $dataProviderBlogPost = $searchModelBlogPost->searchYachtView(Yii::$app->request->queryParams, $model->yachtBlogIds);
        $modelYachtInquireForm = new YachtInquireForm();

        if (!empty(Yii::$app->user->id)) {
            $modelYachtInquireForm->email = Yii::$app->user->identity->email;
        }

        $image = new Image();
        $reviews = new Reviews();
        $reviewReply = new ReviewReply();



        $reviews->type = Reviews::TYPE_YACHT;
        $reviews->scenario = 'yacht';

        $searchModelReviews = new ReviewsSearch();
        $searchModelReviews->approved = Reviews::APPROVED_TRUE;
        $searchModelReviews->yacht_id = $id;
        $dataProviderReviews = $searchModelReviews->search(Yii::$app->request->queryParams);



        $reviewReply->type = Reviews::TYPE_YACHT;
        $reviewReply->date_create = time();
        if ($reviewReply->load(Yii::$app->request->post()) && $reviewReply->save()) {
            Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review reply sent'));
            return $this->redirect(['view', 'id' => $id]);
        }





        if ($modelYachtInquireForm->load(Yii::$app->request->post()) && $modelYachtInquireForm->validate()) {

            Yii::$app->session->setFlash('success', Yii::t('success_message', 'Message sent'));

            $modelYachtInquireForm->sendEmail();
            return $this->redirect(['view', 'id' => $id]);
        }

        if ($reviews->load(Yii::$app->request->post()) && !empty(Yii::$app->user->id)) {
            $reviews->user_id = Yii::$app->user->id;
            $reviews->yacht_id = $id;
            $reviews->type = Reviews::TYPE_YACHT;
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




        return $this->render('view', [
                'model' => $model,
                'searchModelBlogPost' => $searchModelBlogPost,
                'modelYachtInquireForm' => $modelYachtInquireForm,
                'dataProviderBlogPost' => $dataProviderBlogPost,
                'reviews' => $reviews,
                'image' => $image,
                'dataProviderReviews' => $dataProviderReviews,
        ]);
    }

    /**
     * Creates a new Yacht model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjaxDeleteCrewmember()
    {

        $yacht_id = Yii::$app->request->get('yacht_id');
        $crewmember_id = Yii::$app->request->get('crewmember_id');


        $model = Yacht::find()->where(['id' => $yacht_id, 'user_id' => \Yii::$app->user->id])->one();
        if (!empty($model->id)) {
            $yachtCrew = YachtCrew::find()->where(['yacht_id' => $yacht_id, 'crew_member_id' => $crewmember_id])->one();
            if (!empty($yachtCrew->id)) {
                $yachtCrew->delete();
            }
        }
    }

    public function actionAjaxDeleteSeason()
    {
        $yacht_id = Yii::$app->request->get('yacht_id');
        $season_id = Yii::$app->request->get('season_id');

        $model = Yacht::find()->where(['id' => $yacht_id, 'user_id' => \Yii::$app->user->id])->one();
        if (!empty($model->id)) {
            $yachtSeason = YachtSeason::find()->where(['id' => $season_id, 'yacht_id' => $yacht_id])->one();
            if (!empty($yachtSeason->id)) {
                $yachtSeason->delete();
            }
        }
    }

    public function actionAjaxCrew()
    {

        $model = new Yacht();
        $crewMember = new CrewMember();
        $crewMemberRole = CrewMemberRole::find()->orderBy('sort')->all();
        $image = new Image();

        return $this->renderAjax('_ajax_crew', [
                'model' => $model,
                'crewMemberRole' => $crewMemberRole,
                'crewMember' => $crewMember,
                'image' => $image,
                'remove' => true,
        ]);
    }

    public function actionAjaxSeason()
    {
        $yachtSeason = new YachtSeason();
        return $this->renderAjax('_ajax_season', [
                'yachtSeason' => $yachtSeason,
                'remove' => true,
        ]);
    }

    public function actionAjaxDeletePhoto()
    {
        $yacht_id = Yii::$app->request->get('yacht_id');
        $yacht_photo_id = Yii::$app->request->get('yacht_photo_id');
        $model = Yacht::find()->where(['id' => $yacht_id, 'user_id' => \Yii::$app->user->id])->one();

        if (!empty($yacht_id) && !empty($yacht_photo_id) && !empty($model->id)) {
            $yachtImage = YachtImage::findOne($yacht_photo_id);
            Image::deleteImage($yachtImage->image_id);
            $yachtImage->delete();
        }
    }

    public function actionAjaxDeleteFonPhoto()
    {


        $yacht_id = Yii::$app->request->get('yacht_id');
        $photo_id = Yii::$app->request->get('photo_id');
        $model = Yacht::find()->where(['id' => $yacht_id, 'user_id' => \Yii::$app->user->id])->one();
        if (!empty($yacht_id) && !empty($photo_id) && !empty($model->id)) {
            Image::deleteImage($photo_id);
            $yacht = $this->findModel($yacht_id);
            $yacht->background_image_id = 0;
            //delete photo after save() only. Otherwise 404 may occure.
            $yacht->save();
        }
    }

    public function actionCreate()
    {
        //Remove commented code.
        $subtype_id = Yii::$app->request->post('subtype_id');
        if (empty($subtype_id)) {
            return $this->redirect(['/site/index']);
        }
        $model = new Yacht();
        $model->subtype = $subtype_id;
        $crewMembers = [];
        $yachtSeasons = [];
        $crewMemberRole = CrewMemberRole::find()->all();
        $image = new Image();
        $errors_crew = [];
        $errors_season = [];

        if (!empty(Yii::$app->request->post('CrewMember'))) {
            //loadMultiple() is a better idea.
            $crewMembers = array();
            foreach (Yii::$app->request->post('CrewMember') as $crewMemberPost) {


                $crew_member = new CrewMember();
                $crew_member->name = $crewMemberPost['name'];
                $crew_member->role_id = !empty($crewMemberPost['role_id']) ? $crewMemberPost['role_id'] : '';
                $crew_member->role = $crewMemberPost['role'];
                $crew_member->validate();



                if ($crew_member->role_id == CrewMemberRole::TYPE_OTHER) {
                    if (empty($crew_member->role)) {
                        //Model rules should be used instead
                        $crew_member->addError('role', 'Role cannot be blank.');
                    }
                }
                if (!empty($crew_member->getErrors())) {
                    $errors_crew[] = $crew_member->getErrors();
                }


                $crewMembers[] = $crew_member;
            }
            $crew = 1;
        }
        if (!empty(Yii::$app->request->post('YachtSeason'))) {
            $yachtSeasons = array();
            foreach (Yii::$app->request->post('YachtSeason') as $yachtSeasonPost) {
                $yacht_season = new YachtSeason();
                $yacht_season->season = $yachtSeasonPost['season'];
                $yacht_season->from = $yachtSeasonPost['from'];
                $yacht_season->to = $yachtSeasonPost['to'];
                $yacht_season->currency = $yachtSeasonPost['currency'];
                if (!$yacht_season->validate()) {
                    $errors_season[] = $yacht_season->getErrors();
                }

                $yachtSeasons[] = $yacht_season;
            }
            $season = 1;
        }

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->id;
            $model->type_id = Yacht::itemAlias('type_by_subtype', $subtype_id);
            $model->subtype = $subtype_id;
            $model->enable_blog = Yii::$app->request->post('enable_blog');
            $model->validate();
            if ($model->yacht_type_id == Yacht::TYPE_OTHER) {
                if (empty($model->yacht_type)) {
                    $model->addError('yacht_type', 'Type cannot be blank ');
                }
            }
            if (empty($model->getErrors())) {


                if (empty($errors_crew) && empty($errors_season)) {
                    $imageFon = new Image();
                    $imageFon->name = Yii::$app->request->post('Image')['name'];
                    if (!empty($imageFon->name) && $imageFon->save()) {
                        $model->background_image_id = $imageFon->id;
                    }
                    $model->save();
                    $imagePhoto = new Image();
                    $imagePhoto->upload_image = UploadedFile::getInstances($imagePhoto, '[\'yacht\']upload_image');
                    if ($imagePhoto->upload_image) {
                        foreach ($imagePhoto->upload_image as $upload_image) {
                            $img = new Image;
                            $yachtImage = new YachtImage;
                            $img->upload_image = $upload_image;
                            if ($img->validate()) {
                                $yachtImage->image_id = $img->uploads();
                                $yachtImage->yacht_id = $model->id;
                                $yachtImage->save();
                            }
                        }
                    }
                    if (!empty(Yii::$app->request->post('CrewMember'))) {
                        foreach (Yii::$app->request->post('CrewMember') as $key => $crewMemberPost) {
                            $crew_member = new CrewMember();
                            $crew_member->name = $crewMemberPost['name'];
                            $crew_member->role_id = !empty($crewMemberPost['role_id']) ? $crewMemberPost['role_id'] : '';
                            $crew_member->role = $crewMemberPost['role'];
                            $imageCrew = new Image();
                            $imageCrew->upload_image = UploadedFile::getInstance($imageCrew, '[\'crew\']upload_image[' . $key . ']');
                            if ($imageCrew->upload_image) {
                                if ($imageCrew->validate()) {
                                    $crew_member->photo_id = $imageCrew->uploads();
                                }
                            }
                            $crew_member->save();
                            $yachtCrew = new YachtCrew();
                            $yachtCrew->yacht_id = $model->id;
                            $yachtCrew->crew_member_id = $crew_member->id;
                            $yachtCrew->save();
                        }
                    }


                    if (!empty(Yii::$app->request->post('YachtSeason'))) {
                        foreach (Yii::$app->request->post('YachtSeason') as $yachtSeasonPost) {
                            $yacht_season = new YachtSeason();
                            $yacht_season->season = $yachtSeasonPost['season'];
                            $yacht_season->from = $yachtSeasonPost['from'];
                            $yacht_season->to = $yachtSeasonPost['to'];
                            $yacht_season->currency = $yachtSeasonPost['currency'];
                            $yacht_season->yacht_id = $model->id;
                            $yacht_season->save();
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        if (empty($crew)) {
            $crewMembers = [];
        }
        if (empty($season)) {
            $yachtSeasons = [];
        }


        return $this->render('page_type/type_' . $subtype_id, [
                'model' => $model,
                'crewMemberRole' => $crewMemberRole,
                'crewMembers' => $crewMembers,
                'image' => $image,
                'subtype_id' => $subtype_id,
                'yachtSeasons' => $yachtSeasons,
                'modelBlogPost' => '',
                'modelBlogPostImage' => '',
                'searchModelBlogPost' => '',
                'dataProviderBlogPost' => '',
        ]);
    }

    /**
     * Updates an existing Yacht model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (empty($model->id) OR $model->user_id != \Yii::$app->user->id) {
            return $this->goHome();
        }
        $crewMembers = $model->updateYachtCrews;
        $yachtSeasons = $model->yachtSeason;
        $crewMemberRole = CrewMemberRole::find()->all();
        $image = new Image();
        $errors_crew = [];
        $errors_season = [];


        if ($model->load(Yii::$app->request->post())) {

            $model->enable_blog = Yii::$app->request->post('enable_blog');
            $model->validate();
            if ($model->yacht_type_id == Yacht::TYPE_OTHER) {

                if (empty($model->yacht_type)) {
                    $model->addError('yacht_type', 'Type cannot be blank ');
                }
            }


            if (!empty(Yii::$app->request->post('CrewMember'))) {
                $crewMembers = array();
                foreach (Yii::$app->request->post('CrewMember') as $key => $crewMemberPost) {

                    if (is_string($key)) {
                        $crew_member = new CrewMember();
                    } else {
                        $crew_member = CrewMember::findOne($key);
                    }
                    $crew_member->name = $crewMemberPost['name'];
                    $crew_member->role_id = !empty($crewMemberPost['role_id']) ? $crewMemberPost['role_id'] : '';
                    $crew_member->role = $crewMemberPost['role'];

                    $crew_member->validate();
                    if ($crew_member->role_id == CrewMemberRole::TYPE_OTHER) {
                        if (empty($crew_member->role)) {
                            $crew_member->addError('role', 'Role cannot be blank.');
                        }
                    }
                    if (!empty($crew_member->getErrors())) {
                        $errors_crew[] = $crew_member->getErrors();
                    }


                    $crewMembers[] = $crew_member;
                }
                $crew = 1;
            }
            if (!empty(Yii::$app->request->post('YachtSeason'))) {
                $yachtSeasons = array();
                foreach (Yii::$app->request->post('YachtSeason') as $key => $yachtSeasonPost) {


                    if (is_string($key)) {
                        $yacht_season = new YachtSeason();
                    } else {
                        $yacht_season = YachtSeason::findOne($key);
                    }


                    $yacht_season->season = $yachtSeasonPost['season'];
                    $yacht_season->from = $yachtSeasonPost['from'];
                    $yacht_season->to = $yachtSeasonPost['to'];
                    $yacht_season->currency = $yachtSeasonPost['currency'];
                    if (!$yacht_season->validate()) {
                        $errors_season[] = $yacht_season->getErrors();
                    }

                    $yachtSeasons[] = $yacht_season;
                }
                $season = 1;
            }
            if (empty($model->getErrors())) {


                if (empty($errors_crew) && empty($errors_season)) {
                    $imageFon = new Image();
//                    $imageFon->upload_image = UploadedFile::getInstance($imageFon, '[\'yacht_background\']upload_image');
                    $imageFon->name = Yii::$app->request->post('Image')['name'];



                    if (!empty($imageFon->name) && $imageFon->save()) {

                        $model->background_image_id = $imageFon->id;
                    }

                    $model->save();


                    $imagePhoto = new Image();
                    $imagePhoto->upload_image = UploadedFile::getInstances($imagePhoto, '[\'yacht\']upload_image');
                    if ($imagePhoto->upload_image) {
                        foreach ($imagePhoto->upload_image as $upload_image) {
                            $img = new Image;
                            $yachtImage = new YachtImage;
                            $img->upload_image = $upload_image;
                            if ($img->validate()) {
                                $yachtImage->image_id = $img->uploads();
                                $yachtImage->yacht_id = $model->id;
                                $yachtImage->save();
                            }
                        }
                    }

                    if (!empty(Yii::$app->request->post('CrewMember'))) {
                        foreach (Yii::$app->request->post('CrewMember') as $key => $crewMemberPost) {
                            if (is_string($key)) {
                                $crew_member = new CrewMember();
                            } else {
                                $crew_member = CrewMember::findOne($key);
                            }
                            $crew_member->name = $crewMemberPost['name'];
                            $crew_member->role_id = !empty($crewMemberPost['role_id']) ? $crewMemberPost['role_id'] : '';
                            $crew_member->role = $crewMemberPost['role'];
                            $imageCrew = new Image();
                            $imageCrew->upload_image = UploadedFile::getInstance($imageCrew, '[\'crew\']upload_image[' . $key . ']');
                            if ($imageCrew->upload_image) {
                                if ($imageCrew->validate()) {
                                    $crew_member->photo_id = $imageCrew->uploads();
                                }
                            }
                            $crew_member->save();
                            if ($crew_member->id != $key) {
                                $yachtCrew = new YachtCrew();
                                $yachtCrew->yacht_id = $model->id;
                                $yachtCrew->crew_member_id = $crew_member->id;
                                $yachtCrew->save();
                            }
                        }
                        $crew = 0;
                    }


                    if (!empty(Yii::$app->request->post('YachtSeason'))) {
                        foreach (Yii::$app->request->post('YachtSeason') as $key => $yachtSeasonPost) {
                            if (is_string($key)) {
                                $yacht_season = new YachtSeason();
                            } else {
                                $yacht_season = YachtSeason::findOne($key);
                            }

                            $yacht_season->season = $yachtSeasonPost['season'];
                            $yacht_season->from = $yachtSeasonPost['from'];
                            $yacht_season->to = $yachtSeasonPost['to'];
                            $yacht_season->currency = $yachtSeasonPost['currency'];
                            $yacht_season->yacht_id = $model->id;
                            $yacht_season->save();
                        }
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        if (empty($crew)) {
            $crewMembers = $model->updateYachtCrews;
        }
        if (empty($season)) {
            $yachtSeasons = $model->yachtSeason;
        }



        $modelBlogPost = new BlogPost();
        $modelBlogPost->setScenario('insert');
        $modelBlogPostImage = new Image();
        $modelBlogPostImage->scenario = 'update';


        if (!empty(Yii::$app->request->post('add_blog'))) {
            if ($modelBlogPost->load(Yii::$app->request->post())) {
                $modelBlogPostImage->upload_image = UploadedFile::getInstance($modelBlogPostImage, '[\'blog\']upload_image');
                $modelBlogPost->validate();
                $modelBlogPostImage->validate();
                if ($modelBlogPostImage->upload_image && empty($modelBlogPostImage->getErrors()) && empty($modelBlogPost->getErrors())) {
                    if (!empty($modelBlogPost->image_id)) {
                        Image::deleteImage($modelBlogPost->image_id);
                    }
                    $modelBlogPost->user_id = Yii::$app->user->id;
                    $modelBlogPost->image_id = $modelBlogPostImage->uploads();
                    $modelBlogPost->save();

                    $modelYachtBlog = new YachtBlog();
                    $modelYachtBlog->blog_id = $modelBlogPost->id;
                    $modelYachtBlog->yacht_id = $model->id;
                    $modelYachtBlog->save();
                    return $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $modelBlogPostImage->addError('upload_image', 'Please upload file.');
                }
            }
        }

        $searchModelBlogPost = new BlogPostSearch();
        $dataProviderBlogPost = $searchModelBlogPost->searchYacht(Yii::$app->request->queryParams, $model->yachtBlogIds);



        return $this->render('page_type/type_' . $model->subtype, [
                'model' => $model,
                'crewMemberRole' => $crewMemberRole,
                'crewMembers' => $crewMembers,
                'image' => $image,
                'subtype_id' => $model->subtype,
                'yachtSeasons' => $yachtSeasons,
                'modelBlogPost' => $modelBlogPost,
                'modelBlogPostImage' => $modelBlogPostImage,
                'searchModelBlogPost' => $searchModelBlogPost,
                'dataProviderBlogPost' => $dataProviderBlogPost,
        ]);
    }

    /**
     * Deletes an existing Yacht model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteBlog()
    {
        $blog_id = Yii::$app->request->post('blog_id');
        $yacht_id = Yii::$app->request->post('yacht_id');
        if (!empty($blog_id) && !empty($yacht_id)) {
            //Add ownership check
            YachtBlog::deleteAll(['blog_id' => $blog_id, 'yacht_id' => $yacht_id]);
            BlogPost::deleteAll(['id' => $blog_id]);
        }
    }

    public function actionDelete($id)
    {
        //Add ownership check

        if (empty($model->id) OR $model->user_id != \Yii::$app->user->id) {
            return $this->goHome();
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Yacht model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Yacht the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Yacht::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
