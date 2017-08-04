<?php namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\LocalInfo;
use common\models\UserInfo;
use yii\web\Response;
use common\models\UserPin;
use common\models\Island;
use common\models\Yacht;
use common\models\BlogPost;
use common\models\Busines;
use common\models\PinField;
use common\models\BlogPostComment;
use frontend\helpers\ApiHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionAjaxSearchLocalInfo()
    {

        $name = Yii::$app->request->post('name');
        if (Yii::$app->request->isAjax && !empty($name)) {


            $modelLocalInfos = LocalInfo::findAll(['area_name' => $name]);
            $modelYachts = Yacht::findAll(['name' => $name]);
            $modelBusiness = Busines::findAll(['business_name' => $name]);
            $modelPinFields = PinField::findAll(['name' => $name]);

            if (!empty($modelLocalInfos) OR ! empty($modelYachts) OR ! empty($modelBusiness) OR ! empty($modelPinFields)) {

                $data = $this->renderAjax('_search_results', [
                    'modelLocalInfos' => $modelLocalInfos,
                    'modelYachts' => $modelYachts,
                    'modelBusiness' => $modelBusiness,
                    'modelPinFields' => $modelPinFields,
                ]);
                return json_encode(['value' => $data, 'result' => true, 'type' => 'yacht']);
            }
        }
        return json_encode(['value' => Yii::t('search', 'Not found'), 'result' => false, 'type' => '']);
    }

    public function actionAjaxGoogleIsland()
    {
        if (Yii::$app->request->isAjax) {
            $model = new Island();
            $model->name = Yii::$app->request->post('name');
            $model->coordinate = json_encode(Yii::$app->request->post('coordinate'));
            $model->island_id = Yii::$app->request->post('island_id');
            $model->save();
            //Such code should not be in git.
        }
        return;
    }

    public function actionAjaxWeather()
    {

        if (Yii::$app->request->isAjax) {
            $name = Yii::$app->request->post('name');
            if (!empty($name)) {
                $data_weather = ApiHelper::getWeaterInfo($name);
                return $this->renderAjax('/layouts/container_weather', ['data_weather' => $data_weather]);
            }
        }
        return;
    }

    public function actionAjaxWeatherInfo()
    {

        if (Yii::$app->request->isAjax) {
            $lat = Yii::$app->request->post('lat');
            $lng = Yii::$app->request->post('lng');
            if (!empty($lat) && !empty($lng)) {
                $data_weather = ApiHelper::getWeaterInfoMap($lat, $lng);
                return $this->renderAjax('/layouts/container_weather_map', ['data_weather' => $data_weather, 'lat' => $lat, 'lng' => $lng]);
            }
        }
        return;
    }

    public function actionWeatherInfo()
    {

        $lat = Yii::$app->request->get('lat');
        $lng = Yii::$app->request->get('lng');

        if (empty($lat) OR empty($lng)) {
            return $this->goHome();
        }

        $data_weather = ApiHelper::getWeaterInfoMap($lat, $lng);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('weather_info', [
                    'data_weather' => $data_weather,
                    'lat' => $lat,
                    'lng' => $lng,
                    'header' => false,
            ]);
        } else {
            return $this->render('weather_info', [
                    'data_weather' => $data_weather,
                    'lat' => $lat,
                    'lng' => $lng,
                    'header' => true,
            ]);
        }
    }

    public function actionIndex()
    {
        //Move USA hardcoded value to params.
        $data_weather = ApiHelper::getWeaterInfo('USA');

        $modelPins = UserPin::find()->where(['approved' => UserPin::APPROVED_TRUE])->all();
        $modelLocalInfos = LocalInfo::find()->all();
        $pins = ApiHelper::generatePins($modelPins);
        $localInfos = ApiHelper::generateLocalInfos($modelLocalInfos);


        $dataProviderBlogs = new \yii\data\ActiveDataProvider([
            'query' => BlogPost::find()->where([
                'type' => '',
                'user_id' => null,
            ])->orderBy('date_create DESC'),
            'pagination' => [
                'pageSize' => \Yii::$app->params['blogPostHomeManyPageSize'],
            ],
        ]);
        $dataProviderCurrentBlogs = new \yii\data\ActiveDataProvider([
            'query' => BlogPost::find()->where([
                'type' => BlogPost::TYPE_CURRENT,
                'user_id' => null,
            ])->orderBy('date_create DESC'),
            'pagination' => [
                'pageSize' => \Yii::$app->params['blogPostHomeLittlePageSize'],
            ],
        ]);

        $blogsWeek = BlogPost::find()->where([
                'type' => BlogPost::TYPE_WEEK,
                'user_id' => null,
            ])->orderBy('date_create DESC')->all();
        return $this->render('index', [
                'data_weather' => $data_weather,
                'dataProviderBlogs' => $dataProviderBlogs,
                'dataProviderCurrentBlogs' => $dataProviderCurrentBlogs,
                'blogsWeek' => $blogsWeek,
                'pins' => !empty($pins) ? json_encode($pins) : '',
                'localInfos' => !empty($localInfos) ? json_encode($localInfos) : '',
        ]);
    }

    public function actionAjaxDeleteBlogComment($id)
    {

        if (Yii::$app->request->isAjax) {
            $model = BlogPostComment::findOne($id);

            if (empty($model) OR $model->user_id != Yii::$app->user->id) {
                return 'null';
            }
            $model->delete();
            return 'true';
        }
    }

    public function actionAjaxDeleteReview($id)
    {

        if (Yii::$app->request->isAjax) {
            $model = \common\models\Reviews::findOne($id);

            if (empty($model) OR $model->user_id != Yii::$app->user->id) {
                return 'null';
            }

            Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review deleted'));
            $model->delete();
            return 'true';
        }
    }

    public function actionAjaxDeleteReviewReply($id)
    {

        if (Yii::$app->request->isAjax) {
            $model = \common\models\ReviewReply::findOne($id);

            if (empty($model) OR $model->user_id != Yii::$app->user->id) {
                return 'null';
            }

            Yii::$app->session->setFlash('success', Yii::t('success_message', 'Review deleted'));
            $model->delete();
            return 'true';
        }
    }

    public function actionBlogView($id)
    {
        $model = BlogPost::findOne($id);
        if (empty($model)) {
            return $this->goHome();
        }



        if (!empty($model->yacht->id)) {
            $modelPrev = BlogPost::find()
                ->joinWith('yacht')
                ->andWhere(['<', 'blog_posts.id', $id])
                ->andWhere(['yachts.id' => $model->yacht->id])
                ->orderBy('blog_posts.id DESC')
                ->one();
            $modelNext = BlogPost::find()
                ->joinWith('yacht')
                ->andWhere(['>', 'blog_posts.id', $id])
                ->andWhere(['yachts.id' => $model->yacht->id])
                ->orderBy('blog_posts.id')
                ->one();
        } else {
            $modelPrev = BlogPost::find()
                ->andWhere(['<', 'id', $id])
                ->orderBy('id DESC')
                ->one();
            $modelNext = BlogPost::find()
                ->andWhere(['>', 'id', $id])
                ->orderBy('id')
                ->one();
        }



        $modelCount = BlogPostComment::find()->where(['blog_id' => $model->id])->count();

        $modelBlogComment = new BlogPostComment;
        $modelBlogComment->setScenario('insert');
        $modelBlogComment->user_id = Yii::$app->user->id;
        $modelBlogComment->blog_id = $model->id;
        if ($modelBlogComment->load(Yii::$app->request->post()) && $modelBlogComment->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('success_message', 'Your comment has been successfully added'));
            return $this->redirect(['blog-view', 'id' => $id]);
        }


        $dataProviderBlogComments = new \yii\data\ActiveDataProvider([
            'query' => BlogPostComment::find()->where([
                'blog_id' => $model->id,
            ])->orderBy('date_create DESC'),
            'pagination' => [
                'pageSize' => \Yii::$app->params['blogPostCommentPageSize'],
            ],
        ]);
        return $this->render('blogView', [
                'model' => $model,
                'modelCount' => $modelCount,
                'modelPrev' => $modelPrev,
                'modelNext' => $modelNext,
                'modelBlogComment' => $modelBlogComment,
                'dataProviderBlogComments' => $dataProviderBlogComments,
        ]);
    }

    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty(Yii::$app->request->post('login'))) {
                $model->login();

                return $this->redirect('/profile/edit');
            }
        } else {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            return $this->render('login', [
                    'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAjaxFbSignup()
    {
        if (!empty(Yii::$app->request->post('id'))) {
            $user = User::findByFbId(Yii::$app->request->post('id'));
            if (!empty($user->id)) {
                //Move hardcoded value to params or at least to user model
                Yii::$app->user->login($user, 3600 * 24 * 30);
                return ApiHelper::successResponse(['result' => 'login']);
            }

            $model = new User();

            $model->scenario = 'insert_fb';
            $modelInfo = new UserInfo();
            $modelInfo->scenario = 'insert_fb';
            $modelInfo->first_name = Yii::$app->request->post('first_name');
            $modelInfo->last_name = Yii::$app->request->post('last_name');
            $model->email = Yii::$app->request->post('email');
            $model->fb_id = Yii::$app->request->post('id');
            $model->setPassword(uniqid());
            $model->generateAuthKey();
            $model->reg_type = \common\models\User::REG_TYPE_FB;
            if ($model->validate()) {
                $model->save();
                $modelInfo->user_id = $model->id;
                if ($modelInfo->validate()) {
                    //Use 3-rd party classes for facebook or move hardcoded values to params or model
                    $url = "http://graph.facebook.com/" . Yii::$app->request->post('id') . "/picture?type=large";
                    $headers = get_headers($url, 1);
                    if (isset($headers['Location'])) {
                        //Change to yii2 native methods instead.
                        $name_file = uniqid('file_') . ".jpg";
                        $path = $_SERVER['DOCUMENT_ROOT'] . 'frontend/web/uploads/' . $name_file;
                        copy($headers['Location'], $path);
                        $modelImage = new \common\models\Image;
                        $modelImage->scenario = 'insert';
                        $modelImage->name = $name_file;
                        $modelImage->upload_image = '';
                        $modelImage->save();
                        $modelInfo->image_id = $modelImage->id;
                    }

                    $modelInfo->save();
                    //Move hardcoded value to params or at least to user model
                    Yii::$app->user->login($model, 3600 * 24 * 30);

                    return ApiHelper::successResponse(['result' => 'success']);
                } else {
                    return ApiHelper::errorResponse($modelInfo->getErrors());
                }
            } else {
                return ApiHelper::errorResponse($model->getErrors());
            }
        }
    }

    public function actionConfirm()
    {
        $code = Yii::$app->request->get('code');
        if (empty($code)) {

            Yii::$app->getSession()->setFlash('error', Yii::t('error_message', 'Confirmation code is invalid'));
            return $this->goHome();
        }
        $model = User::findByCodeConfirm($code);
        if (empty($model->id)) {
            Yii::$app->getSession()->setFlash('error', Yii::t('error_message', 'There is no such user'));
            return $this->goHome();
        }

        $model->status = User::STATUS_ACTIVE;
        $model->save();
        //Move hardcoded value to params or at least to user model
        Yii::$app->user->login($model, 3600 * 24 * 30);
        Yii::$app->getSession()->setFlash('success', Yii::t('success_message', 'Your account has been successfully confirmed'));
        return $this->redirect('/profile/edit');
    }

    public function actionSignup()
    {
        $model = new User();
        $modelInfo = new UserInfo();
        $model->scenario = 'insert';
        $modelInfo->scenario = 'insert';
        if ($model->load(Yii::$app->request->post()) && $modelInfo->load(Yii::$app->request->post())) {
            $model->validate();
            $modelInfo->validate();
            if (empty($modelInfo->getErrors()) && empty($model->getErrors()) && !Yii::$app->request->isAjax) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
                $model->reg_type = \common\models\User::REG_TYPE_FRONTENT;
                if ($model->save()) {
                    $modelInfo->user_id = $model->id;
                    $modelInfo->save();
                    $model->registrationEmail();
                    Yii::$app->getSession()->setFlash('success', Yii::t('success_message', 'Thank you for joining us! Please check your email to confirm the registration.'));
                    return $this->goHome();
                }
            }
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = array_merge(\yii\widgets\ActiveForm::validate($model), \yii\widgets\ActiveForm::validate($modelInfo));
            return $result;
        }
        return $this->render('signup', [
                'model' => $model,
                'modelInfo' => $modelInfo,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('success_message', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('error_message', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('success_message', 'New password was saved.'));
            $user = $model->resetPassword();
            //Move hardcoded value to params or at least to user model
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return $this->redirect('/profile/edit');
        }

        return $this->render('resetPassword', [
                'model' => $model,
        ]);
    }
}
