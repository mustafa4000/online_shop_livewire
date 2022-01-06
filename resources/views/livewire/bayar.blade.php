<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                {{-- @if ($belanja->status == 1) --}}
                    <div class="row">
                        <div class="col-md-12">
                            <button id="pay_button" type="button" class="btn btn-primary center-block">pay!</button>
                        </div>
                    </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
    
    <form id="payment-form" method="get" action="Payment">
        <input type="hidden" name="result_data" id="result_data" value="">
    </form>
    
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-k7hILYNqAANwwZQl"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step

        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');
        function changeResult(type ,data) {
        $("#result-type").val(type);
        $("#result-data").val(JSON.stringify(data));  
        }

        snap.pay('<?= $snapToken ?>', {
          // Optional
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          // Optional
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          // Optional
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          }
        });
      };
    </script>
</body>
</html>