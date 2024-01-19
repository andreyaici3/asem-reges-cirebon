<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENERATE BARCOD</title>
    <style>
        .wrapper {
            width: 5cm;
            height: 2cm;
            border: 1px solid black;
            border-radius: 10px;
            box-sizing: border-box;
            padding: 10px;
            text-align: center; 
        }
        p {
            margin-top: 0px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->code, 'C39', 0.7, 40, array(1,1,1), true)}}" alt="barcode" />
        <p>{{ $product->name }}</p>
        
        
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="/dist/js/print.min.js"></script>
    <script>
        $(function(){
            {{-- $('.wrapper').jqprint();  --}}
        })// sectionID is ID of the section
    </script>
</body>

</html>