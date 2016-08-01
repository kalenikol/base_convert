<pre>
<?php
include 'inc/config.inc.php';
function isExist($name, $code) {
    $link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM items.goods WHERE goods.name_1 = '{$name}' AND goods.code_1 = '{$code}';";
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

$new_out = [];
$csv = array_map('str_getcsv', file('310716b.csv'));
foreach ($csv as $item) {
    $array_item = explode(";", $item[0]);
    $new_out[] = $array_item;
}

//var_dump($new_out);
$outer_array = [];
foreach ($new_out as $line){
    if($row = isExist($line[0], $line[1])){
        if($row['enabled'] == 'n') {
            continue;
        }
        $out_array = [];
        $line[0] = $row['name_2'];
        $line[1] = $row['code_2'];
        $out_array[] = $row['name_2']; //Наименование
        $out_array[] = $row['code_2']; //Наименование артикула
        $out_array[] = null; //Код артикула
        $out_array[] = (int)$line[2];//В наличии @ Интернациональная
        $out_array[] = (int)$line[6];//В наличии @Акрополь
        $out_array[] = (int)$line[5];//В наличии @Лен8
        $out_array[] = (int)((int)$line[4] + (int)$line[7]);//В наличии @Ротко
        $out_array[] = (int)$line[3];
        $out_array[] = $row['category'];
        $out_array[] = $row['link'];
        $out_array[] = $row['code_2'];
//        var_dump($line);
        $outer_array[] = $out_array;
        echo "cool!";
    } else {
        echo "shit!";
        break;

    }
}
var_dump($outer_array);

$new_out_length =  count($outer_array);
$current_item = '';
$current_color = [];
$newest_out = [];
for ($i = 0; $i < $new_out_length; $i++) {
    $current_item = $outer_array[$i][0];
    $current_color[] = $outer_array[$i][1];
    $newest_out[] = $outer_array[$i];
    if ($outer_array[$i][0] != $outer_array[$i + 1][0]) {
        $string = implode(',', $current_color);
        $na = [];
        $na[] = $outer_array[$i][0];
        $na[] = null;
        $na[] = null;
        $na[] = null;
        $na[] = null;
        $na[] = null;
        $na[] = null;
        $na[] = null;
        $na[] = $outer_array[$i][8];
        $na[] = $outer_array[$i][9];
        $na[] = "<{{$string}}>";
        $newest_out[] = $na;
//        $newest_out[] = "{$new_out[$i][0]};;;<{$string}>";
        $current_color = [];
    }

}

$newest_out = array_reverse($newest_out);
$first_line = ['Наименование', 'Наименование артикула', 'Код артикула', 'В наличии @ Интернациональная', 'В наличии @Акрополь', 'В наличии @Лен8', 'В наличии @Ротко', 'В наличии @Лен33', 'Тип товаров', 'Ссылка на витрину', 'Возможные цвета'];

$fp = fopen('test_out.csv', 'w');
fputcsv($fp, $first_line, ";");
foreach ($newest_out as $fields){
    fputcsv($fp, $fields, ';');
}
fclose($fp);

