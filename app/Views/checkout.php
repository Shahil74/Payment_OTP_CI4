<!DOCTYPE html>
<html lang="en">

<head>
    <title>Razorpay Payment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZjb6YBmyLfVjGOGGg2DtrB6YEmWZlK4R5E5rF9ZLvvJXh7wANNCeNwMquU6M" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var razorpayKey = "<?= (new \Config\Payment())->razorpayKeyId ?>";
</script>

    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        #success-message {
            display: none;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container text-center">
        <h2 class="mb-4">Make Payment</h2>
        <div class="form-group">
            <label>Amount:</label>
            <input type="number" id="amount" class="form-control mb-3" min="1" value="10">
        </div>
        <button class="btn btn-primary btn-lg" onclick="payNow()">Pay Now</button>
        <p id="success-message" class="text-success mt-3"></p> <!-- Success Message -->
    </div>

    <script>
        function payNow() {
            let amountField = document.getElementById("amount");
            let amount = parseFloat(amountField.value);

            if (!amount || amount < 1) {
                alert("Please enter a valid amount (Minimum ₹1)");
                return;
            }
            let requestData = { amount: amount };
            console.log("Sending data:", JSON.stringify(requestData));
            fetch("<?= base_url('payment/process') ?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(requestData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response from server:", data);

                    if (data.order_id) {
                        var options = {
                            key: razorpayKey,
                            amount: data.amount * 100, // Convert to paisa for Razorpay
                            currency: data.currency,
                            name: "Test Payment",
                            order_id: data.order_id,
                            prefill: {
                                contact: "", 
                                email: "",
                                name: ""
                            },
                            handler: function(response) {
                                confirmPayment(response.razorpay_payment_id, amount);
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    } else {
                        alert("Error: " + data.error);
                        console.error("Server error:", data);
                    }
                })
                .catch(error => console.error("Fetch error:", error));
        }

        function confirmPayment(paymentId, amount) {
            console.log("Confirming payment - ID:", paymentId, "Amount:", amount);
            fetch("<?= base_url('payment/confirm') ?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        razorpay_payment_id: paymentId,
                        amount: amount
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        let successMessage = document.getElementById("success-message");
                        successMessage.innerText = "✅ Payment Successful!";
                        successMessage.style.display = "block";
                        setTimeout(() => {
                            successMessage.style.display = "none";
                        }, 5000);

                        document.getElementById("amount").value = "10"; // Reset amount to 10
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Confirm payment error:", error));
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-whCw6B2PabXyTnzP0+JNB0W3/hHbhLStpBsrHnA7uN4BiQ71jgjlqBIu7A1wYmS2F" crossorigin="anonymous"></script>

</body>
</html>
