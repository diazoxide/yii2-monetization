<?php /** @noinspection ALL */

namespace diazoxide\yii2monetization\controllers;

use diazoxide\yii2monetization\models\Conversion;
use diazoxide\yii2monetization\models\ConversionActions;
use diazoxide\yii2monetization\models\ConversionSearch;
use diazoxide\yii2monetization\models\Types;
use Yii;
use diazoxide\yii2monetization\models\Monetization;
use diazoxide\yii2monetization\models\MonetizationSearch;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Monetization model.
 */
class DefaultController extends Controller
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
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['conversion'],
                'cacheControlHeader' => 'nocache',
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'view'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['viewMonetizations']
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function () {
                            return Yii::$app->user->can('viewOwnMonetization', ['model' => $this->findModel(Yii::$app->request->getQueryParam('id'))])
                                || Yii::$app->user->can('viewMonetization');
                        },
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function () {
                            return Yii::$app->user->can('updateOwnMonetization', ['model' => $this->findModel(Yii::$app->request->getQueryParam('id'))])
                                || Yii::$app->user->can('updateMonetization');
                        },
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function () {
                            return Yii::$app->user->can('deleteOwnMonetization', ['model' => $this->findModel(Yii::$app->request->getQueryParam('id'))])
                                || Yii::$app->user->can('deleteMonetization');
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Monetization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MonetizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Monetization model.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $conversionSearchModel = new ConversionSearch();
        $conversionSearchModel->monetization_id = $id;
        $conversionDataProvider = $conversionSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'conversionSearchModel' => $conversionSearchModel,
            'conversionDataProvider' => $conversionDataProvider,
        ]);
    }


    /**
     * Creates a new Monetization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Monetization();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Monetization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function stopPercent($percent)
    {

        $a = 60 * $percent / 100;
        $s = date('s');
        if ($s > $a) {
            return true;
        }
    }

    /**
     * @param $monetization_id
     * @param $type_id
     * @return bool
     */
    public function actionConversion($monetization_id, $type_id)
    {
//        if($this->stopPercent(60)){
//            echo 10;
//            die();
//        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        //$headers->add('Content-Type', 'image/png');

        $ip = Yii::$app->request->userIP;
        $conversion = Conversion::findOne(['ip' => $ip]);
        $type = Types::findOne($type_id);
        if ($conversion == null) {

            $conversion = new Conversion();
            $conversion->monetization_id = $monetization_id;
            $conversion->ip = Yii::$app->request->userIP;
            $conversion->user_agent = Yii::$app->request->userAgent;

            if (!$conversion->save()) {
                return false;
            }
        }

        $actionCount = ConversionActions::find()->andWhere(['conversion_id' => $conversion->id, 'type_id' => $type_id])->count();

        if ($actionCount < $type->limit || $type->limit == 0) {

            $action = new ConversionActions();
            $action->conversion_id = $conversion->id;
            $action->type_id = $type_id;
            $action->referral = Yii::$app->request->referrer;

            $action->save();
        }
        return 1;
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Monetization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Monetization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Monetization::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
