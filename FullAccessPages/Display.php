<style>
html {
    background: white;
    height: 100%;
    width: 100%;
    overflow: hidden; /* Prevents scrolling */
    display: flex;
    justify-content: center;
    align-items: center;
}

body {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

h2 {
    font-size: 10vw; /* Base size, auto-adjusted in JS */
    font-family: <?php echo $UserFont["Font"] ?>;
    text-align: center;
    margin: 0;
    padding: 0;
    word-wrap: break-word;
    width: 90%; /* Ensures text stays within bounds */
    white-space: normal; /* Allows text wrapping */
}
</style>

<html>
    <h2 id="currentdisplay">
        <?php   
            if ($resultbool) {
                echo "<img src='" . $ImageDir . "' style='max-width: 100%; height: auto;'>";
            } else {
                while ($row = mysqli_fetch_assoc($res)) {
                    printf("%s \n", $row["CurrentDisplay"]);
                } 
            }
        ?>
    </h2>

    <script>
        function adjustFontSize() {
            let textElement = document.getElementById("currentdisplay");
            let parent = document.documentElement;
            let fontSize = 10; // Starting font size in vw
            textElement.style.fontSize = fontSize + "vw";

            // Reduce font size if text overflows
            while (textElement.scrollHeight > parent.clientHeight || textElement.scrollWidth > parent.clientWidth) {
                fontSize -= 0.5; // Reduce size step by step
                textElement.style.fontSize = fontSize + "vw";
                if (fontSize < 2) break; // Prevents infinite loop
            }
        }

        window.onload = adjustFontSize;
        window.onresize = adjustFontSize; // Adjust on window resize
    </script>
</html>
