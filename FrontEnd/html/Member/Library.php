<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <label for="sortLibrary">Sort by:</label>

    <select name="sortBy" id="genre">
        <option value="shooter">Volvo</option>
        <option value="racing">Saab</option>
        <option value="MOBA">Mercedes</option>
        <option value="RPG">Audi</option>
        <option value="Simulation">Audi</option>
        <option value="Adventure">Audi</option>
        <option value="Action">Audi</option>
    </select>
    <?php include("../../../BackEnd/Member/LibraryMember.php");
    showLibrary(); ?>
</body>

</html>