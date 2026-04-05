<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Payment</title>
</head>

<body>
    <form action="">
        <h1>BILL PAYMENT</h1>
        <fieldset>
            <legend>BILL PAYMENT</legend>
            <div>
                <label for="date">DATE</label><input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                <label for="time">TIME</label><input type="time" id="time" name="time" value="<?php echo date('H:i'); ?>"><br />
            </div>


            <div>
                <input type="radio" id="bio" name="category"><label for="bio">BiO</label>
                <input type="radio" id="non_bio" name="category"><label for="non_bio">DIGITAL PAYMENT</label>
                <input type="radio" id="qr" name="category"><label for="qr">QR</label>
                <input type="radio" id="other" name="category"><label for="other">OTHER</label><br />

            </div>


            <div>

                <label for="customer_company_category">ENTER COMPANY CATEGORY</label><br />
                <input type="text" id="customer_company_category" name="customer_company_category" placeholder="COMPANY CATEGORY" maxlength="24"><br />
                <label for="customer_company_title">ENTER COMPANY TITLE</label><br />
                <input type="text" id="customer_company_title" name="customer_company_title" placeholder="COMPANY TITLE" maxlength="24"><br />

                <label for="customer_consumer_number">ENTER CONSUMER NUMBER</label><br />
                <input type="number" id="customer_consumer_number" name="customer_consumer_number" placeholder="CONSUMER NUMBER" maxlength="24"><br />
                <label for="mobile">ENTER MOBILE NUMBER</label><br />
                <input type="number" id="mobile" name="mobile" placeholder="MOBILE NUMBER" maxlength="11">

                <label for="bill_amount">BILL AMOUNT</label>
                <input type="number" id="bill_amount" name="bill_amount" placeholder="BILL AMOUNT">
                <br />
                <label for="charges_crieteria">CHARGES CRIETERIA</label>
                <input type="radio" name="charges" id="get_from_customer"><label for="get_from_customer">GET FROM CUSTOMER</label><br />
                <label for="charges">CHARGES</label>
                <input type="number" name="charges_percentage" id="charges_percentage">
                <input type="number" name="charges_in_rupees" id="charges_in_rupees"><br />
                <label for="discount">DISCOUNT</label>
                <input type="number" name="discount_percentage" id="discount_percentage">
                <input type="number" name="discount_in_rupees" id="discount_in_rupees"><br />
                <label for="receive_cash_from_customer">RECEIVE CASH FROM CUSTOMER</label>
                <input type="number" name="receive_cash_from_customer" id="receive_cash_from_customer">

            </div>
            <div>
                <input type="radio" id="cash" name="criteria"><label for="cash">CASH</label>
                <input type="radio" id="credit" name="criteria"><label for="credit">CREDIT</label>
                <label for="phonenumber">PHONE NUMBER</label><input type="tel" id="phonenumber" name="phonenumber">
                <label for="name">NAME</label><input type="text" id="name" name="name"><br /><br />
                <input type="number" style="width: 50px;" value="5000" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="1000" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="500" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="100" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="75" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="50" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="20" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="10" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="5" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="2" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <input type="number" style="width: 50px;" value="1" name="" id="" readonly><span>X</span><input type="number" style="width: 50px;" name="" id="" min="1"><span>=</span><input type="number" name="" id="" readonly><br />
                <label for="total_cash_received">TOTAL CASH RECEIVED</label><input type="number" name="total_cash_received" id="total_cash_received" readonly><br />
                <label for="balance">RETURN/GET/BALANCED</label><input type="number" name="balance" id="balance" readonly><br />
                <label for="deposit_amount">BILL AMOUNT</label><input type="number" name="deposit_amount" id="deposit_amount" readonly><br />


            </div>

        </fieldset>
    </form>
</body>

</html>