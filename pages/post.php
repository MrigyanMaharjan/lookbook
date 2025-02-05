<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img id="img" src="" style="display: none;" alt="">
    <input type="file" name="file" id="file">
</body>
</html>
<script>
    var input=document.querySelector("#file");
    input.addEventListener("change",preview);
    function preview(){
        console.log(this.files[0])
        var fileobject=this.files[0];
        var filereader= new FileReader();
        filereader.readAsDataURL(fileobject);
        filereader.onload=function(){
            var filesrc=filereader.result;
            var img=document.getElementById("img");
            img.setAttribute("src",filesrc);
            img.setAttribute("style",'display:flex')

        }
        

    }

</script>