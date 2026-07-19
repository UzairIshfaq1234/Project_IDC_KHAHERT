<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDC  RESULT ALERT</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            color: #eb0000;
            font-weight: bold;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        p {
            text-align: center;
            color: #555;
            line-height: 1.6;
        }

        .details {
            margin-top: 10px;
        }

        .details p {
            margin-bottom: 2px;
        }

        .terms {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .terms p {
            color: #777;
            font-size: 14px;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>IDC RESULT 🔬 </h1>
        <h3>Dear {{$Maildata['Name']}},</h3> 
        <p>Your Result Is:</p>

        @if ($Maildata['Result']=='Positive')

        <h2 style="text-align:center;background-color: #eb0000;color:white;font-weight:bolder;padding:10px;">{{$Maildata['Result']}}</h2>

        <h4 style="color:red;text-align:center;">Reach to the hospital as soon as possible so that we can start your treatment!</h4>
            
        @endif

        @if ($Maildata['Result']=='Negative')

        <h2 style="text-align:center;background-color: rgb(9, 221, 9);color:white;font-weight:bolder;padding:10px;">{{$Maildata['Result']}}</h2>
        <h4 style="color:rgb(9, 221, 9);text-align:center;">Congrats your Result are Clear!</h4>
            
        @endif

        <div class="details">
            <p><strong>ID/Checking NO:</strong> {{$Maildata['ID']}}</p>
            <p><strong>Sample Number:</strong> {{$Maildata['Sampleno']}}</p>
            <p><strong>Name:</strong> {{$Maildata['Name']}}</p>
            <p><strong>Contact Number:</strong> {{$Maildata['ContactNo']}}</p>
            <p><strong>Added By (LT):</strong> {{$Maildata['Addedby']}}</p>
            <p><strong>Result By (Pathologist):</strong> {{$Maildata['Resultedby']}}</p>

        </div>

        <p>You will be soon informed about the results. Thank you for choosing IDC!</p>

        <div class="terms">
            <h3 style="align-content: center;">NOTE:</h3>
            <p>1:you will be informed about your result via Mail</p>
            <p>2:Please have patience we will inform you as soon as possible.</p>
            <p>3:For any query Email us at IDC.gamil.com</p>

            <!-- Add more terms and conditions as needed -->
        </div>
    </div>
</body>
</html>
