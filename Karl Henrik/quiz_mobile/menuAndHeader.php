<div data-role=panel data-position=left data-display=overlay id=sidepanel>;
    <!--The menu-->
    <div data-role="listview">
        <!-- closing sidepanel -->
        <li id="btnCloseSidepanel" data-rel="close"  data-iconpos="notext" data-icon="back" ><a href="#titleHeader"></a></li>
        <!-- placeholder -->
        <li style="margin-top:100px; border:0px;"></li>
        <!-- menu -->
        <li data-icon="false" ><a href="#homeScreen">Hjem</a></li>
        <li data-icon="false" ><a href="#">Empty1</a></li>
        <li data-icon="false" ><a href="#">Empty2</a></li>
        <li data-icon="false" ><a href="#">Empty3</a></li>
    </div>
</div>
<header data-role="header" id="titleHeader">
    <h1 style="text-align:center; white-space:normal;">Inspiria quiz</h1>
    <a href="#sidepanel" data-icon="bars" class="ui-btn-left" data-iconpos="notext"></a>
</header>