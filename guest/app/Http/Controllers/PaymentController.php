<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use App\Models\Order;
use Mail;
use Auth;
class PaymentController extends Controller
{
    public function handleVNPayReturn(Request $request,Order $order)
    {
        // Xử lý kết quả trả về từ VNPay
        $orderId = $request->input('vnp_TxnRef');
        $order = Order::find($orderId);

        if ($order && $request->input('vnp_Amount') == $order->total_amount * 100) {
            $order->status = 'paid';
            $order->save();

           
            // Gửi email thông báo
            $user = $order->user;
            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order,$user));

            return redirect()->route('order.success', ['order' => $orderId]);
        }

        return redirect()->route('home')->withErrors('Thanh toán không thành công.');
    }
    public function vnpay($orderId){
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.return', ['orderId' => $orderId]);
        $vnp_TmnCode = "7FYHUXQ1";//Mã website tại VNPAY 
        $vnp_HashSecret = "2V3354QDTMCL8JDIOI8T0648OYLWL66X"; //Chuỗi bí mật
        
        $order = Order::findOrFail($orderId);
        $vnp_TxnRef = $orderId; 
        $totalAmount = $order->total_amount; // Tổng giá trị đơn hàng

        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = 'H Store';
        $vnp_Amount = $totalAmount * 100;
        $vnp_Locale = 'VN';
        // $vnp_BankCode = "VNPAYQR";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
      
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,

        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = "2V3354QDTMCL8JDIOI8T0648OYLWL66X"; //Chuỗi bí mật từ cấu hình VNPay

        // Lấy tất cả các tham số từ request
        $inputData = $request->all();

        // Lấy mã giao dịch từ VNPay
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        // Kiểm tra hash dữ liệu
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Kiểm tra mã giao dịch hợp lệ
        if ($secureHash === $vnp_SecureHash) {
            $order = Order::find($inputData['vnp_TxnRef']);

            if ($order) {
                // Kiểm tra mã code phản hồi từ VNPay
                if ($inputData['vnp_ResponseCode'] == '00') {
                    // Nếu giao dịch thành công, cập nhật trạng thái đơn hàng
                    $order->status = 'paid';
                    $order->save();
                    
                    // Điều hướng về trang thành công
                    return redirect()->route('order.success', ['order' => $order->id])->with('message', 'Thanh toán thành công!');
                } else {
                    // Giao dịch thất bại
                    return redirect()->route('orders.show', ['order' => $order->id])->with('error', 'Thanh toán thất bại!');
                }
            }
        } else {
            return redirect()->route('orders.index')->with('error', 'Giao dịch không hợp lệ!');
        }
    }

}
