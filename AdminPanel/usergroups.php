<html>
<head>
    <title>Inspiria Quiz Admin</title>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='styles/style.css'/>
    <link rel='stylesheet' type='text/css' href='styles/flaticon/flaticon.css'/>
    <script src="../AdminPanel/jquery-2.1.3.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#link-textbox").focus(function() { $(this).select(); } );
        });
        function generateLink(){
            $.ajax({
                url: "link_generator.php",
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus);
                    alert("Kunne ikke generere ny link.");
                },
                success: function(data){
                    console.log(data);
                    console.log(data.RegistrationPath);
                    
                    $("#link-textbox").val(data.RegistrationPath);
                    $("#link-displayer").slideDown();
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
                    <?php $activepage = 'usergroups.php'; ?>
                    <?php include 'nav.php'; ?>
                </ul>
            </nav>
        </div>
        <div class='content'>
            <h1>Grupper</h1>
            <p>Her genererer du linker til registrering av grupper.</p>
            
            <div class='panel'>
                <div class='panel-header'>Generer ny link</div>
                <div class='panel-body'>
                    <div id="link-displayer">
                        <input id="link-textbox" type="text" />
                    </div>
                    <button type="button" onclick="generateLink()">Generer</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

