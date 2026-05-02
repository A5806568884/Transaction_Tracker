<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
</head>

<body>
    <form action="">
        <h1>DEPOSIT</h1>
        <fieldset>
            <legend>DEPOSIT</legend>

            <div>
                <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                <input type="time" id="time" name="time" value="<?php echo date('H:i'); ?>">
            </div>
            <div> <input type="radio" id="cash" name="criteria"><label for="cash">CASH</label>
                <input type="radio" id="credit" name="criteria"><label for="credit">CREDIT</label>
                <label for="phonenumber">PHONE NUMBER</label><input type="tel" id="phonenumber" name="phonenumber">
                <label for="name">NAME</label><input type="text" id="name" name="name" autocomplete="off"><br />
                <div>
                    <input type="radio" id="bio" name="category"><label for="bio">BiO</label>
                    <input type="radio" id="non_bio" name="category"><label for="non_bio">DIGITAL PAYMENT</label>
                    <input type="radio" id="qr" name="category"><label for="qr">QR</label>
                    <input type="radio" id="other" name="category"><label for="other">OTHER</label><br />
                    <label for="cnic">ENTER CNIC NUMBER</label>
                    <input type="number" id="cnic" name="cnic" placeholder="CNIC NUMBER" maxlength="13"><br />
                    <label for="mobile">ENTER MOBILE NUMBER</label>
                    <input type="number" id="mobile" name="mobile" placeholder="MOBILE NUMBER" maxlength="11">
                </div>
                <div>
                    <label for="account_id">ACCOUNT ID</label>
                    <input type="number" id="account_id" name="account_id" placeholder="ACCOUNT ID"><br />
                    <label for="bank_name">BANK NAME</label>
                    <input type="text" id="bank_name" name="bank_name" placeholder="BANK NAME"><br />
                    <label for="account_number">ACCOUNT NUMBER</label>
                    <input type="number" id="account_number" name="account_number" placeholder="ACCOUNT NUMBER"><br />
                    <label for="account_title">ACCOUNT TITLE</label>
                    <input type="text" id="account_title" name="account_title" placeholder="ACCOUNT TITLE"><br />
                </div>
                <div>
                    <label for="customer_requirement">CUSTOMER REQUIREMENT</label>
                    <select id="customer_requirement" name="bank">
                        <option value="easy_paise">EASY PAISA</option>
                        <option value="jazz_cash">JAZZ CASH</option>
                        <option value="hbl_konnect">HBL KONNECT</option>
                    </select><br />
                </div>


                <div>

                    <label for="customer_account_number">ENTER ACCOUNT NUMBER</label>
                    <input type="number" id="customer_account_number" name="customer_account_number" placeholder="ACCOUNT NUMBER" maxlength="24"><br />
                    <label for="customer_account_title">ENTER ACCOUNT TITLE</label>
                    <input type="text" id="customer_account_title" name="customer_account_title" placeholder="ACCOUNT TITLE" maxlength="24"><br />
                    <label for="requestedamount">REQUESTED AMOUNT</label>
                    <input type="number" id="requestedamount" name="requestedamount" placeholder="REQUESTED AMOUNT"><br />
                    <label for="deducted_from_amount">CHARGES CRIETERIA</label>
                    <input type="radio" name="charges" id="deducted_from_amount"><label for="deducted_from_amount">DEDUCTED FROM AMOUNT</label>
                    <input type="radio" name="charges" id="get_from_customer"><label for="get_from_customer">GET FROM CUSTOMER</label><br />
                    <label for="charges_percentage">CHARGES</label>
                    <input type="number" name="charges_percentage" id="charges_percentage">
                    <input type="number" name="charges_in_rupees" id="charges_in_rupees"><br />
                    <label for="discount_percentage">DISCOUNT</label>
                    <input type="number" name="discount_percentage" id="discount_percentage">
                    <input type="number" name="discount_in_rupees" id="discount_in_rupees"><br />
                    <label for="receive_cash_from_customer">RECEIVE CASH FROM CUSTOMER</label>
                    <input type="number" name="receive_cash_from_customer" id="receive_cash_from_customer">

                </div>
                <div>
                    <input type="number" style="width: 50px;" value="5000" name="d_5000" id="d_5000"><span>X</span><input type="number" style="width: 50px;" name="collected_5000" id="collected_5000" min="1"><span>=</span><input type="number" name="total_5000" id="total_5000" readonly><br />
                    <input type="number" style="width: 50px;" value="1000" name="d_1000" id="d_1000" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_1000" id="collected_1000" min="1"><span>=</span><input type="number" name="total_1000" id="total_1000" readonly><br />
                    <input type="number" style="width: 50px;" value="500" name="d_500" id="d_500" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_500" id="collected_500" min="1"><span>=</span><input type="number" name="total_500" id="total_500" readonly><br />
                    <input type="number" style="width: 50px;" value="100" name="d_100" id="d_100" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_100" id="collected_100" min="1"><span>=</span><input type="number" name="total_100" id="total_100" readonly><br />
                    <input type="number" style="width: 50px;" value="75" name="d_75" id="d_75" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_75" id="collected_75" min="1"><span>=</span><input type="number" name="total_75" id="total_75" readonly><br />
                    <input type="number" style="width: 50px;" value="50" name="d_50" id="d_50" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_50" id="collected_50" min="1"><span>=</span><input type="number" name="total_50" id="total_50" readonly><br />
                    <input type="number" style="width: 50px;" value="20" name="d_20" id="d_20" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_20" id="collected_20" min="1"><span>=</span><input type="number" name="total_20" id="total_20" readonly><br />
                    <input type="number" style="width: 50px;" value="10" name="d_10" id="d_10" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_10" id="collected_10" min="1"><span>=</span><input type="number" name="total_10" id="total_10" readonly><br />
                    <input type="number" style="width: 50px;" value="5" name="d_5" id="d_5" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_5" id="collected_5" min="1"><span>=</span><input type="number" name="total_5" id="total_5" readonly><br />
                    <input type="number" style="width: 50px;" value="2" name="d_2" id="d_2" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_2" id="collected_2" min="1"><span>=</span><input type="number" name="total_2" id="total_2" readonly><br />
                    <input type="number" style="width: 50px;" value="1" name="d_1" id="d_1" readonly><span>X</span><input type="number" style="width: 50px;" name="collected_1" id="collected_1" min="1"><span>=</span><input type="number" name="total_1" id="total_1" readonly><br />
                    <label for="total_cash_received">TOTAL CASH RECEIVED</label><input type="number" name="total_cash_received" id="total_cash_received" readonly><br />
                    <label for="balance">RETURN/GET/BALANCED</label><input type="number" name="balance" id="balance" readonly><br />
                    <label for="deposit_amount">DEPOSIT AMOUNT</label><input type="number" name="deposit_amount" id="deposit_amount" readonly><br />


                </div>
        </fieldset>
    </form>
    <?php



    ?>

    <script>
        var denomination = [document.getElementById('d_5000').value,
            document.getElementById('d_1000').value,
            document.getElementById('d_500').value,
            document.getElementById('d_100').value,
            document.getElementById('d_75').value,
            document.getElementById('d_50').value,
            document.getElementById('d_20').value,
            document.getElementById('d_10').value,
            document.getElementById('d_5').value,
            document.getElementById('d_2').value,
            document.getElementById('d_1').value
        ];
        var collected = [document.getElementById('collected_5000'),
            document.getElementById('collected_1000'),
            document.getElementById('collected_500'),
            document.getElementById('collected_100'),
            document.getElementById('collected_75'),
            document.getElementById('collected_50'),
            document.getElementById('collected_20'),
            document.getElementById('collected_10'),
            document.getElementById('collected_5'),
            document.getElementById('collected_2'),
            document.getElementById('collected_1')
        ];
        var total = [document.getElementById('total_5000'),
            document.getElementById('total_1000'),
            document.getElementById('total_500'),
            document.getElementById('total_100'),
            document.getElementById('total_75'),
            document.getElementById('total_50'),
            document.getElementById('total_20'),
            document.getElementById('total_10'),
            document.getElementById('total_5'),
            document.getElementById('total_2'),
            document.getElementById('total_1')
        ];

        for (let i = 0; i < collected.length; i++) {
            collected[i].addEventListener('input', function() {
                var a = denomination[i];
                var x = collected[i].value;
                total[i].value = x * a;
            });
        }

        /*   var d = document.querySelectorAll('.denom');

        d.forEach(function(denom) {
            document.getElementById('collected_' + denom.value).addEventListener('input', function() {
                var collected = document.getElementById('collected_' + denom.value).value;
                var total = document.getElementById('total_' + denom.value);
                total.value = collected * denom.value;
            });
        });*/
        const inputs = document.querySelectorAll('input[id^="collected_"]');
        inputs.forEach(inp => inp.classList.add('collected'));

        var collectedInputs = document.querySelectorAll('.collected');

        collectedInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                var x = parseInt(input.value);
                if (isNaN(x)) {
                    input.style.backgroundColor = '';
                    input.style.color = '';
                } else if (x < 0) {
                    input.style.backgroundColor = 'red';
                    input.style.color = 'lightyellow';
                } else if (x == 0) {
                    input.style.backgroundColor = 'lightgreen';
                    input.style.color = 'darkgreen';
                } else if (x > 0) {
                    input.style.backgroundColor = 'lightblue';
                    input.style.color = 'darkblue';
                } else {

                }

            })


        });
    </script>




</body>

</html>