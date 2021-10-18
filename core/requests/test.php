<?php

class test
{

    public static function index()
    {
        if (API_TEST_ALLOWED === true) {
            $api_result = array(
                "_code" => '200',
                "result" => 'Test ready to launch'
            );

            return $api_result;
        }else{
            $api_result = array(
                "_code" => '401',
                "result" => 'Test not allowed'
            );

            return $api_result;
        }

        // $api_result = array(
        //     "_code"=> '200',
        //     "result"=> 'test done'
        // );

        // return $api_result;
    }


    public static function launch()
    {
        if (API_TEST_ALLOWED === true) {
            $api_result = array(
                "_code" => '200',
                "result" => 'Test yyutyutyutyutyuty'
            );

            return $api_result;
        }else{
            $api_result = array(
                "_code" => '401',
                "result" => 'Test not allowed'
            );

            return $api_result;
        }

        // $api_result = array(
        //     "_code"=> '200',
        //     "result"=> 'test done'
        // );

        // return $api_result;
    }
}
