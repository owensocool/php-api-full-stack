<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Boxthip</title>
    <style>
        body {
            background-color: #ECE3CE;
            color: #000000;
        }

        div {
            margin: auto;
            width: 80%;
        }

        hr {
            border: 1px solid #86B6F6;
        }

        .board-content {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #EEF5FF;
        }

        .line-content {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div>
        <br />
        <center><h1>เว็บไซต์กระทู้ที่ดีที่สุด Boxthip</h1>
        <a href="../index.php">กลับหน้าหลัก</a>
        </center>
        <hr />
        <br /> 
        <br /> 
        <div class="board-content">
            <?php
                $id = $_GET['board_id'];
                $filename = "../model/board" . $id . ".txt";
                
                $content = file_get_contents($filename);
                // preg_match_all('/viewer\s*:\s*(\d+)/i', $content, $matches);
                // $currentViewerCount = isset($matches[1][0]) ? intval($matches[1][0]) : 0;
                // echo "<a style='margin-left: 750px;'>จำนวนผู้เข้าชม : $currentViewerCount </a>";
                // $newViewerCount = $currentViewerCount + 1;
                // $updatedContent = preg_replace('/viewer\s*:\s*\d+/i', 'viewer : ' . $newViewerCount, $content);
                // file_put_contents($filename, $updatedContent);
  
                $fs = fopen($filename, "r");
                $lineCount = 0;
                while (!feof($fs)) {
                    $line = fgets($fs);
                    $parts = explode(':', $line, 2);
                    
                    if (count($parts) === 2) {
                        $contentAfterColon = trim($parts[1]);

                        if ($lineCount === 0) {
                            echo "<a class='line-content'><h1>$contentAfterColon</h1></a>";
                        }
                        if ($lineCount === 1) {
                            echo "<p style='font-weight: bold;'>รายละเอียด</p>";
                            echo "<p class='line-content' style='margin-left: 20px;' >$contentAfterColon</p><br><hr>";
                        }
                        if ($lineCount === 2) {
                            echo "<p class='line-content'>วันที่สร้าง   : $contentAfterColon</p>";
                        } 
                        if ($lineCount === 3) {
                            echo "<p class='line-content'>ชื่อผู้โพสต์ : $contentAfterColon</p>";
                        }
                        $lineCount++;
                    }
                }
                fclose($fs);
            ?>
        </div>
        <br/>
        <?php
            $id = $_GET['board_id'];
            $filename = "../model/board" . $id . ".txt";
            $content = file_get_contents($filename);
            preg_match('/comment_all\s*:\s*(\d+)/i', $content, $matches);
            $currentCommentCount = isset($matches[1]) ? intval($matches[1]) : 0;
            echo "<h2 style='margin-left: 80px;'>แสดงความคิดเห็น ($currentCommentCount)</h2>";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
                $mention = isset($_POST['mention']) ? $_POST['mention'] : '';
                if ($comment !== '' && $mention !== '') {    
                    $newCommentCount = $currentCommentCount + 1;
                    $updatedContent = preg_replace('/comment_all\s*:\s*\d+/i', 'comment_all : ' . $newCommentCount, $content);
            
                    file_put_contents($filename, $updatedContent);

                    $fs = fopen($filename, "a");
                    fputs($fs, "comment_id: $newCommentCount " . PHP_EOL);
                    fputs($fs, "comment: $comment" . PHP_EOL);
                    fputs($fs, "mention: $mention" . PHP_EOL);
                    fclose($fs);

                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;
                }
            }
            ?>

         <div class="board-content">
            <?php
                $id = $_GET['board_id'];
                $filename = "../model/board" . $id . ".txt";
                $content = file_get_contents($filename);
                $comment_match = preg_match_all('/comment:\s*(.+)/i', $content, $comment_matches);
                $mention_match = preg_match_all('/mention:\s*(.+)/i', $content, $mention_matches);

                if ($comment_match && $mention_match) {
                    for ($i = 0; $i < count($comment_matches[1]); $i++) {
                        $comment = $comment_matches[1][$i];
                        $mention = $mention_matches[1][$i];
                            echo "<p style='font-weight: bold;'>Comment:</p>";
                           
                            echo "<p style='margin-left: 20px;'>$comment</p>";
                            echo "<p style='margin-left: 20px;'>ผู้แสดงความคิดเห็น : $mention</p>";
                            echo "<hr />";
                    }
                } 
                else {
                    echo "No comments found.";
                }
            ?>
        </div>
        <br />
        <form method="post" action="board.php?board_id=<?= $id ?>" style="width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #E3DFFD;">
            <label for="comment">ความคิดเห็น:</label>
            <input type="text" id="comment" name="comment" style="width: 100%; margin-bottom: 10px;" required>
            <label for="mention">ชื่อผู้โพสต์:</label>
            <input type="text" id="mention" name="mention" style="width: 100%; margin-bottom: 10px;" required>
            <input type="hidden" name="board_id" value="<?= $id ?>">
            <button type="submit" style="background-color: #756AB6; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">บันทึก</button>
        </form>
    </div>
</body>
</html>
