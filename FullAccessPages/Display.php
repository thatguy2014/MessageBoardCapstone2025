<style>
html, body {
    background: white;
    height: 100%;
    width: 100%;
    overflow: hidden; /* Prevents scrolling */
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}

h2 {
    font-size: 10vw; /* Start with a large font size */
    font-family: <?php echo $UserFont["Font"] ?>;
    text-align: center;
    margin: 0;
    padding: 0;
    word-wrap: break-word;
    width: 90%;
    white-space: normal; /* Ensures wrapping */
    max-width: 100%;
}
</style>

<html>
    <body>
        <h2 id="currentdisplay">
            <?php   
                $displayText = "";
                if ($resultbool) {
                    $displayText = "<img src='" . $ImageDir . "' style='max-width: 100%; height: auto;'>";
                } else {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $displayText .= $row["CurrentDisplay"] . " ";
                    }
                }
                echo $displayText;
            ?>
        </h2>
    </body>

    <script>
        function adjustFontSize() {
            let textElement = document.getElementById("currentdisplay");
            if (!textElement || textElement.innerHTML.trim() === "") return; // Prevents running if empty

            let parent = document.documentElement;
            let fontSize = 10; // Start with a large font size
            textElement.style.fontSize = fontSize + "vw";

            while (textElement.scrollHeight > parent.clientHeight || textElement.scrollWidth > parent.clientWidth) {
                fontSize -= 0.5; // Decrease step by step
                textElement.style.fontSize = fontSize + "vw";
                if (fontSize < 2) break; // Prevents infinite shrinking
            }
        }

        window.onload = adjustFontSize;
        window.onresize = adjustFontSize; // Adjust on window resize
    </script>
</html>
