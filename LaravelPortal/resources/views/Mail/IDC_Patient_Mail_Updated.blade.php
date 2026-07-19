<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDC Appointment Confirmation</title>
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
        <h1>IDC APPOINTMENT DETAILS UPDATION 🔬 </h1>
        <h3>Dear {{$Maildata['Name']}},</h3> 
        <p>Your updated appointment details are as follows:</p>

        <div class="details">
            <p><strong>ID/Checking NO:</strong> {{$Maildata['ID']}}</p>
            <p><strong>Sample Number:</strong> {{$Maildata['Sampleno']}}</p>
            <p><strong>Name:</strong> {{$Maildata['Name']}}</p>
            <p><strong>Contact Number:</strong> {{$Maildata['ContactNo']}}</p>
            <p><strong>Added By (LT):</strong> {{$Maildata['Addedby']}}</p>
            <p><strong>Updated By (LT):</strong> {{$Maildata['Updatedby']}}</p>

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
