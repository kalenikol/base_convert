<?php
include 'inc/config.inc.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//    echo $_SERVER['REQUEST_METHOD'];
    $oldName = $_POST['name_1'];
//    echo $oldName;
    $oldCode = $_POST['code_1'];
    $newName = $_POST['name_2'];
    $newCode = $_POST['code_2'];
    if(!$_POST['enabled']){
        $enabled = "n";
    } else {
        $enabled = "y";
    }
    $e_link = $_POST['e_link'];
    $sql = "INSERT INTO goods (name_1, code_1, name_2, code_2, enabled, link) VALUES ('$oldName', '$oldCode', '$newName', '$newCode', '$enabled', '$e_link');";
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    ?>
        <a href="index.php">Домой</a>
    <?php
    exit();
}
?>
<!--TODO проверка полей на заполненность-->
    <form  method='POST' action="<?php $_SERVER['REQUEST_URI'] ?>">
        <label for="label_name_1">Имя в базе 1С</label>
        <input type="text" name="name_1" id="label_name_1">
        <label for="label_code_1">Артикул в базе 1С</label>
        <input type="text" name="code_1" id="label_code_1"><br>
        <label for="label_name_2">Имя в выгруке</label>
        <input type="text" name="name_2" id="label_name_2">
        <label for="label_code_2">Артикул в выгрузке</label>
        <input type="text" name="code_2" id="label_code_2"><br>
        <label for="label_enabled">Выгружать?</label>
        <input type="checkbox" checked name="enabled" value="enabled" id="label_enabled"><br>
        <label for="label_link">Ссылка в ешопе</label>
        <input type="text" name="e_link" id="label_link"><br>
        <input type="submit" name="submit" value="go!">
    </form>