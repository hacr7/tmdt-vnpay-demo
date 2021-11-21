<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>VNPAY RESPONSE</title>
        <!-- Bootstrap core CSS -->
        
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">         
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>
    <body>
        <?php
        require_once("./config.php");
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $vnp_PayDate = substr($_GET['vnp_PayDate'], 0 ,4);
        $date = $_GET['vnp_PayDate'];
        $vnp_PayDate = substr($date,0,4) .'-' .substr($date,3,2) .'-' .substr($date,5,2) .' ' .substr($date,7,2) .':'.substr($date,9,2) .':' .substr($date,11,2);
        ?>
        <!--Begin display -->
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">TRANSACTION RESPONSE</h3>
            </div>
            <div class="table-responsive row">
                <div class='col-sm-6'>
                    <div class="form-group">
                        <b>Mã đơn hàng: </b>
                    </div>    
                    <div class="form-group">
                        <b>Số tiền: </b>
                    </div>  
                    <div class="form-group">
                        <b>Nội dung thanh toán: </b>
                    </div> 
                    <div class="form-group">
                        <b>Mã phản hồi (vnp_ResponseCode): </b>
                    </div> 
                    <div class="form-group">
                        <b>Mã GD Tại VNPAY: </b>
                    </div> 
                    <div class="form-group">
                        <b>Mã Ngân hàng:</b>
                    </div> 
                    <div class="form-group">
                        <b>Thời gian thanh toán: </b>
                    </div> 
                    <div class="form-group">
                        <b>Kết quả: </b>
                    </div> 
                </div>
                <div class='col-sm-6'>
                    <div class="form-group">
                        <?php echo $_GET['vnp_TxnRef'] ?>
                    </div>    
                    <div class="form-group">
                        <?php echo number_format($_GET['vnp_Amount'])?>
                    </div>  
                    <div class="form-group">
                        <?php echo $_GET['vnp_OrderInfo'] ?>
                    </div> 
                    <div class="form-group">
                        <?php echo $_GET['vnp_ResponseCode'] ?>
                    </div> 
                    <div class="form-group">
                        <?php echo $_GET['vnp_TransactionNo'] ?>
                    </div> 
                    <div class="form-group">
                        <?php echo $_GET['vnp_BankCode'] ?>
                    </div> 
                    <div class="form-group">
                        <?php echo $vnp_PayDate ?>
                    </div> 
                    <div class="form-group">
                        <?php
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                echo "<span style='color:blue'>GD Thanh cong</span>";
                            } else {
                                echo "<span style='color:red'>GD Khong thanh cong</span>";
                            }
                        } else {
                            echo "<span style='color:red'>Chu ky khong hop le</span>";
                        }
                        ?>
                    </div> 
                </div>
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                   <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div>  
    </body>
</html>
