<html>
    <head>

    </head>

    <body>
        <h3>Presets</h3>
        <p>Select a preset below:</p>
        <form action="insert.php" method="post" id="presetform">
            <input type="hidden" name="selected_input" value="">
            <select name="presets" id="presets" onchange="setSelectedValue(this)">
                <option value="">Select...</option>
                <option value="I'll be back in 5">I'll be back in 5</option>
                <option value="I'm off campus for the rest of the day">I'm off campus for the rest of the day</option>
                <option value="I'll be back soon">I'll be back soon</option>
                <option value="I'm in class and will be back after">I'm in class and will be back after</option>
            </select>
            <input type="submit" value="Submit">
        </form>

        <script>
            function setSelectedValue(select) {
                var selectedValue = select.value;
                document.getElementById('presetform').querySelector('[name="selected_input"]').value = selectedValue;
            }
        </script>
    </body>
</html>
