function setQuizmode(quizmode){
    switch(quizmode){
        case 1:
            
            break;
            
        case 2:
            $( ":mobile-pagecontainer" ).pagecontainer( "load", 'quizSchoolOrBusinessQuizKey.html', { showLoadMsg: false } );
            
            $("#content").html($(":mobile-pagecontent").html);
            break;
            
        case 3:
            
            break;
    }
}