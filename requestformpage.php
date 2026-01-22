<!DOCTYPE html>
<html lang="en">
<head>
    <title>Barangay Request Form</title>
    <style>
        body {
            background-image: url('bbackground.png');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        h1 {
            color: white;
            text-align: center;
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 35px;
        }

        form {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 100px 50px;
            border-radius: 50px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5);
            border: 1px solid white;
            width: 90%;
            max-width: 800px;
            text-align: center;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 70px;
        }

        .indigency, .bclearance {
            text-align: center;
            flex: 1;
        }

        .indigency img, .bclearance img {
            width: 40%;
            max-width: 150px;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .indigency img:hover, .bclearance img:hover {
            transform: scale(1.1);
        }

        .indigencytxt, .bclearancetxt {
            font-weight: bold;
            margin-top: 10px;
            color: white;
        }
    </style>
</head>
<body>
    <form>
        <h1>ONLINE SERVICES REQUEST FORM</h1>
        <div class="image-container">
            <div class="indigency">
                <img src="finalcertificate.png" alt="Indigency Image">
                <p class="indigencytxt">Certification of Indigency</p>
            </div>
            <div class="bclearance">
                <img src="clearance.png" alt="Barangay Clearance Image">
                <p class="bclearancetxt">Barangay Clearance</p>
            </div>
            <div class="bclearance">
                <img src="business.png" alt="Business Clearance Image">
                <p class="bclearancetxt">Business Clearance</p>
            </div>
        </div>
    </form>
</body>
</html>
