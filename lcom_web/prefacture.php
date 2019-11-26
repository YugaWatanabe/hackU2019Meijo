<?php

function refer_prefecture($place_id){

    switch ($place_id) {
        case '1':
          $prefacture = '東京都';
          break;
        case '2':
          $prefacture = '神奈川県';
          break;
        case '3':
          $prefacture = '大阪府';
          break;
        case '4':
          $prefacture = '愛知県';
          break;
        case '8':
          $prefacture = '北海道';
          break;
        case '9':
          $prefacture = '福岡県';
          break;
        case '14':
          $prefacture = '宮城県';
          break;
        case '20':
          $prefacture = '岡山県';
          break;
        case '25':
          $prefacture = '沖縄県';
          break;
        case '28':
          $prefacture = '愛媛県';
          break;
        }
  

    return $prefacture;
}
