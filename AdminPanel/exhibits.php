<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    <script src="jquery-2.1.3.js"></script>
    
    <script type="text/javascript">
        var optionList = "<option value='-1'>Ingen bilde valgt</option>";
        
        $( document ).ready(function() {
            fetchImages();
        });
        
        function deleteExhibit(exhibitID){
            $.ajax({
                //url: "http://localhost/InspiriaQuiz/API/exhibits_delete.php",
                url: "http://frigg.hiof.no/bo15-g21/API/exhibits_delete.php",
                type: "POST",
                data: {ExhibitID: exhibitID},
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(errorThrown);
                    alert("Stasjonen kunne ikke bli slettet.");
                },
                success: function(data){
                    console.log(data);
                    location.reload();
                }
            });
        }
        
        function fetchImages(){
            $.ajax({
                url: "http://frigg.hiof.no/bo15-g21/API/images_get.php",
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert("Images not found.");
                },
                success: function(images){
                    for(var i=0; i<images.length; i++){
                        optionList += "<option value='" + images[i].ImageID + "'>"
                            +images[i].ImageName
                            +"</option>";
                    }
                    $("#exhibit-image").html(optionList);
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
                    <?php $activepage = 'exhibits.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Stasjoner</h1>
            <p>Her administreres stasjonene på Inspiria.</p>
            
            <div class='panel'>
                <div class='panel-header'>Ny stasjon</div>
                <div class='panel-body'>
                    <form action="../API/exhibits_post.php" method="POST" id='exhibit-create'>
                        <select id="exhibit-image" name="ImageID"></select>
                        <input type="text" name="ExhibitName" placeholder="Stasjonsnavn" />
                        <input type="text" name="ExhibitDescription" placeholder="Beskrivelse" />
                        <input type="submit" value="Opprett"></input>
                    </form>
                </div>
            </div>
            <div class='panel'>
                <div class='panel-header'>Stasjoner</div>
                
                <table id='quiz-list'>
                    <tr class='quiz-top'>
                        <th class='image-preview'>Bilde</th>
                        <th class='title'>Tittel</th>
                        <th class='description'>Beskrivelse</th>
                        <th class='delete'>Slett</th>
                    </tr>
                    <?php
                    // Get the quizes and feed it into the table
                    //$jsonString = file_get_contents('http://localhost/InspiriaQuiz/API/exhibits_get.php');
                    $jsonString = file_get_contents('http://frigg.hiof.no/bo15-g21/API/exhibits_get.php');
                    $jsonExhibits = json_decode($jsonString);

                    foreach($jsonExhibits as $json){
                        echo '<tr class="quiz-single">';
                            echo '<td class="image-preview"><img class="image-thumbnail" src="../UploadedImages/'.$json->ImageFilename.'"/></td>';
                            echo '<td class="title">'.$json->ExhibitName.'</td>';
                            echo '<td class="description">'.$json->ExhibitDescription.'</td>';
                            echo '<td class="delete"><i class="flaticon-cross93" onclick="deleteExhibit('.$json->ExhibitID.')"></i></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                
            </div>
        </div>
    </div>
</body>
</html>