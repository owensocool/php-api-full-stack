<?php
    $fs = fopen("../model/counter.inc", "r");
    $count = fgets($fs, 255);
    fclose($fs);
    $count++;
    
    $label = isset($_POST['label']) ? $_POST['label'] : '';
    $detail = isset($_POST['detail']) ? $_POST['detail'] : '';
    $poster = isset($_POST['poster']) ? $_POST['poster'] : '';

    $filename = "../model/board" . $count . ".txt";
    // Write data to the file
    $fs = fopen($filename, "a");
    fputs($fs, "label: $label" . PHP_EOL);
    fputs($fs, "detail: $detail" . PHP_EOL);
    fputs($fs, "date: " . date("Y-M-d") . PHP_EOL);
    fputs($fs, "poster: $poster" . PHP_EOL);
    fputs($fs, "viewer: 0" . PHP_EOL);
    fputs($fs, "comment_all: 0 ");
    fclose($fs);

    $filename1 = "../model/all_board.txt";
    $fs = fopen($filename1, "a");
    fputs($fs, "board_id: $count" . PHP_EOL);
    fputs($fs, "label: $label" . PHP_EOL);
    fputs($fs, "date: " . date("Y-M-d") . PHP_EOL);
    fputs($fs, "poster: $poster <br>" . PHP_EOL);
    fclose($fs);

    $fs = fopen("../model/counter.inc", "w");
    fputs($fs, $count);
    fclose($fs);

    header("Location: ../view/board.php?board_id=$count");
    exit;
?>
