<style>
    .green {
        color: green;
    }
    .red {
        color: red;
    }
</style>
<?php
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'items');


//проверка наличия данной позиции в базе
function isExist($name, $code) {
    $link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM items.goods WHERE goods.name_1 = '{$name}' AND goods.code_1 = '{$code}';";
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $row = mysqli_fetch_assoc($result);
    return $row;
}


if(($handle = fopen('310716.csv', 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ";")) !== false) {
        if(isExist($data[0], $data[1])) {
            echo "<p class='green'>{$data[0]} : {$data[1]} - OK</p>";
        } else {
            echo "<p class='red'>{$data[0]} : {$data[1]} - FALSE</p>";;
        }
//        echo (isExist($data[0], $data[1]));
    }
}
