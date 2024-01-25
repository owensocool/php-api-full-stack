<!DOCTYPE html>
<html lang="th">
  <head>
    <meta charset="UTF-8" />
    <title>Boxthip</title>
  </head>
  <body bgcolor="#ECE3CE" text="#000000">
    <div>
      <br />
      <center>
        <h1>เว็บไซต์กระทู้ที่ดีที่สุด Boxthip</h1>
        <br />
        <hr />
        <br /> 
        <table border="0">
                <tr>
                    <td width="950px"></td>
                    <td width="200px"><a style="font:bold;">เพิ่มความสงสัยในตัวคุณ ->></a></td>
                    <td width="150px"> <a href="./view/addboard.html"><button type="button" style="background-color: #756AB6; color: white; padding: 10px; border: none; border-radius: 5px;  cursor: pointer;">+ สร้างกระทู้ใหม่</button></a></td>
                </tr>
        </table>
        <br />
        <table border="1" style="width: 1200px; border-collapse: collapse; margin: auto;">
                <tr style="background-color: #AC87C5; color: white; text-align: center;">
                    <td width="50px" style="padding: 10px;"> ลำดับ</td>
                    <td width="750px" style="padding: 10px;">กระทู้ใหม่</td>
                    <td width="200px" style="padding: 10px;">วันที่สร้าง</td>
                    <td width="250px" style="padding: 10px;">ชื่อผู้โพสต์</td>
                </tr>
                <tr>
                    <?php
                    $filePaths = glob("./model/all_board.txt");
                    $currentBoardId = null;
                    $rowNumber = 1;

                    foreach ($filePaths as $filePath) {
                        $fs = fopen($filePath, "r");
                        while (!feof($fs)) {
                            $line = fgets($fs);
                            $parts = explode(':', $line, 2);
                            if (count($parts) === 2) {
                                $key = trim($parts[0]);
                                $value = trim($parts[1]);
                                
                                if ($key === 'board_id') {
                                    // If the board_id changes, start a new row
                                    if ($value != $currentBoardId) {
                                        if ($currentBoardId !== null) {
                                            echo "</tr>";
                                            $rowNumber++;
                                        }
                                       echo "<tr onclick=\"window.location.href='view/board.php?board_id=$value';\" onmouseover=\"this.style.backgroundColor='#E5E1DA'\" onmouseout=\"this.style.backgroundColor=''\">";
                                        $currentBoardId = $value;
                                    }
                                }
                                // Display the content in the table
                                echo "<td style='padding: 10px; cursor: pointer;'>$value</td>";
                            }
                        }
                        fclose($fs);
                    }
                    // Close the last row if needed
                    if ($currentBoardId !== null) {
                        echo "</tr>";
                    }
                ?>
                </tr>
            </table>
      </center>
    </div>
  </body>
</html>