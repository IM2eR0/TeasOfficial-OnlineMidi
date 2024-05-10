<?php

$_MIDIDIR = "./midis";

?>

<!DOCTYPE html>
<head>
    <title>Eh5の茶会 MIDI在线播放器</title>
    <link rel="stylesheet" href="https://nekogan.com/milligram.min.css">
    <link rel="stylesheet" href="https://nekogan.com/style.css">
</head>
<body>
    <div class="tabbar">
        <ul>
            <li><a href="https://midi.nekogan.com/usermidis" target="_top">用户上传</a></li>
            <li><a href="https://midi.nekogan.com/" target="_top">返回首页</a></li>
        </ul>
    </div>
    <div id="app">
        <center>
            <h1>Eh5の茶会</h1>
            <nav>Midi在线播放器</nav>
            <a href="https://docs.nekogan.com/zh/midi" target="_blank">如何使用？</a>
        </center>
        <hr>
        <h3>Midi文件列表</h3>
        <nav>本页为站长收集的高质量midi！</nav>
        <nav>善用浏览器搜索功能（Ctrl+F），快速定位midi文件！<br>PS：标注【多音轨】的midi文件不适合在GMod中进行播放！</nav>
        <nav>如有侵权，请联系我们，我们将在第一时间删除！</nav>
        <br>
        <table>
            <thead>
                <tr>
                    <th>文件名</th>
                    <th>文件大小</th>
                    <th>最后上传时间</th>
                    <th>播放</th>
                </tr>
            </thead>
            <tbody>
                <?
                
                if($dh = opendir($_MIDIDIR)){
                    while(($file = readdir($dh))!==false){
                        if(!($file == "." || $file == "..")){
                            echo "
                                <tr>
                                    <td>{$file}</td>
                                    <td>". number_format(filesize($_MIDIDIR."/".$file)/1024 , 2) ."KB</td>
                                    <td>". date('Y-m-d H:i:s',filemtime($_MIDIDIR."/".$file)) ."</td>
                                    <td><a href='./play.php?file={$file}'>试听</a></td>
                                </tr>
                            "; 
                        }
                    }
                    closedir($dh);
                }
                
                ?>
            </tbody>
        </table>
        <hr>
    </div>
</body>