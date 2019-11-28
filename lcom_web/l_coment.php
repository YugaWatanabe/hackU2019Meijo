<?php

function refer_personal($dark, $light, $coment_point)
{

    if ($light == 0) {
        $light = 1;
    }
    $personal_point = ($dark / $light);
    $personal = 'hutu';

    if ($coment_point > 9) {

        if ($personal_point > 0.5) {
            $personal = 'waru';
            $coment = refer_waru();
        }
        if ($personal_point > 0.8) {
            $personal = 'warusugi';
            $coment = refer_warusugi();
        }
        if ($personal_point < 0.5) {
            $personal = 'yosage';
            $coment = refer_yosage();
        }
        if ($personal_point < 0.05) {
            $personal = 'tenshi';
            $coment = refer_tenshi();
        }
    }

    if ($personal == 'hutu') {
        $coment = refer_hutu();
    }

    return array($coment, $personal);
}

function refer_warusugi()
{
    $rand = rand(1, 5);

    switch ($rand) {
        case '1':
            $l_coment = 'あまり強い言葉を遣うなよ 弱く見えるぞ';
            break;
        case '2':
            $l_coment = '今月のお友達代金持ってるよな';
            break;
        case '3':
            $l_coment = '金は命よりも重い';
            break;
        case '4':
            $l_coment = '私の戦闘力は53万です';
            break;
        case '5':
            $l_coment = 'ここには正しい心は 売ってないんだよ';
            break;
    }
    return $l_coment;
}

function refer_waru()
{
    $rand = rand(1, 5);

    switch ($rand) {
        case '1':
            $l_coment = 'なんだかんだと聞かれたら、答えてあげるのが世の情け';
            break;
        case '2':
            $l_coment = '結局僕が一番強くて凄いんだよね';
            break;
        case '3':
            $l_coment = '憧れは理解からもっとも遠い感情だよ';
            break;
        case '4':
            $l_coment = 'お前のものは俺のもの、俺のものも俺のもの';
            break;
        case '5':
            $l_coment = '環境破壊は気持ち良いゾイ';
            break;
    }
    return $l_coment;
}

function refer_yosage()
{
    $rand = rand(1, 5);

    switch ($rand) {
        case '1':
            $l_coment = '人生を捧げてその道を極めた人は やはり一味違うね';
            break;
        case '2':
            $l_coment = '愛してくれて………ありがとう!!!';
            break;
        case '3':
            $l_coment = '人と同じことをするより、自分のしたいことした方が楽しいに決まってるだろ！';
            break;
        case '4':
            $l_coment = '自分の好きを貫くってしんどい時もあるでしょ？';
            break;
        case '5':
            $l_coment = '好きなことと得意なことは違うってか関係ないよね';
            break;
    }
    return $l_coment;
}

function refer_tenshi()
{
    $rand = rand(1, 5);

    switch ($rand) {
        case '1':
            $l_coment = 'あなたがこれからも 周りを輝かせる人でありますように';
            break;
        case '2':
            $l_coment = 'しんどいからこそ 乗り越えた時輝くのよね';
            break;
        case '3':
            $l_coment = '誰かの笑顔が見たくて 今の仕事を始めたんだ';
            break;
        case '4':
            $l_coment = '今日も会えてよかった！ 大好きだよ';
            break;
        case '5':
            $l_coment = '一人一人の選択が この世界を変えたんだ';
            break;
    }
    return $l_coment;
}

function refer_hutu()
{
    $rand = rand(1, 5);

    switch ($rand) {
        case '1':
            $l_coment = '今日はなにかよさそうな プロジェクトあるかな';
            break;
        case '2':
            $l_coment = '早くもおなかがすいちゃったよぉ';
            break;
        case '3':
            $l_coment = '決断するにも 労力がいるんだよね';
            break;
        case '4':
            $l_coment = 'たとえ世界が滅びても 君をわすれないよ';
            break;
        case '5':
            $l_coment = 'よく来たね！待ってたよ!さあはじめよう';
            break;
    }
    return $l_coment;
}
