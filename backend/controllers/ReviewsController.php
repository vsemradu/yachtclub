<?php namespace backend\controllers;

use Yii;
use common\models\Reviews;
use common\models\ReviewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewsController implements the CRUD actions for Reviews model.
 */
class ReviewsController extends Controller
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

    /**
     * Lists all Reviews models.
     * @return mixed
     */
    public function actionIndexBusiness()
    {
        //TODO: implement extra function for these logic to prevent code-duplication. 3*3 times
        $searchModelApprovedTrue = new ReviewsSearch();
        $searchModelApprovedTrue->type = Reviews::TYPE_BUSINESS;
        $searchModelApprovedTrue->approved = Reviews::APPROVED_TRUE;
        $dataProviderApprovedTrue = $searchModelApprovedTrue->search(Yii::$app->request->queryParams);

        $searchModelApprovedFalse = new ReviewsSearch();
        $searchModelApprovedFalse->type = Reviews::TYPE_BUSINESS;
        $searchModelApprovedFalse->approved = Reviews::APPROVED_FALSE;
        $dataProviderApprovedFalse = $searchModelApprovedFalse->search(Yii::$app->request->queryParams);

        $searchModelApprovedWaiting = new ReviewsSearch();
        $searchModelApprovedWaiting->type = Reviews::TYPE_BUSINESS;
        $searchModelApprovedWaiting->approved = Reviews::APPROVED_WAITING;
        $dataProviderApprovedWaiting = $searchModelApprovedWaiting->search(Yii::$app->request->queryParams);

        return $this->render('indexBusiness', [
                'searchModelApprovedTrue' => $searchModelApprovedTrue,
                'dataProviderApprovedTrue' => $dataProviderApprovedTrue,
                'dataProviderApprovedFalse' => $dataProviderApprovedFalse,
                'searchModelApprovedFalse' => $searchModelApprovedFalse,
                'searchModelApprovedWaiting' => $searchModelApprovedWaiting,
                'dataProviderApprovedWaiting' => $dataProviderApprovedWaiting,
        ]);
    }

    public function actionIndexYacht()
    {



        $searchModelApprovedTrue = new ReviewsSearch();
        $searchModelApprovedTrue->type = Reviews::TYPE_YACHT;
        $searchModelApprovedTrue->approved = Reviews::APPROVED_TRUE;
        $dataProviderApprovedTrue = $searchModelApprovedTrue->search(Yii::$app->request->queryParams);

        $searchModelApprovedFalse = new ReviewsSearch();
        $searchModelApprovedFalse->type = Reviews::TYPE_YACHT;
        $searchModelApprovedFalse->approved = Reviews::APPROVED_FALSE;
        $dataProviderApprovedFalse = $searchModelApprovedFalse->search(Yii::$app->request->queryParams);

        $searchModelApprovedWaiting = new ReviewsSearch();
        $searchModelApprovedWaiting->type = Reviews::TYPE_YACHT;
        $searchModelApprovedWaiting->approved = Reviews::APPROVED_WAITING;
        $dataProviderApprovedWaiting = $searchModelApprovedWaiting->search(Yii::$app->request->queryParams);

        return $this->render('indexYacht', [
                'searchModelApprovedTrue' => $searchModelApprovedTrue,
                'dataProviderApprovedTrue' => $dataProviderApprovedTrue,
                'dataProviderApprovedFalse' => $dataProviderApprovedFalse,
                'searchModelApprovedFalse' => $searchModelApprovedFalse,
                'searchModelApprovedWaiting' => $searchModelApprovedWaiting,
                'dataProviderApprovedWaiting' => $dataProviderApprovedWaiting,
        ]);
    }

    public function actionIndexPin()
    {




        $searchModelApprovedTrue = new ReviewsSearch();
        $searchModelApprovedTrue->type = Reviews::TYPE_PIN;
        $searchModelApprovedTrue->approved = Reviews::APPROVED_TRUE;
        $dataProviderApprovedTrue = $searchModelApprovedTrue->search(Yii::$app->request->queryParams);

        $searchModelApprovedFalse = new ReviewsSearch();
        $searchModelApprovedFalse->type = Reviews::TYPE_PIN;
        $searchModelApprovedFalse->approved = Reviews::APPROVED_FALSE;
        $dataProviderApprovedFalse = $searchModelApprovedFalse->search(Yii::$app->request->queryParams);

        $searchModelApprovedWaiting = new ReviewsSearch();
        $searchModelApprovedWaiting->type = Reviews::TYPE_PIN;
        $searchModelApprovedWaiting->approved = Reviews::APPROVED_WAITING;
        $dataProviderApprovedWaiting = $searchModelApprovedWaiting->search(Yii::$app->request->queryParams);

        return $this->render('indexPin', [
                'searchModelApprovedTrue' => $searchModelApprovedTrue,
                'dataProviderApprovedTrue' => $dataProviderApprovedTrue,
                'dataProviderApprovedFalse' => $dataProviderApprovedFalse,
                'searchModelApprovedFalse' => $searchModelApprovedFalse,
                'searchModelApprovedWaiting' => $searchModelApprovedWaiting,
                'dataProviderApprovedWaiting' => $dataProviderApprovedWaiting,
        ]);
    }

    /**
     * Updates an existing Reviews model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->type == Reviews::TYPE_YACHT) {
            $model->scenario = 'yacht';
        } elseif ($model->type == Reviews::TYPE_PIN) {
            $model->scenario = 'pin';
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Review is successfully edited.'));
            if ($model->type == Reviews::TYPE_BUSINESS) {
                return $this->redirect(['index-business']);
            } elseif ($model->type == Reviews::TYPE_PIN) {
                return $this->redirect(['index-pin']);
            } else {
                return $this->redirect(['index-yacht']);
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Reviews model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Review is successfully deleted.'));
        if ($model->type == Reviews::TYPE_BUSINESS) {
            return $this->redirect(['index-business']);
        } elseif ($model->type == Reviews::TYPE_PIN) {
            return $this->redirect(['index-pin']);
        } else {
            return $this->redirect(['index-yacht']);
        }
    }

    /**
     * Finds the Reviews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reviews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
