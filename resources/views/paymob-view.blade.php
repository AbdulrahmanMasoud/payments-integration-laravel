<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="GET" action="" id="paymob_checkout">
        <label for="">Card number</label>
          <input type="text" value="4987654321098769" paymob_field="card_number">
          <br>
          <label for="">Card holdername</label>
          <input type="text" value="Test Account" paymob_field="card_holdername">
          <br>
          <label for="">Card month</label>
          <input type="text" value="05" paymob_field="card_expiry_mm">
          <br>
          <label for="">Card year</label>
          <input type="text" value="21" paymob_field="card_expiry_yy">
          <br>
          <label for="">Card cvn</label>
          <input type="text" value="123" paymob_field="card_cvn">
          <input type="hidden" value="CARD" paymob_field="subtype">
          <input type="checkbox" value="tokenize" name="save card"> <label for="save card">save card</label>
    
          <input type="submit" value="Pay">
          <br>
    </form>
    <iframe src="https://accept.paymobsolutions.com/api/acceptance/iframes/{{'lkjlkj'}}?payment_token={{$token}}"></iframe>

</body>
</html>