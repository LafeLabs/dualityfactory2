<!doctype html>
<html  lang="en">
<head>
<meta charset="utf-8"> 
<title>Duality Feed</title>

<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAP//AP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAREAAREAAREAERAAERAAEQABEQABEQABAAAAAAAAAAAAAAAAAAAAAAAAACIiAAAAAAAiIiIiAAAAAiAAIiIgAAAAAAACIiAAAAAAAAIiIAAAACIAIgAgAAAAIgAiACAAAAAAACIiIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//wAA/D8AAPAPAADgBwAAwAMAAMADAADAAwAAwAMAAMADAADAAwAA4AcAAPAPAAD8PwAA" rel="icon" type="image/x-icon" />


<!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<!--Stop Google:-->
<META NAME="robots" CONTENT="noindex,nofollow">

</head>
<body>
<div id = "filesdiv" style = "display:none"><?php

$files = scandir(getcwd()."/dualities");
$listtext = "";
foreach($files as $value){
    if(substr($value,-4) == ".txt"){
        $listtext .= "dualities/".$value;
        $listtext .= ",\n";
    }
}

$listtext = rtrim($listtext, ",\n");

echo $listtext;

?></div>
<div id = "datadiv" style = "display:none"><?php

$files = scandir(getcwd()."/dualities");
$listtext = "[\n";
foreach($files as $value){
    if(substr($value,-4) == ".txt"){
        $listtext .= file_get_contents("dualities/".$value);
        $listtext .= ",\n";
    }
}

$listtext = rtrim($listtext, ",\n");
$listtext .= "\n]";

echo $listtext;

?></div>

<a href = "index.php" style = "position:absolute;left:10px;top:10px;z-index:4"><img src = "mapicons/dualityfactory.svg" style = "width:50px"></a>

<div id = "memefeed"></div>

<script>

memes = JSON.parse(document.getElementById("datadiv").innerHTML);
files = document.getElementById("filesdiv").innerHTML.split(",");

W = innerWidth*0.6;

for(var mindex = memes.length - 1;mindex >= 0;mindex--){
    var newdiv = document.createElement("DIV");
    newdiv.style.width = (W).toString()  + "px";
    newdiv.style.height = (1.2*W).toString()  + "px";
    newdiv.style.position = "relative";
    document.getElementById("memefeed").appendChild(newdiv);
    for(var index = 0;index < memes[mindex].length;index++){
        var newimg = document.createElement("IMG");
        newimg.src = memes[mindex][index].src;
        newimg.style.position = "absolute";
        newimg.style.opacity = "0.5";
        newdiv.appendChild(newimg);
        newimg.style.width = (memes[mindex][index].w*W).toString() + "px";
        newimg.style.left = (memes[mindex][index].x*W).toString() + "px";
        newimg.style.top = (memes[mindex][index].y*W).toString() + "px";
    }
    var newa = document.createElement("a");
    var newimg = document.createElement("img");
    newa.className = "editlink";
    newimg.src = "mapicons/editor.svg";
    newa.href = "index.php?path=" + files[mindex];
    newa.appendChild(newimg);
    newdiv.appendChild(newa);


}
</script>
<style>
body{
    font-family:Helvetica;
    font-size:24px;
}
.button{
    cursor:pointer;
}
.button:hover{
    background-color:green;
}
.button:active{
    background-color:yellow;
}
#memefeed{
    position:absolute;
    top:110px;
    bottom:0px;
    overflow:scroll;
    left:20%;
    right:20%;
}
.editlink{
    position:absolute;
    top:0px;
    left:0px;
    width:80px;
}
.editlink img{
    width:100%;
}
.deletebutton{
    position:absolute;
    top:0px;
    right:80px;
    width:80px;
}
.deletebutton img{
    width:100%;
}

</style>
</body>
</html>