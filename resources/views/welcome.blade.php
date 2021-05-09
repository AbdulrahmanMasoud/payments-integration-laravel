<!DOCTYPE html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
</head>

<body>
@if (Session::has('success'))
<p>{{ Session::get('success') }}</p>
@endif
{{-- ----------------------- Paypal ------------------- --}}
<form action="{{route('paypal.checkout')}}" method="POST">
  @csrf
<input type="submit" value="Paypal">
</form>
<br>
 
{{-- ---------------------------- Stripe --------------------- --}}
<div class="container">  
  <div class="row">
      <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <div class="row text-center">
                      <h3 class="panel-heading">Payment Details</h3>
                  </div>                    
              </div>
              <div class="panel-body">

                  @if (Session::has('success'))
                      <div class="alert alert-success text-center">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                          <p>{{ Session::get('success') }}</p>
                      </div>
                  @endif

<form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation"
                                                   data-cc-on-file="false"
                                                  data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                  id="payment-form">
                      @csrf

                      <input class='form-control' size='4' type='text'>


                      <input autocomplete='off' class='form-control card-num' size='20' type='text'>


                      <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' size='4' type='text'>

                      <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                      <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>

                      <div class='alert-danger alert'>Fix the errors before you begin.</div>

                      <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now</button>
                  </form>
              </div>
          </div>        
      </div>
  </div>
</div>



<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
$(function() {
  var $form = $(".validation");
$('form.validation').bind('submit', function(e) {
  var $form = $(".validation"),
      inputVal = ['input[type=email]', 'input[type=password]',
                       'input[type=text]', 'input[type=file]',
                       'textarea'].join(', '),
      $inputs       = $form.find('.required').find(inputVal),
      $errorStatus = $form.find('div.error'),
      valid         = true;
      $errorStatus.addClass('hide');

      $('.has-error').removeClass('has-error');
  $inputs.each(function(i, el) {
    var $input = $(el);
    if ($input.val() === '') {
      $input.parent().addClass('has-error');
      $errorStatus.removeClass('hide');
      e.preventDefault();
    }
  });

  if (!$form.data('cc-on-file')) {
    e.preventDefault();
    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
    Stripe.createToken({
      number: $('.card-num').val(),
      cvc: $('.card-cvc').val(),
      exp_month: $('.card-expiry-month').val(),
      exp_year: $('.card-expiry-year').val()
    }, stripeHandleResponse);
  }

});

function stripeHandleResponse(status, response) {
      if (response.error) {
          $('.error')
              .removeClass('hide')
              .find('.alert')
              .text(response.error.message);
      } else {
          var token = response['id'];
          $form.find('input[type=text]').empty();
          $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
          $form.get(0).submit();
      }
  }

});
</script>
  
</body>
</html>

