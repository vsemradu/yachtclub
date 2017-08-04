<?php namespace frontend\helpers;

use linslin\yii2\curl;
use kartik\rating\StarRating;

class ApiHelper
{

    //return array('code' => '0', "errors" => ($model->getErrors())); //"Some Error Has Occurred"
    public function errorResponse($detail, $status = 422, $message = NULL)
    {
        \Yii::$app->response->setStatusCode($status);
        //if !$message -> generate it
        if (!$message) {
            if (is_array($detail)) {// надо оптимизировать
                foreach ($detail as $err) {
                    if (is_array($err)) {
                        $message.=$err[0] . " ";
                    } else {
                        $message.=$err . " ";
                    }
                }
            } else {
                $message = $detail;
            }

            // $message = implode(" ", $detail);
        }

        return json_encode(array('code' => '0', 'status' => $status, "message" => $message, "result" => $detail));
    }

    //return array('code' => '1', 'result' => $model);
    public function successResponse($result)
    {
        return json_encode(array('code' => '1', 'status' => '200', "result" => $result));
    }

    public function getWeaterInfo($name = 'USA')
    {
//        $name = 'Ukraine,Zaporizhzhya';
        $key = !empty(\Yii::$app->params['worldweatheronline_free']) ? \Yii::$app->params['worldweatheronline_key'] : \Yii::$app->params['worldweatheronline_key_premium'];
        $url = !empty(\Yii::$app->params['worldweatheronline_free']) ? \Yii::$app->params['worldweatheronline_url_free'] : \Yii::$app->params['worldweatheronline_url_premium'];
        $get = file_get_contents($url . 'weather.ashx?key=' . $key . '&q=' . urlencode($name) . '&num_of_days=5&format=json');

        $result = json_decode($get, true);
//        $result = [];


        $getCoordinate = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . urlencode($name) . '&sensor=false');
        $resultCoordinate = json_decode($getCoordinate, true);
        if (!empty($resultCoordinate['results'][0]['geometry']['location'])) {
            $coordinate = $resultCoordinate['results'][0]['geometry']['location']['lng'] . ',' . $resultCoordinate['results'][0]['geometry']['location']['lat'];
        } else {
            $coordinate = '';
        }

        $coordinate = '47.547538,35.027731';
        $getMarina = file_get_contents($url . 'marine.ashx?key=' . $key . '&q=' . $coordinate . '&num_of_days=5&format=json');

        $resultMarina = json_decode($getMarina, true);
//        $resultMarina =[];

        $return = array();
        if (!empty($result['data']['weather'])) {
            foreach ($result['data']['weather'] as $k => $weather) {
                $keyHourly = '';
                $valueHourly = '';
                foreach ($weather['hourly'] as $kT => $weatherTime) {
                    $date = date('Gi');
                    $time = $date - $weatherTime['time'];
                    $time = ($time < 0) ? $weatherTime['time'] : $time;
                    if ($time < $valueHourly OR $valueHourly == '') {
                        $valueHourly = $time;
                        $keyHourly = $kT;
                    }
                }

                $dataMarina = !empty($resultMarina['data']['weather'][$k]['hourly'][$keyHourly]) ? $resultMarina['data']['weather'][$k]['hourly'][$keyHourly] : '';
                $return[$k]['date'] = self::weaterDateGenerate($weather['date']);
                $return[$k]['maxtempC'] = $weather['maxtempC'];
                $return[$k]['mintempC'] = $weather['mintempC'];

                $return[$k]['tempC'] = $weather['hourly'][$keyHourly]['tempC'];
                $return[$k]['windspeedKmph'] = $weather['hourly'][$keyHourly]['windspeedKmph'];
                $return[$k]['icon'] = !empty($weather['hourly'][$keyHourly]['weatherIconUrl'][0]['value']) ? $weather['hourly'][$keyHourly]['weatherIconUrl'][0]['value'] : '';
                $return[$k]['windDirection'] = !empty($dataMarina['winddir16Point']) ? $dataMarina['winddir16Point'] : '';
                $return[$k]['windSpeed'] = !empty($dataMarina['windspeedKmph']) ? $dataMarina['windspeedKmph'] : '';
                $return[$k]['averageTemperature'] = round(($weather['maxtempC'] + $weather['mintempC']) / 2);
            }
        }
        return $return;
    }

    public function getWeaterInfoMap($lat, $lng)
    {

        $nameGoogle = file_get_contents('http://maps.google.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&sensor=false');
        $nameGoogle = json_decode($nameGoogle, true);


        $name = !empty($nameGoogle['results'][0]['formatted_address']) ? $nameGoogle['results'][0]['formatted_address'] : '';
        $key = !empty(\Yii::$app->params['worldweatheronline_free']) ? \Yii::$app->params['worldweatheronline_key'] : \Yii::$app->params['worldweatheronline_key_premium'];
        $url = !empty(\Yii::$app->params['worldweatheronline_free']) ? \Yii::$app->params['worldweatheronline_url_free'] : \Yii::$app->params['worldweatheronline_url_premium'];
        $get = file_get_contents($url . 'weather.ashx?key=' . $key . '&q=' . urlencode($name) . '&num_of_days=5&format=json');

        $result = json_decode($get, true);



        $coordinate = $lat . ',' . $lng;
        $getMarina = file_get_contents($url . 'marine.ashx?key=' . $key . '&q=' . $coordinate . '&num_of_days=5&format=json');

        $resultMarina = json_decode($getMarina, true);

        $return = array();
        if (!empty($result['data']['weather'])) {
            foreach ($result['data']['weather'] as $k => $weather) {
                $keyHourly = '';
                $valueHourly = '';
                foreach ($weather['hourly'] as $kT => $weatherTime) {
                    $date = date('Gi');
                    $time = $date - $weatherTime['time'];
                    $time = ($time < 0) ? $weatherTime['time'] : $time;
                    if ($time < $valueHourly OR $valueHourly == '') {
                        $valueHourly = $time;
                        $keyHourly = $kT;
                    }
                }

                $dataMarina = !empty($resultMarina['data']['weather'][$k]['hourly'][$keyHourly]) ? $resultMarina['data']['weather'][$k]['hourly'][$keyHourly] : '';
                $return[$k]['date'] = self::weaterDateGenerate($weather['date']);
                $return[$k]['maxtempC'] = $weather['maxtempC'];
                $return[$k]['mintempC'] = $weather['mintempC'];
                $return[$k]['other'] = $weather['hourly'][$keyHourly];
                $return[$k]['tempC'] = $weather['hourly'][$keyHourly]['tempC'];
                $return[$k]['windspeedKmph'] = $weather['hourly'][$keyHourly]['windspeedKmph'];
                $return[$k]['icon'] = !empty($weather['hourly'][$keyHourly]['weatherIconUrl'][0]['value']) ? $weather['hourly'][$keyHourly]['weatherIconUrl'][0]['value'] : '';
                $return[$k]['averageTemperature'] = round(($weather['maxtempC'] + $weather['mintempC']) / 2);
            }
        }
        if (empty($return)) {
            if (!empty($resultMarina['data']['weather'])) {
                foreach ($resultMarina['data']['weather'] as $k => $weather) {
                    $keyHourly = '';
                    $valueHourly = '';
                    foreach ($weather['hourly'] as $kT => $weatherTime) {
                        $date = date('Gi');
                        $time = $date - $weatherTime['time'];
                        $time = ($time < 0) ? $weatherTime['time'] : $time;
                        if ($time < $valueHourly OR $valueHourly == '') {
                            $valueHourly = $time;
                            $keyHourly = $kT;
                        }
                    }
                    $return[$k]['date'] = self::weaterDateGenerate($weather['date']);
                    $return[$k]['tempC'] = $weather['hourly'][$keyHourly]['tempC'];
                    $return[$k]['icon'] = !empty($weather['hourly'][$keyHourly]['weatherIconUrl'][0]['value']) ? $weather['hourly'][$keyHourly]['weatherIconUrl'][0]['value'] : '';
                    $return[$k]['windDirection'] = !empty($weather['hourly'][$keyHourly]['winddir16Point']) ? $weather['hourly'][$keyHourly]['winddir16Point'] : '';
                    $return[$k]['swellDirection'] = !empty($weather['hourly'][$keyHourly]['swellDir16Point']) ? $weather['hourly'][$keyHourly]['swellDir16Point'] : '';
                    $return[$k]['windSpeed'] = !empty($weather['hourly'][$keyHourly]['windspeedKmph']) ? $weather['hourly'][$keyHourly]['windspeedKmph'] : '';
                    $return[$k]['other'] = $weather['hourly'][$keyHourly];
                }
            }
        }
        return $return;
    }

    public function generatePins($models)
    {
        if (!empty($models)) {
            $data = [];
            foreach ($models as $k => $model) {
                $data[$k]['id'] = $model->id;
                $data[$k]['lat'] = $model->lat;
                $data[$k]['lan'] = $model->lan;
                $data[$k]['type'] = $model->type;
                $data[$k]['title'] = !empty($model->pinField->name) ? $model->pinField->name : '';
                $data[$k]['description'] = $model->description;
                $rating = '<img width="100" alt="" src="/frontend/web/img/stars/' . $model->pinField->rating . '_stars.png">';
                $data[$k]['mouseover_inforamtion'] = '<b>' . $data[$k]['title'] . '</b><br>' . $rating . '<br>' . $model->latConvert . ', ' . $model->lanConvert;
            }
            return $data;
        }
        return;
    }

    public function generateBusiness($models)
    {
        if (!empty($models)) {
            $data = [];
            foreach ($models as $k => $model) {
                $data[$k]['id'] = $model->id;
                $data[$k]['lat'] = $model->pin->lat;
                $data[$k]['lan'] = $model->pin->lan;
                $data[$k]['type'] = $model->type_id;
                $data[$k]['title'] = !empty($model->business_name) ? $model->business_name : '';
                $rating = '<img width="100" alt="" src="/frontend/web/img/stars/' . $model->rating . '_stars.png">';
                $data[$k]['mouseover_inforamtion'] = '<b>' . $data[$k]['title'] . '</b><br>' . $rating . '<br>' . $model->pin->latConvert . ', ' . $model->pin->lanConvert;
            }
            return $data;
        }
        return;
    }

    public function generateLocalInfos($models)
    {
        if (!empty($models)) {
            $data = [];
            foreach ($models as $k => $model) {
                $data[$k]['id'] = $model->id;
                $data[$k]['lat'] = $model->location_lat;
                $data[$k]['lan'] = $model->location_lng;
                $data[$k]['title'] = !empty($model->area_name) ? $model->area_name : '';
            }
            return $data;
        }
        return;
    }

    public function generateListPins($models)
    {
        if (!empty($models)) {
            $data = [];
            foreach ($models as $k => $model) {
                $data[$model->type][$k] = $model;
            }
            return $data;
        }
        return;
    }

    public function weaterDateGenerate($date)
    {
        $newDate = date("d M Y", strtotime($date));
        return $newDate;
    }

    public function convertCoordinate($dec)
    {

        $vars = explode(".", $dec);
        $deg = $vars[0];
        $tempma = "0." . $vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = $tempma - ($min * 60);
        $data = $deg . '°' . $min . '.' . round($sec);
        return $data;
    }
}
