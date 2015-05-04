<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    <script src="jquery-2.1.3.js"></script>
    
    <script type="text/javascript">
        function deleteImage(imageID){
            $.ajax({
                url: "http://localhost/InspiriaQuiz/API/images_delete.php",
                type: "POST",
                data: {ImageID: imageID},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                    alert("Bildet kunne ikke bli slettet.");
                },
                success: function(data){
                    console.log(data);
                    location.reload();
                }
            });
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div id='container'>
        <div class='sidebar'>
            <nav>
                <ul id='nav'>
                    <?php $activepage = 'image_upload.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Last opp bilder</h1>
            <p>Bildene du laster opp her kan brukes i quizer.</p>
            
            <div class='panel'>
                <div class='panel-header'>Last opp</div>
                <div class='panel-body'>
                    <form enctype="multipart/form-data" action="../API/image_uploader.php" method="POST">
                        <input type="text" name="ImageName" />
                        <input type="file" name="ImageFile" accept="image/*" />
                        <input type="submit" value="Last opp"></input>
                    </form>
                </div>
            </div>
            <div class='panel'>
                <div class='panel-header'>Opplastede bilder</div>
                
                <table id='quiz-list'>
                    <tr class='quiz-top'>
                        <th class='quiz-list-image-preview'>Forhåndsvisning</th>
                        <th class='quiz-list-image-title'>Tittel</th>
                        <th class='quiz-list-image-delete'>Slett</th>
                    </tr>
                    <?php
                    // Get the quizes and feed it into the table
                    $jsonString = file_get_contents('http://localhost/InspiriaQuiz/API/images_get.php');
                    $jsonQuiz = json_decode($jsonString);
                    //var_dump($jsonQuiz);

                    foreach($jsonQuiz as $json){
                        echo '<tr class="quiz-single">';
                            echo '<td class="quiz-list-image-preview"><img class="image-thumbnail" src="../UploadedImages/'.$json->ImageFilename.'"/></td>';
                            echo '<td class="quiz-list-image-title">'.$json->ImageName.'</td>';
                            echo '<td class="quiz-list-image-delete"><button type="button" onClick="deleteImage('.$json->ImageID.')">Slett</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                
            </div>
        </div>
    </div>
</body>
</html>