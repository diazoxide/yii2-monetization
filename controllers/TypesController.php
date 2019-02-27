<?php /** @noinspection ALL */

namespace diazoxide\yii2monetization\controllers;

use diazoxide\yii2monetization\models\TypesConfig;
use diazoxide\yii2monetization\models\Types;
use diazoxide\yii2monetization\models\TypesSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TypesController implements the CRUD actions for Types model.
 */
class TypesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete', 'create', 'update','config'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewMonetizationTypes']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteMonetizationType']
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createMonetizationType']
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['updateMonetizationType']
                    ],
                    [
                        'actions' => ['config'],
                        'allow' => true,
                        'roles' => ['configMonetizationType']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all MonetizationTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MonetizationTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Types();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MonetizationTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionConfig($id,$monetization)
    {
        $model = $this->findModel($id)->getConfig($monetization);

        if(!$model){
            $model = new TypesConfig();
            $model->type_id = $id;
            $model->monetization_id = $monetization;
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/monetization/default/view','id'=>$monetization]);
        }

        return $this->render('config', [
            'model' => $model,
        ]);
    }




    /**
     * Deletes an existing MonetizationTypes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MonetizationTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Types
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Types::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
