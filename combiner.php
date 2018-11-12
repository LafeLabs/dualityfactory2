<!doctype html>
<html  lang="en">
<head>
<meta charset="utf-8"> 
<title>Combiner</title>

<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAP//AP8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAiIiIiIiIiIgERAAERAAERABEQABEQABEAAREAAREAASIiIiIiIiIiAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACIiIiIiIiIiAREAAREAAREAERAAERAAEQABEQABEQABIiIiIiIiIiL//wAAAAAAAAAAAAAAAAAAAAAAAAAAAAC++wAAnnkAAI44AACeeQAAvvsAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" rel="icon" type="image/x-icon" />

<!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<!--Stop Google:-->
<META NAME="robots" CONTENT="noindex,nofollow">
</head>
<body>
<div id = "pathdiv" style = "display:none"><?php
    if(isset($_GET['path'])){
        echo $_GET['path'];
    }
?></div>
<div id = "datadiv" style = "display:none"><?php
    if(isset($_GET['path'])){
        echo file_get_contents($_GET['path']);
    }
    else{
        echo file_get_contents("json/map.txt");        
    }
?></div>
<div id = "imgurls" style = "display:none;"><?php

    echo file_get_contents("json/imgurls.txt");
    
?></div>
<div id = "mapicons" style = "display:none;"><?php

$files = scandir(getcwd()."/mapicons");
$listtext = "";
foreach($files as $value){
    if($value != "." && $value != ".."){
        $listtext .= $value.",";
    }
}
echo $listtext;
    
?></div>
<div id = "symbols" style = "display:none;"><?php

$files = scandir(getcwd()."/symbol/svg");
$listtext = "";
foreach($files as $value){
    if(substr($value,-4) == ".svg"){
        $listtext .= "symbol/svg/".$value.",";
    }
}
echo $listtext;


$dirs = scandir(getcwd()."/symbol/symbols");
foreach($dirs as $symboldir){
    if($symboldir != "." && $symboldir != ".."){
        $files = scandir(getcwd()."/symbol/symbols/".$symboldir."/svg");
        $listtext = "";
        foreach($files as $value){
            if(substr($value,-4) == ".svg"){
                $listtext .= "symbol/symbols/".$symboldir."/svg/".$value.",";
            }
        }
        echo $listtext;
    }
}


?></div>
<div id = "curves" style = "display:none;"><?php

$files = scandir(getcwd()."/curve/svg");
$listtext = "";
foreach($files as $value){
    if(substr($value,-4) == ".svg"){
        $listtext .= $value.",";
    }
}
echo $listtext;
    
?></div>
<div id = "uploadimages" style = "display:none;"><?php

$files = scandir(getcwd()."/uploadimages");
$listtext = "";
foreach($files as $value){
    if($value != "." && $value != ".."){
        $listtext .= $value.",";
    }
}
echo $listtext;
    
?></div>
<a id = "factorylink" href = "index.php" style = "position:absolute;left:10px;top:10px"><img src = "mapicons/mapfactory.svg" style = "width:50px"></a>
        <div id = "savebutton"><img style = "position:absolute;right:0px;top:0px;width:100px" class = "button" src = "mapicons/gobutton.svg"/></div>
        
<table id = "maintable">
    <tr>
        <td>
            <img style = "width:100px" id = "topimage"/>
        </td>
    </tr>
    <tr>
        <td>
            <img style = "width:100px" id = "bottomimage"/>
        </td>
    </tr>

    <tr>
        <td id = "topbutton" class = "button">top:<td><input id = "topinput"></td>
    </tr>
    <tr>
        <td id = "bottombutton" class = "button">bottom:<td><input id = "bottominput"></td>
    </tr>

</table>

<div id = "imagescroll"></div>


<script>
    layerIndex = 0;
    selectbuttons = [];
    selectbuttons.push(document.getElementById("topbutton"));
    selectbuttons.push(document.getElementById("bottombutton"));

    mainimages = [];
    mainimages.push(document.getElementById("topimage"));
    mainimages.push(document.getElementById("bottomimage"));

    maininputs = [];
    maininputs.push(document.getElementById("topinput"));
    maininputs.push(document.getElementById("bottominput"));

    selectbuttons[layerIndex].style.backgroundColor = "#80ff80";

    path = document.getElementById("pathdiv").innerHTML;
    if(path.length > 1){
        pathset = true;
        document.getElementById("factorylink").href += "?path=" + path;
    }
    else{
        pathset = false;
    }
    

    imgurls = JSON.parse(document.getElementById("imgurls").innerHTML);
    map = JSON.parse(document.getElementById("datadiv").innerHTML);
    mapicons = document.getElementById("mapicons").innerHTML.split(",");
    
    uploadimages = document.getElementById("uploadimages").innerHTML.split(",");
    for(var index = 0;index < uploadimages.length - 1;index++){
        imgurls.push("uploadimages/" + uploadimages[index]);
    }
    
    symbols = document.getElementById("symbols").innerHTML.split(",");
    for(var index = 0;index < symbols.length - 1;index++){
        imgurls.push(symbols[index]);
    }
    curves = document.getElementById("curves").innerHTML.split(",");
    for(var index = 0;index < curves.length - 1;index++){
        imgurls.push("curve/svg/" + curves[index]);
    }
    for(var index = 0;index < mapicons.length - 1;index++){
        imgurls.push("mapicons/" + mapicons[index]);
    }
    


    
    
    for(var index = 0;index < imgurls.length; index++){
        var newimg = document.createElement("IMG");
        newimg.src = imgurls[index];
        newimg.className = "button";
        document.getElementById("imagescroll").appendChild(newimg);
        newimg.onclick = function(){
            mainimages[layerIndex].src = this.src;
            maininputs[layerIndex].value = this.src;

        }
    }
    

    document.getElementById("savebutton").onclick = function(){
        if(pathset){
            currentFile = path;
        }
        else{
            currentFile = "json/map.txt";
        }
        
        topimage = {};
        bottomimage = {};
        topimage.src = document.getElementById("topimage").src;
        bottomimage.src = document.getElementById("bottomimage").src;
        topimage.x = 0.2;
        topimage.y = 0.2;
        topimage.w = 0.5;
        topimage.angle = 0;
        bottomimage.x = 0.2;
        bottomimage.y = 0.2;
        bottomimage.w = 0.5;
        bottomimage.angle = 0;
        map =[];
        map.push(bottomimage);
        map.push(topimage);
        
        data = encodeURIComponent(JSON.stringify(map,null,"    "));
        var httpc = new XMLHttpRequest();
        var url = "filesaver.php";        
        httpc.open("POST", url, true);
        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
        httpc.send("data=" + data + "&filename=" + currentFile);//send text to filesaver.php
    }


selectbuttons[0].onclick = function(){
    selectbuttons[layerIndex].style.backgroundColor = "white";
    layerIndex = 0;
    selectbuttons[layerIndex].style.backgroundColor = "#a0ffa0";
}
selectbuttons[1].onclick = function(){
    selectbuttons[layerIndex].style.backgroundColor = "white";
    layerIndex = 1;
    selectbuttons[layerIndex].style.backgroundColor = "#a0ffa0";
}

</script>
<style>
body{
    font-family:Helvetica;
    font-size:24px;
}
input{
    font-family:courier;
    font-size:20px;
}
    #imagescroll{
        position:absolute;
        left:70%;
        right:10px;
        top:110px;
        bottom:10px;
        border:solid;
        border-color:yellow;
        border-width:5px;
        overflow:scroll;
    }
    #imagescroll img{
        width:50%;
        display:block;
        margin:auto;
    }
    #maintable{
        position:absolute;
        width:25%;
        left:30%;
        top:110px;
    }

    .button{
        cursor:pointer;
        border:solid;
        margin-top:1em;
        margin-bottom:1em;
    }
    .button:hover{
        background-color:#a0ffa0;
    }
    .button:active{
        background-color:yellow;
    }


</style>
</body>
</html>