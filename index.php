<?php require 'needs.php'; // Memuat skrip 'needs' ?>

<html>
<body>

<h1>Leiden Maps Download Tool</h1>
<form action="download.php" method="post">
    <table>
        <tr>
            <td>Maps URL</td>
        </tr>
        <tr>
            <td><input type="text" name="mapsurl" required>&nbsp;&nbsp;<small>Maps url from The Leiden Library site</small></td>
        </tr>
        <tr>
            <td>Images Quality</td>
        </tr>
        <tr>
            <td><select name="quality">
                <option value="1">1 - <?= $res[1]; ?> (Not Recommended)</option>
                <option value="2">2 - <?= $res[2]; ?> (Not Recommended)</option>
                <option value="3">3 - <?= $res[3]; ?></option>
                <option value="4" selected>4 - <?= $res[4]; ?> (Auto)</option>
                <option value="5">5 - <?= $res[5]; ?> (Recommended)</option>
            </select>&nbsp;&nbsp;<small>Measure of Image Quality</small></td>
        </tr>
        <tr>
            <td><br/><input type="submit" value="Process"></td>
        </tr>
    </table>
</form>

</body>
</html>
