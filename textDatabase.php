<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Tracking</title>
         <link href="/federico/stylesheets/SkeletonCss/base.css" media="screen" rel="stylesheet" type="text/css" >

        <link href="/federico/stylesheets/skeleton.css" media="screen" rel="stylesheet" type="text/css" >
        <link href="/federico/stylesheets/layout.css" media="screen" rel="stylesheet" type="text/css" >
        <link href="/federico/stylesheets/site.css" media="screen" rel="stylesheet" type="text/css" >
    </head>
    <body>
      <div class="container">
    <header class="sixteen columns">
    <a href="/"><img src="/federico/imgs/fed.png" height="37" width="37"/></a>
        <span class="main_title">Federico Paini</span>
    </header>

    <div class="sixteen columns" id="menu">
        <nav>
                <?php include ('http://www.paini.org/federico/topMenu.html'); ?>
        </nav>
    </div>

    <div class="sixteen columns content">

 <h2>Tracking Database</h2>
    <p>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
    <p>
    Tracking Notes: <input type="text" name="note">
    <button type="submit">Track Now </button> <br>
    <input type=hidden name=operation value=1>
    </p>
</form>

<p>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input type=hidden name=operation value=2>
    <p>Clear Data: <button type="submit" onclick="return confirm('Clear the database?')">Erase</button>
    </p>
</form>

<p>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input type=hidden name=operation value=3>
    <p>Records in the File: <button type="submit">Show</button>
    </p>
</form>

</p> 
<p>
<p>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input type=hidden name=operation value=5>
    <p>Backup the database: <button type="submit">Backup</button>
    </p>
</form>


<?php

if (!isset($operation)) {
    $operation = 0;
}


$id=$_REQUEST['operation'];
$note =$_REQUEST['note'];


if (empty($note)) {
    $note = 'N/A';
}

$dataFile = "data.txt";
$time = date("l M d Y H:i:s", strtotime('+2 hours'));

$record = $time.",".$note.PHP_EOL;

switch($id) {

    case 1: //insert new recordi

    $fh = fopen($dataFile, 'a') or die("can't open file");
    fwrite($fh, $record);
    fclose($fh);

    print "<p>Inserted: ".$record."</p>";
    print '<p> <a href=data.txt>Data File</a> </p>';

    break;

    case 2: //Clear file
    $fh = fopen( $dataFile, "r+" );
    ftruncate($fh, 0);
    fclose($fh);

    print "<p> Content Erased! <a href=$dataFile>Check here</a> </p>";


    break;

    case 3; //list the content of the file
    $count = substr_count(file_get_contents($dataFile), "\n");
    print "<p>".$count." record(s) in the text database: <br>";

    $fh = fopen($dataFile, 'r') or die("can't open file");
    $n = 1;

    for ($i=1; $i<$count+1; $i++){
        $line = fgets($fh, 1024);
        $list = explode(",", $line);
        $r = urlencode($line);
        print $i.") ".$list[0]." => ".$list[1]." | "."<a href=$self?operation=4&line_no=\"$i\" onclick=\"return confirm('Delete the record?')\">delete</a>"."<br>";
    }
    print "</p>";
    fclose($fh);

    break;

    case 4; //delete line
    function cutline($filename,$line_no=-1) {

        $strip_return=FALSE;

        $data=file($filename);
        $pipe=fopen($filename,'w');
        $size=count($data);

        if($line_no==-1) $skip=$size-1;
        else $skip=$line_no-1;

        for($line=0;$line<$size;$line++)
        if($line!=$skip)
        fputs($pipe,$data[$line]);
        else
        $strip_return=TRUE;
        return $strip_return;
    }

    $line_no = trim ( $_GET['line_no'], '"') ;

    cutline($dataFile, $line_no); // deletes line
    break;


    case 5: //Backup the file 

    $d = new DateTime();
    $timeStamp = $d -> getTimestamp();

    $backupFile = "backup/dataBackup_$timeStamp.txt";

    if (!copy($dataFile, $backupFile)) {
        print  "<p>Failed to backup the database! $dataFile, $backupFile</p>";
    } else {
        print "<p> Backup succeded!<br> "."<a href=\"$backupFile\">Examine the backed up file</a></p>";
    }

    break;

    case 99; //Show source code

        show_source(__FILE__); 

    break;

    case 0: //do nothing

    break;

}

?>

</p>

    </div>
    <footer class="sixteen columns footer">
        <div class="column one-third alpha about">

        </div>
    </footer>
     </div>
    </body>
</html>
