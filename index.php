<?php


//get order data
function  get_order (){


  //order id parameter
  $order_id = isset ($_GET['order_id'])? $_GET['order_id']: '';

  $curl = curl_init();

  curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.zid.sa/v1/managers/store/orders/".$order_id."/view",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
      "Accept: application/json",
      "Accept-Language: ",
      "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxMTciLCJqdGkiOiJhMTg5ZTg3MmYxMzhkMWVhYjU5MjVkMDkyMGE5NmI0YjliNjg0Y2E2ZTdmM2M2MjljZWYxNmQ4NDJjMmJlYmVhMjI4YTdmMTA0ZWQ4NWE5NCIsImlhdCI6MTY3OTU3Njk5OS41NjY4NzcsIm5iZiI6MTY3OTU3Njk5OS41NjY4OCwiZXhwIjoxNzExMTk5Mzk5LjQ4NjE1Mywic3ViIjoiMTgyNDc1Iiwic2NvcGVzIjpbInRoaXJkLXBhcnRpZXMtYXBpcyJdfQ.i07ef09nVNXGZF-g-QXpNoS2vlFQK_zntAqAMS4Az2XD2EyMLhxLZZRL-QlR11zUPqMmXjMAl_4ooKa3M3zkfZQ6Ga6qStvamk8RnC_39VUx0lfN2A4k65ERZpqwrMy6-t3dE99zay3aicIdNvbgi0zeuMSE5Tn99u-2AtSRa8ffbfAcYPPXacHrhdmlYzdiZS_x_skovFEow1E-nDjdL1WHqO92XdZ7RfNLkiYFTjZlZmM_UruvioaR3q6TXJbqRK_ZrziivezL8ohIQ2SBosUp58I29rlKzvlw_R2j0rKKYZbdxYDaxAHOISmOFKAlO66k7dNevAHI3s4uGIjoGA6ZXHknccWPLLLiaAQ0r64HV8GowW5dg2rhZNurJGDTnLlBQ6F-ql42ptHzSAfzzi576CEoN3gMVpgXcbntUY3reETkFsTBPUjeSuMpANMioXAA0GRp3Ut-84fTnrWxqsCW1WVUIx33HvmfCGPXIdkaCCWoA6G6KXo04MtFbKXQmXkK9esQWI-rqdVnMD3zSR3g3yFHZSL1U-mZeNja03706Rav1ordsRNOtRwtLuoRRbk9KasbUpEwqq4Ao9lqZZwRIjdEw-pQtnUT8V53fhmuuRIefCLFO7eGEtGUnh9o6Uh_pgi6AB6uSlnN9GEMGgI1alqvMmTjxvC-HHt0V-Y",
      "X-Manager-Token: eyJpdiI6IlpYcEhkQUpHeEg1OEFqMEZtQlB6REE9PSIsInZhbHVlIjoiaDNtSXBtaHc3MkRtdVlTeXFNQlZ1WElOK29LZnExbnpKRFc0VnhnbzhhRTJCS09qMDZoT2p5RW9zeVhtbktkczA4d1hRb1FQTWtvQnR5eEZBZ09nMTdrWFJIMTAxNlNUNGJ0d3Rab2U3cFpoRmNFQUxha0tibmI1d0w5Zlh1b3N6QUlCZnhSTHQ1OS9TOGhFbVFRQUtzMnVJd0hzNDZvSUc2aW9NKzNOeS90Tm1nTndSNTJBMlZjNjBDY3g4TFg2MHZQWFRuVVBjeXMxV2ZoMEZFd3VyYjVraUVFZkkyTjZRZWxFaExwR25INWt2NlNqVmxmV3JaeTJteUlBdiszbSIsIm1hYyI6ImU5YzBiNzM0MjRkZDZhMzJmNWUxMWUzY2ZlYmY1NmY0OTcxMTcxYTU2MDMxNDZhMWE1NTlhY2FjNmIwYWNlNTYiLCJ0YWciOiIifQ=="
  ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  $data = json_decode($response);
  curl_close($curl);

  if ($err) {
  echo "cURL Error #:" . $err;
  } else {
  return $data;
  }

}

$data =get_order();
//products array countian bundel offers or no
$products_array = isset ($data->order->products)? $data->order->products : '' ;


  if(isset($_GET['submit'])){

    if($data->status == 'error'){
      echo 'error';
      exit;
    }else{

      echo '<div class = "echo_text" style = "color :green">Success</div></br>';
      echo '<div class = "echo_text">';
      //check if has coupon
      if(isset($data->order->coupon)){
        echo 'لقد استخدمت'.$data->order->coupon->code.'</br>';
        echo 'تم خصم مبلغ'.$data->order->coupon->discount_string.'من إجمالي فاتورتك'.'</br>';
        echo ' العروض التي تستخدمها  :  ';
        echo isset ($products_array[count($products_array)-1]->meta->bundle_offer)? $products_array[count($products_array)-1]->meta->bundle_offer->name.'</br>' :'لا يوجد عروض</br>';
          if($data->order->payment->invoice[4]->value == "0.00000000000000"){
            echo 'لا يخضع طلبك للضريبة';
    
          }else{
            echo 'فاتورتك تشمل ضرائب بقيمة'.$data->order->payment->invoice[4]->value_string.'</br>';
          }
      //check if last product in bundle off
      }elseif(count($products_array) >= 1 && isset ($products_array[count($products_array)-1]->meta->bundle_offer)){
        echo ' العروض التي تستخدمها  :  ';
        echo isset ($products_array[count($products_array)-1]->meta->bundle_offer)? $products_array[count($products_array)-1]->meta->bundle_offer->name.'</br>' :'لا يوجد عروض</br>';

          if($data->order->payment->invoice[4]->value == "0.00000000000000"){
            echo 'لا يخضع طلبك للضريبة'.'</br>';

          }else{
            echo 'فاتورتك تشمل ضرائب بقيمة'. $data->order->payment->invoice[4]->value_string.'</br>';
          }
          //check if one product only
      }elseif(!isset ($products_array[count($products_array)-1]->meta->bundle_offer)){

        echo ' العروض التي تستخدمها  :  ';
        echo isset ($products_array[count($products_array)-1]->meta->bundle_offer)? $products_array[count($products_array)-1]->meta->bundle_offer->name.'</br>' :'لا يوجد عروض</br>';

          if($data->order->payment->invoice[2]->value == "0.00000000000000"){
            echo 'لا يخضع طلبك للضريبة'.'</br>';

          }else{
            echo 'فاتورتك تشمل ضرائب بقيمة'. $data->order->payment->invoice[2]->value_string.'</br>';
          }

      }
      echo '</div>';
    }

 
  }




?>

<!DOCTYPE html>
  <html lang="ar">
  <head>

      <title>Get Order</title>
        <style>


    body {
              direction: rtl;
          }

    .echo_text {
      text-align: center;
      font-size: 20px;
      margin-top: 20px;
      color :green"
    }
    
    .form-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f2f2f2;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-group input[type="text"] {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .form-group button[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 3px;
      cursor: pointer;
    }

    .form-group button[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
  </head>
  <body>
    

      <div class="form-container">
          <h2>احصل على تفاصيل الطلب</h2>
          <form  method="GET">
              <div class="form-group">
              <label for="order_id">رقم الطلب:</label>
              <input type="text" name="order_id" id="order_id" required>
              </div>
              <div class="form-group">
              <button type="submit" name="submit">احصل على التفاصيل</button>
              </div>
          </form>
      </div>

  </body>
</html>
