<?php
namespace diazoxide\yii2monetization\widgets;
use yii\bootstrap\Tabs;
use yii\httpclient\Client;
use yii\widgets\DetailView;

/**
 * Created by PhpStorm.
 * User: Yordanyan
 * Date: 27.02
 * Time: 16:16
 */
class Mon_50onred extends \yii\bootstrap\Widget
{
    public $api_token;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {


        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport' // only cURL supports the options we need
        ]);

        $params = [
            "access_token" => $this->api_token,
            "date_start" => "2019-01-01",
            "date_end" => "2019-01-10",
            "nochildren" => 'true',
            "category" => "true",
        ];
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('https://login.50onred.com/api-v1/zone_stats.php?' . http_build_query($params))
            ->setFormat(Client::FORMAT_JSON)
            ->setData($params)
            ->send();

        $tabs = [];

        if ($response->isOk) {

            $data = json_decode($response->content);
//            echo "<pre style='margin-top:200px'>";
//            print_r($data);
//            echo "</pre>";


            foreach ($data as $item) {
                $tabs[] = [
                    'label' => $item->name,
                    'content' => 'Rev: '.$item->totals->revenue.' DAUs:'.$item->totals->daus,
                ];

            }

        }


        echo Tabs::widget([
            'items' => $tabs
        ]);
        parent::init();
    }
}