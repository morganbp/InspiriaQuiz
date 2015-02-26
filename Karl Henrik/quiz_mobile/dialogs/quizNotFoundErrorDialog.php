<style>
    #dialogTitleBar{
        background: -webkit-linear-gradient(grey, lightblue, white);
        background: -o-linear-gradient(grey, lightblue, white);
        background: -moz-linear-gradient(grey, lightblue, white);
        background: linear-gradient(grey, lightblue, white);
    }
    
    #dialogContent{
         background: -webkit-linear-gradient(white, lightblue, grey);
        background: -o-linear-gradient(white, lightblue, grey);
        background: -moz-linear-gradient(white, lightblue, grey);
        background: linear-gradient(white, lightblue, grey);
    }
    
</style>
<div data-role="dialog" data-close-btn="none"  id="errorQuizNotFoundDialog" style="text-align: center;">
    <div data-role="header" data-icon="false" id="dialogTitleBar">
        <h1 class="ui-title" >Quizen eksisterer ikke</h1>
    </div>
    <div data-role="content" class="ui-border" id="dialogContent">
        <p>Vi klarte ikke finne denne quizen, er du sikker på at du skrev inn riktig quiz id?</p>
        <a href="#" data-rel="back" class="ui-btn ui-corner-all" >Lukk</a>
    </div>
</div>