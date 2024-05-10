<?php

if(isset($_FILES['midifile'])){
    $errors= array();
    $file_name = $_FILES['midifile']['name'];
    $file_tmp = $_FILES['midifile']['tmp_name'];
    $name_arr = explode('.',$_FILES['midifile']['name']);
    $file_ext=strtolower(end($name_arr));
        
    $extensions= array("mid");
    /* 规定可以上传的扩展名文件 */
    if(in_array($file_ext,$extensions)=== false){
        $errors[]="不允许扩展，请选择一个mid文件。";
    }
    /* 规定可以上传的文件大小 */
    if($file_size > 2097152) {
        $errors[]='文件大小必须不超过2 MB';
    }

    if(empty($errors)==true) {
        /* 把图片从临时文件夹内的文件移动到当前脚本所在的目录 */
            move_uploaded_file($file_tmp,"./".$file_name);
            echo "成功上传";
    }else{
            print_r($errors);
    }
}
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
            <br>
            <form action="" method="POST" enctype = "multipart/form-data">
                <input type="file" name="midifile" />
                <input type = "submit" name="提交" value="点击上传" />
            </form>
            
        </center>
        <hr>
        <h3>Midi文件列表</h3>
        <nav>该页面均为客户自行上传的Midi文件</nav>
        <nav>善用浏览器搜索功能（Ctrl+F），快速定位midi文件！</nav>
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
                
                if($dh = opendir("./")){
                    while(($file = readdir($dh))!==false){
                        
                        if(pathinfo($file)['extension']=="mid"){
                            echo "
                                <tr>
                                    <td>". $file ."</td>
                                    <td>". number_format(filesize("./".$file)/1024 , 2) ."KB</td>
                                    <td>". date('Y-m-d H:i:s',filemtime("./".$file)) ."</td>
                                    <td><a href='../play.php?ufile={$file}'>试听</a></td>
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