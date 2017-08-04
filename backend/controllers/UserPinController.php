<?php namespace backend\controllers;

use Yii;
use common\models\UserPin;
use common\models\UserPinSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserPinController implements the CRUD actions for UserPin model.
 */
class UserPinController extends Controller
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
     * Lists all UserPin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelApprovedTrue = new UserPinSearch();
        $searchModelApprovedTrue->approved = UserPin::APPROVED_TRUE;
        $dataProviderApprovedTrue = $searchModelApprovedTrue->search(Yii::$app->request->queryParams);
        
        
        $searchModelApprovedFalse = new UserPinSearch();
        $searchModelApprovedFalse->approved = UserPin::APPROVED_FALSE;
        $dataProviderApprovedFalse = $searchModelApprovedFalse->search(Yii::$app->request->queryParams);
        
        
        $searchModelApprovedWaiting = new UserPinSearch();
        $searchModelApprovedWaiting->approved = UserPin::APPROVED_WAITING;
        $dataProviderApprovedWaiting = $searchModelApprovedWaiting->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModelApprovedTrue' => $searchModelApprovedTrue,
                'dataProviderApprovedTrue' => $dataProviderApprovedTrue,
                'searchModelApprovedFalse' => $searchModelApprovedFalse,
                'dataProviderApprovedFalse' => $dataProviderApprovedFalse,
                'searchModelApprovedWaiting' => $searchModelApprovedWaiting,
                'dataProviderApprovedWaiting' => $dataProviderApprovedWaiting,
        ]);
    }

    /**
     * Updates an existing UserPin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelField = $model->pinField;

        if ($model->load(Yii::$app->request->post()) && $modelField->load(Yii::$app->request->post())) {
            if ($modelField->save() && $model->save()) {

                Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Pin is successfully edited.'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
                'model' => $model,
                'modelField' => $modelField,
        ]);
    }

    /**
     * Deletes an existing UserPin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success_admin', Yii::t('success_message', 'Pin is successfully deleted.'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserPin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserPin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
