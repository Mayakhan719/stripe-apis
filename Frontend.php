<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Accept a payment</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/checkout.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
  <div class="row">
  <div class="col-75">
    <div class="container">
      <form action="action_page.php" method="post">
        <div class="row justify-content-center mt-5">
          <div class="col-md-6 ">
            <h3>Payment</h3>
            <label for="description">Description</label>
            <input type="text" id="description" name="description" placeholder="Description">

            <label for="number">Credit card number</label>
            <input type="text" id="number" name="number" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="exp_month" name="exp_month" placeholder="September">

            <div class="row">
              <div class="col-50">
                <label for="exp_year">Exp Year</label>
                <input type="text" id="exp_year" name="exp_year" placeholder="2018">
              </div>
              <div class="col-50">
                <label for="cvc">CVV</label>
                <input type="text" id="cvc" name="cvc" placeholder="352">
              </div>
            </div>
            <div class="row">
              <div class="col-50">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" placeholder="$ ">
              </div>
              <div class="col-50">
                <label for="currency">Currency</label>
                <input type="text" id="currency" name="currency" placeholder="inr">
              </div>
            </div>
            <input type="submit" value="Continue to checkout" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php if(isset($_GET["success"])){?>
<script>
  alert("<?php echo $_GET["success"]?>")
</script>
  <?php
}
?>
  </body>
</html>