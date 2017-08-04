<?php namespace backend\controllers;

use Yii;
use common\models\BlogPost;
use common\models\BlogPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * BlogPostController implements the CRUD actions for BlogPost model.
 */
class BlogPostController extends Controller
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
                    [
                        'allow' => false,
                        'roles' => ['?'],
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

    /**
     * Lists all BlogPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogPostSearch();
        
        $dataProvider = $searchModel->searchAdmin(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new BlogPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogPost();
        $model->setScenario('insert');
        $modelImage = new \common\models\Image();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $modelImage->upload_image = UploadedFile::getInstance($modelImage, 'upload_image');
            if ($modelImage->upload_image && $modelImage->validate()) {
                if (!empty($model->image_id)) {
                    \common\models\Image::deleteImage($model->image_id);
                }
                $model->image_id = $modelImage->uploads();
                $model->save();
                Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Blog Post is successfully created.'));
                return $this->redirect(['index']);
            }
            fb($modelImage->getErrors());
        } else {
            return $this->render('create', [
                    'model' => $model,
                    'modelImage' => $modelImage,
            ]);
        }
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

            $model->save();
            Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Blog Post is successfully edited.'));
            return $this->redirect(['index']);
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
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Blog Post is successfully deleted.'));
        return $this->redirect(['index']);
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
        if (($model = BlogPost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
