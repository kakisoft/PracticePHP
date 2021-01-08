<?php

    private function getSpanList(){
        $kaiki1 = ['start_date' => '01/01', 'end_date' => '03/31'];
        $kaiki2 = ['start_date' => '04/01', 'end_date' => '06/30'];
        $kaiki3 = ['start_date' => '07/01', 'end_date' => '09/30'];
        $kaiki4 = ['start_date' => '10/01', 'end_date' => '12/31'];

        $thisYear = date('Y');
        $lastYear = $thisYear -1;
        $thisDate = date('md');


        $spanList = [];

        if($thisDate <= 331){
            $el1 = ['start_date' => $lastYear . '/' . $kaiki4['start_date'],  'end_date' => $thisYear . '/' . $kaiki4['end_date']];
            $el2 = ['start_date' => $thisYear . '/' . $kaiki1['start_date'],  'end_date' => $thisYear . '/' . $kaiki1['end_date']];
            array_push($spanList, $el1);
            array_push($spanList, $el2);

        }elseif($thisDate <= 630){
            $el1 = ['start_date' => $thisYear . '/' . $kaiki1['start_date'],  'end_date' => $thisYear . '/' . $kaiki1['end_date']];
            $el2 = ['start_date' => $thisYear . '/' . $kaiki2['start_date'],  'end_date' => $thisYear . '/' . $kaiki2['end_date']];
            array_push($spanList, $el1);
            array_push($spanList, $el2);

        }elseif($thisDate <= 930){
            $el1 = ['start_date' => $thisYear . '/' . $kaiki2['start_date'],  'end_date' => $thisYear . '/' . $kaiki2['end_date']];
            $el2 = ['start_date' => $thisYear . '/' . $kaiki3['start_date'],  'end_date' => $thisYear . '/' . $kaiki3['end_date']];
            array_push($spanList, $el1);
            array_push($spanList, $el2);

        }elseif($thisDate <= 1231){
            $el1 = ['start_date' => $thisYear . '/' . $kaiki3['start_date'],  'end_date' => $thisYear . '/' . $kaiki3['end_date']];
            $el2 = ['start_date' => $thisYear . '/' . $kaiki4['start_date'],  'end_date' => $thisYear . '/' . $kaiki4['end_date']];
            array_push($spanList, $el1);
            array_push($spanList, $el2);
        }

        return $spanList;
    }
