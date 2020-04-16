<?php
    function searchFileType($type,$file){
        switch($type){
            case 'dir':{$res = (is_dir($file)) ? true : false;}break;
            case 'file':{$res = (!is_dir($file)) ? true : false;}break;
            default:{$res = false;}
        }
        return $res;
    }

    function searchInFolder($folder,$searchType=""){

        $folderList = [];
        $missingFolderMsg = "Folder <b>".$folder."</b> is missing!";
        $openFolderErr = "It's not possible to open folder <b>".$folder."</b>!";

        if(!searchFileType("dir",$folder)){exit($missingFolderMsg);}
        $resource = opendir($folder) or die($openFolderErr);

        while(($file = readdir($resource)) !== FALSE){
            $localCond = (!in_array($file,array(".",".."))) ? true : false;
            $sameFileCond = ($file != 'fileExplorer.php') ? true : false;
            $dirCond = true;
            if($searchType){
                switch($searchType){
                    case 'dir':{$dirCond = (searchFileType("dir",$file)) ? true : false;}break;
                    case 'file':{$dirCond = (!searchFileType("dir",$file)) ? true : false;}break;
                    default:{$dirCond = false;}
                }
            }
            if($localCond && $sameFileCond && $dirCond){$folderList[] = $file;}
        }
        closedir();
        return $folderList;
    }

    function dataExtraction($folder){
        $folderList = $fileList = $dataList = [];

        $folderList = searchInFolder($folder,"dir");
        if(!empty($folderList)){
            foreach($folderList as $f){
                $fileList["".$f.""] = searchInFolder($f,"file");
            }
            if(!empty($fileList)){
                foreach($fileList as $n => $c){
                    foreach($c as $fn){
                        $ext = str_replace(substr($fn,0,strpos($fn,".")),"",$fn);
                        $ext = substr($ext,1,strlen($ext));
                        $fileName = str_replace(".".$ext,"",$fn);
                        $filePath = $n."/".$fn;
                        $dataList["".$n.""][] = array("extension" => $ext,"name" => $fileName,"size" => (filesize($filePath)/1000)." Kb");
                    }
                }
            }
        }

        $singleFilesList = searchInFolder($folder,"file");
        if(!empty($singleFilesList)){
            foreach($singleFilesList as $sf){
                $ext = str_replace(substr($sf,0,strpos($sf,".")),"",$sf);
                $ext = substr($ext,1,strlen($ext));
                $fileName = str_replace(".".$ext,"",$sf);
                $filePath = $sf;
                $dataList["".$folder.""][] = array("extension" => $ext,"name" => $fileName,"size" => (filesize($filePath)/1000)." Kb");
            }
        }

        return $dataList;
    }

    function graphicRepresentation($data=""){

        $graphicContent = [];
        $availableImgFormat = ['jpg','png','tiff'];
        $availableDocFormat = ['doc','docx','pdf'];
        
        if(!empty($data)){
            foreach($data as $n => $dblock){
                foreach($dblock as $d){
                    $ext = isset($d["extension"]) ? $d["extension"] : "";
                    $name = isset($d["name"]) ? $d["name"] : "";
                    $size = isset($d["size"]) ? $d["size"] : "";
                    $graphicContent[] = array(
                        "ext" => $ext
                        ,"name" => $name
                        ,"size" => $size
                        ,"folder" => $n
                    );
                }
            }
        }

        $graphicResult = "
            <div class='tableClass'>
                <div class='tableCell titleCell extCell'>EXT</div>
                <div class='tableCell titleCell fileNameCellTitle'>File name</div>
                <div class='tableCell titleCell fileSizeTitleCell'>File size</div>
                <div class='tableCell lastCellTitle titleCell'>Folder</div>
                <div class='clearDiv'></div>
                <div class='tableContent'>
        ";

        if(!empty($graphicContent)){
            foreach($graphicContent as $k => $gc){
                $ext = isset($gc['ext']) ? $gc['ext'] : "-";

                if(in_array($ext,$availableImgFormat)){$ref = 'image';}
                if(in_array($ext,$availableDocFormat)){$ref = 'document';}
                
                $name = isset($gc['name']) ? $gc['name'] : "-";
                $size = isset($gc['size']) ? $gc['size'] : "-";
                $folder = isset($gc['folder']) ? $gc['folder'] : "-";
                $completePath = $folder."/".$name.".".$ext;
                $graphicResult .= "
                    <div class='tableCell extCell'>".$ext."</div>
                    <div class='tableCell fileNameCell'>
                ";
                switch($ref){
                    case'image':{
                        $graphicResult .= "<a href='javascript:openFile(\"".$completePath."\");'>".$name."</a>";
                    }break;
                    case'document':{
                        $graphicResult .= "<a href='".$completePath."' target='_blank'>".$name."</a>";
                    }break;
                }
                $graphicResult .= "
                    </div>
                    <div class='tableCell fileSizeCell'>".$size."</div>
                    <div class='tableCell lastCell'>".$folder."</div>
                    <div class='clearDiv'></div>
                ";
            }
        }
        
        $graphicResult .= "
                </div>
            </div>
        ";

        echo $graphicResult;
    }

    function pageBuild($folder){
        $dataList = dataExtraction($folder);
        graphicRepresentation($dataList);
    }

    function detailShow($filePath){
        $ext = substr($filePath,(strpos($filePath,".")+1),strlen($filePath));
        $folderName = substr($filePath,0,strpos($filePath,"/"));
        $fileName = substr($filePath,(strpos($filePath,"/")+1),strlen($filePath));
        
        $availableImgFormat = ['jpg','png','tiff'];
        $availableDocFormat = ['doc','docx','pdf'];

        if(in_array($ext,$availableImgFormat)){$fileType = 'image';}
        if(in_array($ext,$availableDocFormat)){$fileType = 'document';}

        $detailRepresentation = "<div class='detailContainer'>";

        switch($fileType){
            case'image':{
                $detailRepresentation .= "<img class='detailImage' id='detailImage_".$filePath."' src='".$filePath."' alt='".$fileName."' title='Folder name: ".$folderName."\nFile name: ".$fileName."\n\nClick to close' />";
            }break;
            case'document':{

            }break;
            default:{}break;
        }

        $detailRepresentation .= "</div>";

        echo $detailRepresentation;

    }

?>
<html>
    <head>
        <title>Folder Explorer</title>
        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
        <style>
            .clearDiv{clear:both}
            
            .tableClass{
                border-left:1px solid black;
                border-top:1px solid black;
                border-bottom:1px solid black;
                border-right:1px solid black;
                width:80%;
                height:580px;
                margin-left:10%;
            }
            .tableContent{
                background-color:azure;
                height:528px;
                overflow:auto;
            }
            .titleCell{
                background-color:yellow;
                font-weight:bold;
            }
            .tableCell{
                border-bottom:1px solid black;
                border-right:1px solid black;
                width:24.93%;
                height: 50px;
                float:left;
                text-align:center;
            }
            .lastCell,.lastCellTitle{
                border-right:0px solid black;
                border-bottom:1px solid black;
            }
            .lastCellTitle{
                width:25.75%;
            }
            .extCell{
                width:10%;
            }
            .fileNameCell{
                text-align:left;
                width:39.85%;
            }
            .fileNameCellTitle{
                text-align:left;
                width:39.25%;
            }
            .fileNameCell a{
                color:green;
            }
            .fileNameCell a:hover{
                color:greenyellow;
            }
            .fileSizeTitleCell{
                text-align:left;
                width:24.7%;
            }

            .detailContainer{
                border:1px solid black;
                background-color:azure;
                width:80%;
                margin-left:10%;
                box-shadow: 2px 2px 0px 0px black;
            }
            .detailImage{
                width:100%;
                cursor: pointer;
            }
        </style>        
    </head>
    <body>

        <form id="formFileExplorer" name="formFileExplorer" method="POST" action="#">
            <input type="hidden" id="filePath" name="filePath" value="" />
        </form>

<?php
    $folder = ".";
    $filePath = isset($_REQUEST["filePath"]) ? $_REQUEST["filePath"] : "";
    if($filePath){detailShow($filePath);}
    else{pageBuild($folder);}
?>

    </body>
</html>

<script>
    function openFile(path){
        $('#filePath').val(path);
        $('#formFileExplorer').submit();
    }
    $('.detailImage').on('click',function(){document.location.href='fileExplorer.php';});
</script>