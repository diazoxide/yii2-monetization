<?php

namespace diazoxide\yii2monetization\widgets;

use DateInterval;
use DatePeriod;
use DateTime;
use Yii;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\httpclient\Client;
use yii\widgets\DetailView;
use kartik\daterange\DateRangePicker;

/**
 * @property Client __client
 */
class Mon_50onred extends \yii\bootstrap\Widget
{
    public $api_token;
    public $default_interval = '3 day';
    public $zone = ['yurpsm'];
    public $monetization = ['Pops'];
    public $pubtype = 'js';
    public $date_group_by = 'day';
    public $group_by = ['zone'];

    protected $_dateStart;
    protected $_dateEnd;
    protected $_interval = '1 day';
    protected $_params;
    protected $_dateFormat = "Y-m-d";
    protected $_url;

    private $__client;

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function init()
    {

        $this->setDates();

        $this->__client = new Client([
            'transport' => 'yii\httpclient\CurlTransport' // only cURL supports the options we need
        ]);

        $this->_params  = [
            'filters' => [
                'zone' => $this->zone, //Optional
//                'country' => array('US', 'CA'), //Optional
                'monetization' => $this->monetization, //Optional
            ],
//            'thresholds' => array('daus > 1000'),
            'group_by' => $this->group_by, //Optional
            'date_group_by' => $this->date_group_by, //Optional
            'start_date' => $this->_dateStart, //Required
            'end_date' => $this->_dateEnd, //Required
            'pubtype' => $this->pubtype, //Required
//            'return_format'=>'json'
        ];

        $this->_url = 'https://pubapi.50onred.com/v2/report?' . http_build_query($this->_params);

        $data = $this->sendRequest();

        $this->renderForm();

        print_r($data);

        /*$js = <<<JS
    alert('{$this->_url}');

$.ajax({
    type: "GET",
    dataType: "jsonp",
    url: "{$this->_url}",
    complete: function(data) {
        console.log(data.responseText);
    }
});

JS;

        $this->view->registerJs($js);*/
//        $tabs = [];
//
//        $data = $this->sendRequest();
//        foreach ($data as $item) {
//            $tabs[] = [
//                'label' => $item->name,
//                'content' => $this->render('_mon_50onred', ['model' => $item]),
//            ];
//
//        }
//
//        $this->renderForm();
//
//        echo Tabs::widget([
//            'items' => $tabs
//        ]);
        parent::init();
    }

    private function setDates()
    {

        $time = new DateTime('NOW');
        $this->_dateEnd = $time->format($this->_dateFormat);
        $interval = DateInterval::createFromDateString($this->default_interval);
        $time->sub($interval);
        $this->_dateStart = $time->format($this->_dateFormat);


        if (Yii::$app->request->get($this->id)) {
            $this->_params = Yii::$app->request->get($this->id);
        }

        if (isset($this->_params['date_range'])) {
            $dateArray = explode(' - ', $this->_params['date_range']);

            $time = new DateTime($dateArray[0]);
            $this->_dateStart = $time->format($this->_dateFormat);

            $time = new DateTime($dateArray[1]);
            $this->_dateEnd = $time->format($this->_dateFormat);
        }

    }

    public function csvToArray($str){
        $lines = explode( "\n", $str );
        $headers = str_getcsv( array_shift( $lines ) );
        $data = array();
        foreach ( $lines as $line ) {
            $row = array();
            foreach ( str_getcsv( $line ) as $key => $field )
                $row[ $headers[ $key ] ] = $field;
            $row = array_filter( $row );
            $data[] = $row;
        }
        return $data;
    }

    /**
     * @param $dateStart
     * @param $dateEnd
     * @return bool|mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function sendRequest()
    {
        $response = $this->__client->createRequest()
            ->setMethod('get')
            ->setUrl($this->_url)
            ->setFormat(Client::FORMAT_RAW_URLENCODED)
            ->addHeaders(['Authorization' => 'Basic ' . base64_encode($this->api_token . ":")])
            ->setOptions([
                CURLOPT_FOLLOWLOCATION => true, // connection timeout
            ])
            ->send();
        echo $response->statusCode;

        if ($response->isOk) {
//            print_r($response->content);
            $data = $this->csvToArray($response->content);
            return $data;
        }
        return false;
    }

    public function renderForm()
    {
        echo Html::beginForm('', 'get');
        echo DateRangePicker::widget([
            'name' => $this->id . '[date_range]',
            'convertFormat' => true,
            'pluginOptions' => [
                'timePicker' => true,
                'timePickerIncrement' => 30,
                'locale' => [
                    'format' => 'Y-m-d'
                ]
            ]
        ]);
        echo Html::submitButton('Submit');
        echo Html::endForm();
    }
}