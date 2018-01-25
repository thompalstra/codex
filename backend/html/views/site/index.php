<i class="material-icons">format_italic</i>

<div class='dt dt-default' style='background-image: url( http://www.wallpapereast.com/static/images/waterdrops-bright-hd-wallpaper-507074.jpg )'>

    <ul class='shortcuts shortcuts-default'>
        <div class='wrapper'>
        <a href="">
            <li class='shortcut shortcut-default'>
                <label icon='format_italic'>Notepad</label>
            </li>
        </a>
        </div>
    </ul>

    <ul class='taskbar taskbar-default bottom left right'>
        <li class='item item-default'><label icon='home'></label>
            <ul class='taskbar taskbar-default'>
                <li class='item item-default'><label icon='more_horiz'>Programs</label>
                    <ul class='taskbar taskbar-default'>
                        <li class='item item-default'>
                            <label icon='format_italic'>Notepad</label>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class='item item-default'>
            <label>Notepad</label>
        </li>
    </ul>

    <div class='frames frames-default'>
        <div class='frame frame-default' co-allow-resize="true" style='width:400px;height:250px'>
            <div class='title-bar'>
                <div class='title'>
                    Notepad
                </div>
                <div class='bar-actions'>
                    <button class='action' type='minimize' icon='keyboard_arrow_left'></button>
                    <button class='action' type='toggle' icon='fullscreen'></button>
                    <button class='action' type='dismiss' icon='close'></button>
                </div>
            </div>
            <div class='content'>
                hello
            </div>
        </div>
    </div>

</div>
<script>
    document.listen('click', '.dt', function( event ){
        document.find().all('.dt .frames .frame[focused]').forEach( function(el){
            el.attr('focused', null);
        } )
    });
    document.listen('click', '.dt .taskbar .item', function( event ){
        var ul = this.find().one('ul');
        if( ul ){
            this.toggleAttr('open', '');
        }
        event.stopPropagation();
        this.focus();
    });
    document.listen('click', '.dt .frames .frame', function( event ){
        document.find().all('.dt .frames .frame[focused]').forEach( function(el){
            el.attr('focused', null);
        } )
        this.attr('focused', '');
    });
    document.listen('mousedown', '.dt .frames .frame .title-bar', function( event ){
        var frame = this.closest('.frame');
        frame.attr('dragging', '');

        frame.attr('offset-x', event.pageX - frame.offsetLeft);
        frame.attr('offset-y', event.pageY - frame.offsetTop);
    })
    document.listen('mouseup mouseleave', '.dt .frames .frame', function( event ){
        this.attr('dragging', null);
    })
    document.listen('mousemove', '.dt', function( event ){
        var frame = this.find().one('[dragging]');
        if( frame = this.find().one('[dragging]') ){
            var x = event.pageX - this.offsetLeft;
            var y = event.pageY - this.offsetTop;

            var relX = x - frame.attr('offset-x');
            var relY = y - frame.attr('offset-Y');

            frame.css({
                'top': relY,
                'left': relX
            });
        }


    });
</script>
<style>

    .dt .frames{
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
    }
    .dt .frames .frame{
        position: absolute;
        max-width: 100%;
        max-height: 100%;

        min-height: 50px;
    }

    .dt .frames .content,
    .dt .frames .title-bar{
        min-width: 100%;
    }

    .dt .frames .frame[co-allow-resize="true"]{
        resize: both;
        overflow: auto;
    }
    .dt .frames .frame-default[focused]{
        opacity: 1;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.4);
    }
    .dt .frames .frame-default[dragging]{
        opacity: .8;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
    }

    .dt .frames .frame-default .title-bar{
        background-color: black;
        color: white;
        display: inline-block;
    }
    .dt .frames .frame-default .content{
        background-color: #ddd;
        display: inline-block;
        min-height: calc(100% - 50px );
    }


    .dt .frames .frame-default .title{
        height: 50px;
        line-height: 50px;
        font-size: 11px;
        padding: 0 10px;
        float: left;
    }

    .dt .frames .frame-default .bar-actions .action{
        height: 50px;
        line-height: 50px;
        border: 0;
        background-color: transparent;
        color: inherit;
        padding: 0; margin:0;
        font-size: 11px;
    }

    .dt .frame .bar-actions{
        float: right;
    }

    .dt .frame .bar-actions.bar-actions-default .action[icon]:before{

    }

    .dt{
        display: table;
        height: 100%;
        width: 100%;

        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-position: center;
        background-size: cover;
    }
    .dt.dt-default{

    }

    .dt .taskbar{
        list-style: none;
        padding: 0; margin: 0;
        display: table-row;
    }
    .dt .taskbar.taskbar-default{
        min-height: 50px;
    }

    .dt .taskbar.taskbar-default{
        background-color: rgba(0,0,0,.6);
    }

    .dt .taskbar.taskbar-default .taskbar.taskbar-default{
        background-color: rgba(0,0,0,.8);
    }

    .dt .taskbar .item{
        float: left;
        position: relative;
        white-space: nowrap;
    }
    .dt .taskbar .item.item-default{
        min-height: 50px;
        line-height: 50px;

        color: white;
    }
    .dt .taskbar .item.item-default i{
        width: 50px;
        height: 50px;
        line-height: 50px;
        float: left;
        text-align: center;
    }
    .dt .taskbar .item.item-default label{
        /* padding: 0 10px 0 0;*/
        padding: 0 10px 0 0;
    }
    .dt .taskbar .item label[icon]{
        padding: 0 10px 0 60px;
    }

    .dt .taskbar .item label[icon]:before{

        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;

        width: 50px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        float: left;
    }
    .dt .frame .action[icon]:before,
    .dt .shortcuts .shortcut label[icon]:before,
    .dt .taskbar .item label[icon]:before{

        content: attr(icon);
        font-family: 'Material Icons';
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-feature-settings: 'liga';
        -webkit-font-smoothing: antialiased;
    }

    .dt .shortcuts .shortcut label[icon]:before{
        width: 80px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        float: left;
    }

    .dt .shortcuts .shortcut-default:hover{

    }

    .dt .taskbar .item:not([open]) .taskbar{
        visibility: hidden;
    }
    .dt .taskbar .item .taskbar{
        position: absolute;
        bottom: 100%;
    }

    .dt .taskbar .item .taskbar .item .taskbar{
        bottom: 0;
        left: 100%;
    }

    .dt .taskbar .item .item{
        width: 200px;
    }

    .dt .shortcuts{
        list-style: none;
        padding: 0; margin: 0;
        display: table-row;
        height: 100%;
    }

    .dt .shortcuts.shortcuts-default{
    }
    .dt .shortcuts .shortcut{

    }

    .dt .shortcuts .wrapper{
        padding: 10px;
    }

    .dt .shortcuts a{
        text-decoration: none;
    }
    .dt .shortcuts label{
        cursor: pointer;
    }

    .dt .shortcuts .shortcut-default{
        transition: all 250ms linear;
        width: 80px;
        height: 80px;
        text-align: center;

        background-color: rgba(0,0,0,0);
        border: 1px solid rgba(0,0,0,0);
        box-sizing: border-box;
    }
    .dt .shortcuts .shortcut-default:hover{
        background-color: rgba(0,0,0,.2);
        border: 1px solid rgba(0,0,0,.2);
        box-sizing: border-box;

    }
</style>
