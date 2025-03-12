<!DOCTYPE html>
<html>
    <head>
        <title>Eh5の茶会 MIDI在线播放器</title>
        <link rel="stylesheet" href="https://nekogan.com/milligram.min.css">
        <link rel="stylesheet" href="https://nekogan.com/style.css">
        <link rel="stylesheet" href="https://midi.nekogan.com/midiControl.css">
    </head>
    
    
    
    <body>
        <div class="tabbar">
            <ul>
                <li><a href="https://midi.nekogan.com/usermidis" target="_top">用户上传</a></li>
                <li><a href="https://midi.nekogan.com/" target="_top">返回首页</a></li>
            </ul>
        </div>
        

    
        <div id="app">
            <?
                if(isset($_GET["file"])){
                    // echo(date('Y-m-d H:i:s',filemtime("./midis/".$_GET["file"])));
                    // echo var_dump();
                    if(!file_exists("./midis/".$_GET["file"])){
                        exit("<center><h1>哎呦！出错啦！</h1><nav>请求的文件不存在！</nav><center>");
                    }
                }elseif(isset($_GET["ufile"])){
                    if(!file_exists("./usermidis/".$_GET["ufile"])){
                        exit("<center><h1>哎呦！出错啦！</h1><nav>请求的文件不存在！</nav><center>");
                    }
                }else{
                    exit("<center><h1>哎呦！出错啦！</h1><nav>请求的文件不存在！</nav><center>");
                }
            ?>
            <center>
                <h1><?
                    if(isset($_GET["file"])){
                        echo explode(".mid",$_GET["file"])[0];
                    }else{
                        echo explode(".mid",$_GET["ufile"])[0];
                    }
                ?></h1>
                <nav>
                    <nav id="midinotes"></nav>
                    <nav id="mididur"></nav>
                    <? if (isset($_GET["ufile"])) { ?>
                        <nav>该Midi文件为用户上传，质量不确定</nav>
                    <? } ?>
                </nav>
            </center>
            <hr>
            <!--试听部分-->
            <div>
                <midi-visualizer type="piano-roll" id="myVisualizer" style="display: block;"></midi-visualizer>
                <center>
                    <h3>试听</h3>
                    <midi-player src="<?
                        if(isset($_GET["file"])){
                            echo "./midis/".$_GET["file"];
                        }else{
                            echo "./usermidis/".$_GET["ufile"];
                        }
                    ?>" sound-font="https://storage.googleapis.com/magentadata/js/soundfonts/sgm_plus" visualizer="#myVisualizer"></midi-player>
                    <nav>音符数大于一万五时不推荐在线播放，如果在线播放显示感叹号就刷新，刷到可以播放为止</nav>
                </center>
            </div>
            <hr>
            <!--播放到Midi设备-->
            <div>
                <center>
                    <h3>播放到Midi设备</h3>
                    <div id="controlPanel">
                        <span>
                            输入设备（若为空请尝试重启浏览器）：<select id="midiDevices"></select>
                        </span>
                        <p id="playa" style="color: green;"></p>
                        <nav>关掉页面就可以让midi停下来~</nav>
                    </div>
                    <button id="playButton">播放</button>
                </center>
                <hr>
                <center>
                    <h3>下载MIDI文件</h3>
                    <br>
                    <?
                        if(isset($_GET["file"])){
                            printf('<a class="button" href="https://midi.nekogan.com/midis/%s" target="_blank">点击下载 %s</a>',$_GET["file"],$_GET["file"]);
                        }else{
                            printf('<a class="button" href="https://midi.nekogan.com/usermidis/%s" target="_blank">点击下载 %s</a>',$_GET["ufile"],$_GET["ufile"]);
                        };
                    ?>
                </center>
            </div>
        </div>
    </body>
</html>
<script src="webmidi.js"></script>
<!--<script src="https://cdn.jsdelivr.net/combine/npm/tone@14.7.58,npm/@magenta/music@1.23.1/es6/core.js,npm/focus-visible@5,npm/html-midi-player@1.4.0"></script>-->
<script src="tone.js"></script>
<script src="core.js"></script>
<script src="focus-visible.js"></script>
<script src="html-midi-player.js"></script>
<script>
    core.urlToNoteSequence("<?if (isset($_GET['file'])) {echo "./midis/".$_GET["file"];
        } else {
        echo "./usermidis/".$_GET["ufile"];
}
?> ").then(n=>{
document.getElementById("midinotes").innerText = "音符数量：" + n.notes.length;
midiNotesArray = n.notes
})
</script>
<script src="teasMidiPlayer.js"></script>