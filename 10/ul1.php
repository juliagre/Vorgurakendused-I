<?php
$text_bg="#fff";
if (isset($_GET["bg"])) {
		$text_bg = htmlspecialchars($_GET["bg"]);
	} 

$text_color="#fff";
if (isset($_GET["tc"])) {
    $text_color = htmlspecialchars($_GET["tc"]); 
}
$border_width =2;
if (isset($_GET['bw']) ) 
    $border_width = htmlspecialchars($_GET['bw']); 
$border_style =" solid ";
if (isset($_POST['bs']) ) 
    $border_style = htmlspecialchars($_POST['bs']); 
$border_color =" black ";
if (isset($_GET['bc']) ) 
    $border_color = htmlspecialchars($_GET['bc']); 
$border=$border_color." ".$border_style." ".$border_width; 

$border_radius =10;
if (isset($_GET['br']) ) 
    $border_radius = htmlspecialchars($_GET['br']);
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Praktikum  - Ulesanne</title>

    <style type="text/css">

        #text { background: <?php echo $text_bg;?>;
            color: <?php echo $text_color; ?>;
            border:  <?php echo $border; ?>px;
            border-radius: <?php echo $border_radius; ?>px;
            padding:10px;
            min-height:100px;
            max-width: 400px;
        }

    </style>

</head>
<body>

    <?php 

    $stiilid=array("solid", "dashed", "dotted", "none", "double");

    ?>

    <div id="text"> <?php if (isset($_GET["text"])) echo htmlspecialchars($_GET['text']); ?></div>

    <hr/>
    <form method="GET" action="?">
        <textarea name="text" placeholder="kommentaari tekst" > <?php if (isset($_GET["text"])) echo htmlspecialchars($_GET['text']); ?></textarea>
        <br/>
        <input type="color" name="bg" id="bg" value= <?php if (isset ($_GET["bg"])){echo $_GET["bg"];} ?> >
        <label for="bg">Taustavarvus</label>
        <br/>
        <input type="color" name="tc" id="tc" value= <?php if (isset ($_GET["tc"])){echo $_GET["tc"];} ?> > 
        <label for="tc">Tekstivarvus</label>
        <br/>
        <fieldset>
            <legend>Piirjoon</legend>
            <input type="number" min="0" max="20" step="1" name="bw" id="bw" value= <?php if (isset ($_GET["bw"])){echo $_GET["bw"];} ?> >
            <label>Piirjoone laius (0-20px)</label>
            <br/>
            <select name="bs">
                <?php foreach($stiilid as $stiil):?>
                    <option><?php echo $stiil; ?></option>
                <?php endforeach; ?>
            </select>
            <br/>
            <input type="color" name="bc" id="bc" value= <?php if (isset ($_GET["bc"])){echo $_GET["bc"];} ?> > 
            <label for="bc">Piirjoone varvus</label>
            <br/>
            <input type="number" min="0" max="100" step="1" name="br" id="br" value= <?php if (isset ($_GET["br"])){echo $_GET["br"];} ?> >
            <label>Piirjoone nurga raadius (0-100px)</label>
            <br/>
        </fieldset>
        <input type="submit" value="esita" />
    </form>

</body>
</html> 
