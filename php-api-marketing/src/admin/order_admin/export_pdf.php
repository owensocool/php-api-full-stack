<?php
// Include autoloader
require_once __DIR__ . '/../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Create a Dompdf instance
$options = new Options();
$options->set('isFontSubsettingEnabled', true);
$options->set('enable_cjk_language_support', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

require_once ('../../../config/db/connection.php');
require_once '../../customer/order/order_operator.php';
$order_id = isset($_GET['order']) ? $_GET['order'] : '';
$orders = orderDetail($order_id);

// Load HTML content
$html = <<<HTML
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>Beluga Phone Phone Shop</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew001';
            font-style: normal;
            font-weight: normal;
            src: url("http://localhost/fullStack/php-api-full-stack/php-api-marketing/public/storage/fonts/THSarabunNew001.ttf") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew001-bold';
            font-style: bold;
            font-weight: bold;
            src: url("http://localhost/fullStack/php-api-full-stack/php-api-marketing/public/storage/fonts/THSarabunNew-Bold001.ttf") format('truetype');
        }
        body {
            font-family: 'THSarabunNew001', 'THSarabunNew001-bold';
            margin: 0;
        }
    </style>
</head>
<body>
<div>    
HTML;

if (!empty($orders)) {
    foreach ($orders as $row1) {
        $html .= "<table border='0' style='width:95%; border-collapse: collapse; margin: auto;'>
                            <tr>
                                <th width='50%;' style='text-align:left;'><h1>ใบรายการการสั่งซื้อ</h1></th>
                           
                                <th width='21%;'>
                                    <div style='text-align:center;'>
                                        <a style='font-size:20px;'>Beluga Group (th) Co.,ltd <hr/></a>
                                        <a style='font-weight:normal;font-size:16px;'>888, ถนนประชาสำราญ เขตหนองจอก กรุงเทพมหานคร โทร 02-888-8888</a>
                                    </div>
                                </th>
                            </tr>
                    </table>
                            <table border='0' style='width: 95%; border-collapse: collapse; margin: auto; padding-top: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                                <tr style='background-color: #0A2647; color: white; text-align: center;'>
                                    <th width='100px;'></th>
                                </tr>
                            </table>
                    <table border='0' style='width:95%; border-collapse: collapse; margin: auto;'>
                             <tr>
                                <th width='50%;' style='text-align:left; font-size:17px;'>
                                    <a style='padding-left:20px;'>ชื่อผู้สั่ง : &nbsp;&nbsp; <a style='padding-left:10px; font-weight:normal;'>{$row1['name_order']} </a><br></a>
                                    <a style='padding-left:20px;'>ชื่อผู้รับ : &nbsp;&nbsp; <a style='padding-left:10px; font-weight:normal;'>{$row1['name_receive']} </a><br></a>
                                    <a style='padding-left:20px;'>ชื่อผู้ส่ง : &nbsp;&nbsp; <a style='padding-left:10px; font-weight:normal;'>{$row1['name_bill']} </a><br></a>
                                    <a style='padding-left:20px;'>หมายเลขกำกับภาษี : <a style='padding-left:10px; font-weight:normal;'>{$row1['tax_no']} </a><br></a>
                                    <a style='padding-left:20px;'>ที่อยู่จัดส่ง :&nbsp;&nbsp; <a style=' padding-left:10px; font-weight:normal;'>{$row1['address']} </a><br></a>
                                    <a style='padding-left:20px;'>หมายเลขโทรศัพท์ : &nbsp;&nbsp;<a style='padding-left:10px; font-weight:normal;'>{$row1['tel']} </a><br></a>
                                </th>

                                <th width='21%;' style='padding-right:20px; text-align:right; font-size:17px;'>
                                <br/><br/><br/><br/>
                                    <a>วันที่สั่ง : <a style='font-weight:normal;'>{$row1['order_date']}</a><br></a>
                                    <a>วันที่ส่ง : <a style='font-weight:normal;'>{$row1['shipping_date']}</a><br></a>
                                    <a>วันที่รับ : <a style='font-weight:normal;'>{$row1['receive_date']}</a><br></a>
                                </th>
                            </tr>
                        </table>

                        <hr width='95%;' />

                        <table border='0' style='width: 95%; margin: auto; font-size:17px;'>
                            <tr>
                                <th width='60%;' style='text-align:left;'><a style='font-weight: bold;'>รายการที่สั่งซื้อ</a></th>
                                <th width='8%;' style='text-align:center;'><a style='font-weight: bold;'>จำนวน</a></th>
                                <th width='13%;' style='text-align:center;'><a style='font-weight: bold;'>ราคาต่อหน่วย</a></th>
                                <th width='10%;' style='text-align:center;'><a style='font-weight: bold;'>ราคารวม</a></th>
                            </tr>";

        $sql = "SELECT d.id, d.order_id, d.amount, d.total_price,p.product_name, p.product_price
                                FROM detail d
                                INNER JOIN products p ON d.product_id = p.product_id
                                WHERE d.order_id = ?
                                ORDER BY d.id
                                ";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error in SQL query preparation: " . $conn->error);
        }

        $stmt->bind_param("s", $order_id);
        // Execute the statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $line = 0;

            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name1 = $row['product_name'];
                $name2 = $row['amount'];
                $name3 = $row['product_price'];
                $name4 = $row['total_price'];
                $line++;

                $html .= "<tr>
                                            <th width='60%;' style='padding: 2px; text-align:left;'><a style='font-weight: normal;'>$line . $name1</a></th>
                                            <th width='8%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal;'>$name2</a></th> 
                                            <th width='13%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal;'>$name3</a></th>
                                            <th width='10%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal; '>$name4</a></th>
                                        </tr>";
            }
            $stmt->close();
        } else {
            die("Error executing SQL query: " . $stmt->error);
        }

        $html .= "<tr>
                                            <th width='60%;' style='padding: 2px; text-align:left;'><a style='font-weight: normal;'>vat</a></th>
                                            <th width='8%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal;'></a></th> 
                                            <th width='13%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal;'></a></th>
                                            <th width='10%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal; '>7%</a></th>
                                        </tr>";
        $html .= "<tr>
                                            <th width='60%;' style='padding: 2px; text-align:left;'><a style='font-weight: normal;'>shipping cost</a></th>
                                            <th width='8%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal;'></a></th> 
                                            <th width='13%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal;'></a></th>
                                            <th width='10%;' style='padding: 2px; text-align:center;'><a style='font-weight:normal; '>{$row1['shipping_cost']}</a></th>
                                        </tr>";
        $html .= "</table>";

        $html .= "<table border='0' style='width :95%; border-collapse: collapse; margin: auto; font-size:17px;'>
                        <tr>
                            <th width='60%;' style='padding: 2px; text-align:left; '>จำนวนรวมทั้งสิ้น</th>
                            <th width='20%;' style='padding: 10px; text-align:center; font-weight: normal;'>{$row1['amount']} รายการ</th>
                            <th width='20%;' style='padding: 10px; text-align:right; font-weight: normal;'>{$row1['total_price']} บาท</th>
                        </tr>
                    </table>";
    }
}

$html .= " </div> </body>
</html>";

// Load HTML into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (output)
$dompdf->render();

// Output PDF as attachment or inline
$dompdf->stream("order_details.pdf", array("Attachment" => false));
?>
