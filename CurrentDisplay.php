<?php
require_once "VerifyLogin.php";
?>

<html>
<head>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
        }

        /* Navigation styles */
        nav {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-buttons button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .nav-buttons button:hover {
            background-color: #0056b3;
        }

        iframe {
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .iframe-container {
            text-align: center;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>
        <header>
            <h1>Office Message Board</h1>
        </header>

        <!-- Navbar -->
        <nav>
            <div class="nav-buttons">
                <button onclick="location.href='CurrentDisplay.php'">Current Display</button>
                <button onclick="location.href='Presets.php'">Presets</button>
                <button onclick="location.href='ChangeDisplay.php'">Change Display</button>
                <button onclick="location.href='Logout.php'">Sign Out</button>
            </div>
        </nav>

        <!-- Iframe for auto-refresh -->
        <div class="iframe-container">
            <iframe id="iframe" src="Display.php" height="400" width="1000"></iframe><br>
            <button onclick="openFullscreen()">Fullscreen</button>
        </div>

        <!-- Fullscreen script -->
        <script>
            var elem = document.getElementById("iframe");

            function openFullscreen() {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) { /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE11 */
                    elem.msRequestFullscreen();
                }
            }
        </script>

        <!-- Auto-refresh script -->
        <script>
            window.setInterval(function() {
                reloadIFrame()
            }, 10000);

            function reloadIFrame() {
                console.log('reloading..');
                document.getElementById('iframe').contentWindow.location.reload();
            }
        </script>
        
        <footer>
            <!-- Footer content if necessary -->
        </footer>
    </div>
</body>
</html>
