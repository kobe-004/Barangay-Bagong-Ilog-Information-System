<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Familjen+Grotesk:ital,wght@0,400..700;1,400..700&family=Kanit:ital,wght@0,400;1,800&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Slab:wght@100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>System Settings</title>
</head>
<style>
    body{
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;

    }
    #navbar{
        position: fixed;
        top: 0;
        left: 0;
        width: 20vh;
        background: radial-gradient(circle at 0% 0%, #000000, #161959, #37add1);
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 20%;
    }
    #settings-h1 {
        color: #EEEEEE;
    }
    #backButton {
        z-index: 1;
        position: absolute;
        left: 1%;
        top: 25%;
        text-decoration: none;
        padding: 10px;
        background-color: #787A91;
        color: #EEEEEE;
        border-radius: 5px;
    }
    #backButton:hover {
        background-color: #EEEEEE;
        color: #0F044C;
    }
    #settings-option{
        width: 300px;
        height: 200px;
        position: absolute;
        left: 0;
        top: 100%;
        z-index:3;
    }

</style>
<body>
    <div id="navbar">
        <a href="index.php" id="backButton">BACK</a>
        <h1 id="settings-h1">SYSTEM SETTINGS</h1>
    </div>
</body>
</html>