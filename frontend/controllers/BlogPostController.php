<?php namespace frontend\controllers;

use Yii;
use common\models\BlogPost;
use common\models\BlogPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * BlogPostController implements the CRUD actions for BlogPost model.
 */
class BlogPostController extends Controller
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
                        'actions' => ['create', 'update', 'delete', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Updates an existing BlogPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if (empty($model->id) OR $model->user_id != Yii::$app->user->id) {
            return $this->goHome();
        }



        $modelImage = new \common\models\Image();
        $modelImage->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $modelImage->upload_image = UploadedFile::getInstance($modelImage, 'upload_image');
            if ($modelImage->upload_image && $modelImage->validate()) {
                if (!empty($model->image_id)) {
                    \common\models\Image::deleteImage($model->image_id);
                }
                $model->image_id = $modelImage->uploads();
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('success_message', 'Blog save'));
                if (!empty($model->yacht->id)) {
                    return $this->redirect(['/yacht/update', 'id' => $model->yacht->id]);
                }
            }
            Yii::error('Error update blog file BlogPostController');
            Yii::$app->session->setFlash('error', Yii::t('error_message', 'Error update blog'));
            return $this->goHome();
        } else {
            return $this->render('update', [
                    'model' => $model,
                    'modelImage' => $modelImage,
            ]);
        }
    }

    /**
     * Deletes an existing BlogPost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);


        if (!empty($model->id) && $model->user_id == Yii::$app->user->id) {
            $model->delete();
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Finds the BlogPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogPost::find()->where(['id' => $id, 'user_id' => Yii::$app->user->id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
