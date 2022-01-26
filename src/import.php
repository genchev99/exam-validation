<!DOCTYPE html>
<html lang="en">
<head>
    <title>Import csv</title>
    <link rel="stylesheet" href="css/import.css">
    <script src="js/script.js"></script>
</head>
<body>
<div id="import-box" class="half-width">
    <ul class="selected-files full-width">
        <li class="full-width">
            <span class="file-name">testing.csv</span>
            <button class="control remove error quarter-width">remove</button>
        </li>
    </ul>

    <form action="api/import.php" method="POST" class="full-width text-center center">
        <div id="drop">
            <input type="file" class="full-width" multiple>
            <p>Drag your files here or click in this area</p>
        </div>

        <button type="submit" class="success full-width margin-top-small">Upload</button>
    </form>
</div>
</body>
</html>
