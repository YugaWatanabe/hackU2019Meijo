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
        }

    return $prefacture;
}
?>
