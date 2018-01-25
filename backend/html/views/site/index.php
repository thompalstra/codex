<i class="material-icons">format_italic</i>

<div class='dt dt-default' style='background-image: url( http://www.wallpapereast.com/static/images/waterdrops-bright-hd-wallpaper-507074.jpg )'>

    <ul class='shortcuts shortcuts-default'>
        <div class='wrapper'>
        <a href="/tools/notepad">
            <li class='shortcut shortcut-default'>
                <label icon='format_italic'>Notepad</label>
            </li>
        </a>
        </div>
    </ul>

    <div class='frames frames-default'></div>

    <ul class='taskbar taskbar-default bottom left right'>
        <li class='item item-default'><label icon='home' style='padding: 0;'></label>
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
    </ul>

</div>
<script>


    window['Frame'] = Frame = function( frames ){
        this.frames = frames;
        this.element = document.createElement('div');
        this.element.className = 'frame frame-default';
    }
    extend(Frame).with({
        open: function( url ){
            this.element.setAttribute('co-url', url );
            var success = function( resp ){

                this.element.find().all('script').forEach(function(script){
                    var result = function( script ){
                        return eval( script );
                    }.call(this, script.innerHTML);
                }.bind(this));

                var minimize = this.element.find().one('.bar-actions .action[type="minimize"]');

                if( minimize ){
                    minimize.listen('click',function(e){
                        this.minimize();
                    }.bind(this));
                }

                var toggle = this.element.find().one('.bar-actions .action[type="toggle"]');

                if( toggle ){
                    toggle.listen('click',function(e){
                        this.toggle();
                    }.bind(this));
                }

                var dismiss = this.element.find().one('.bar-actions .action[type="dismiss"]');

                if( dismiss ){
                    dismiss.listen('click',function(e){
                        this.dismiss();
                    }.bind(this));
                }
            }.bind(this)
            var error = function( err ){
            }.bind(this)
            this.element.load( url, success, error );
        },
        minimize: function(){
            this.element.attr('minimized', '');
        },
        maximize: function(){
            this.element.attr('maximized', '');
        },
        show: function(){
            this.element.attr('minimized', null);
        },
        toggle: function(){
            if( this.element.attr('maximized') == '' ){
                this.element.attr('maximized', null);
            } else {
                this.element.attr('maximized', '');
            }
        },
        dismiss: function(){
            this.taskbarItem.remove();
            this.remove();
        },
        remove: function(){
            this.frames.collection.splice( this.frames.collection.indexOf(this) , 1);
            this.element.remove();
        },

        focusin: function(){
            console.log('focusin');
            this.element.attr('focused', '');
            this.taskbarItem.focusin();
        },
        focusout: function(){
            console.log('focusout');
            this.element.attr('focused', null);
            this.taskbarItem.focusout();
        }

    })


    window['Frames'] = Frames = function( element, desktop ){
        this.element = element;
        this.collection = [];
        this.desktop = desktop;
    }

    extend(Frames).with({
        add: function( frame ){
            this.element.appendChild( frame.element );
            this.collection.push( frame );
            this.desktop.dispatch( new CustomEvent( 'addedFrame', {
                cancelable: true,
                bubbles: true
            }) );
        }
    })

    window['Taskbar'] = Taskbar = function( element, desktop ){
        this.element = element;
        this.collection = [];
        this.desktop = desktop;
    }

    extend(Taskbar).with({
        update: function(){
            this.desktop.frames.collection.forEach(function(frame){
                if( typeof frame.taskbarItem == 'undefined' ){
                    var element = document.createElement('li');
                    element.className = 'item item-default';
                    element.innerHTML = "<label>test</label>";
                    this.desktop.taskbar.add( new TaskbarItem( element, this, frame ) );
                }
            }.bind(this))
        },
        add: function( taskbarItem ){
            this.element.appendChild( taskbarItem.element );
            this.collection.push( taskbarItem );
            this.desktop.frames.element.style['bottom'] = document.find().one('.taskbar').offsetHeight;
        }
    })

    window['TaskbarItem'] = TaskbarItem = function( element, taskbar, frame ){
        this.element = element;
        this.taskbar = taskbar;
        this.frame = frame;

        this.element.listen('click', function( event ){
            if( this.frame.element.attr('minimized') == '' ){
                this.frame.show();
                this.frame.focusin();
            } else {
                this.frame.minimize();
                this.frame.focusout();
            }
        }.bind(this));

        frame.taskbarItem = this;
    }

    extend(TaskbarItem).with({
        remove: function(){
            this.taskbar.collection.splice( this.taskbar.collection.indexOf(this) , 1);
            this.element.remove();
        },
        focusin: function(){
            this.element.attr('focused', '');
        },
        focusout: function(){
            this.element.attr('focused', null);
        }
    })

    window['Desktop'] = Desktop = function( querySelector ){
        this.element = document.find().one( querySelector );
        this.frames = new Frames( this.element.find().one('.frames'), this );
        this.taskbar = new Taskbar( this.element.find().one('.taskbar'), this );

        this.element.listen('click', '.shortcuts a', function(e,t){
            event.preventDefault();
            var frame = new Frame( this.frames );
            frame.open( t.getAttribute('href') );
            this.frames.add( frame );
        }.bind(this));

        this.listen('addedFrame', function( event ){
            this.taskbar.update();
        })
        this.element.listen('click', function(e){
            var closest = e.target.closest('.frame');
            if( !e.target.matches('.taskbar .item') && !e.target.matches('.taskbar .item *') ){
                this.frames.collection.forEach(function(frame){
                    if( frame.element === closest ){
                        frame.focusin();
                    } else {
                        frame.focusout();
                    }
                });
            }

        }.bind(this));
    }

    extend(Desktop).with({
        dispatch: function( event ){
            var eventType = 'on' + event.type.charAt(0).toUpperCase() + event.type.slice(1);
            if( typeof this[eventType] == 'object' && this[eventType].length > 0 ){
                for(var i=0;i<this[eventType].length;i++){
                    var callable = this[eventType][i];
                    callable.call(this, event);
                }
            }
        },
        listen: function( event, callable ){
            var eventType = 'on' + event.charAt(0).toUpperCase() + event.slice(1);
            if( this[eventType] != 'object' ){
                this[eventType] = [];
            }
            this[eventType].push(callable);
        }
    })

    var desktop = new Desktop( '.dt' );

    document.listen('click', '.dt .taskbar .item', function( event ){
        var ul = this.find().one('ul');
        if( ul ){
            this.toggleAttr('open', '');
        }
        event.stopPropagation();
        this.focus();
    });
    // document.listen('click', '.dt .frames .frame', function( event ){
    //     event.stopPropagation();
    //     document.find().all('.dt .frames .frame[focused]').forEach( function(el){
    //         el.attr('focused', null);
    //     } );
    //     this.attr('focused', '');
    // });
    document.listen('click', '.dt .frames .frame [class="action"]', function( event ){
        var type = this.attr('type');
        switch(type){
            case 'toggle':

            break;
            case 'dismiss':

            break;
            case 'minimize':
            break;
        }
    })
    document.listen('mousedown', '.dt .frames .frame:not([maximized]) .title-bar', function( event ){
        console.log('mousedown');
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
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
    }

    .dt .frames .frame{
        position: absolute;
        max-width: 100%;
        max-height: 100%;

        min-height: 50px;
        z-index: 500;

        top: 0;
    }

    .dt .frames .content,
    .dt .frames .title-bar{
        min-width: 100%;
    }

    .dt .frames .frame[co-allow-resize="true"]{
        resize: both;
        overflow: auto;
    }

    .dt .frames .frame-default{
        resize: both;
        overflow: auto;
        background-color: #ddd;

        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.1);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.1);
    }

    .dt .frames .frame[maximized]{
        width: 100% !important;
        height: 100% !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
    }
    .dt .frames .frame[minimized]{
        visibility: hidden;
        pointer-events: none;
    }

    .dt .frames .frame-default[dragging],
    .dt .frames .frame-default[focused]{
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.4);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.4);
        box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.4);
        z-index: 550;
    }

    .dt .frames .frame .title-bar{
        -webkit-user-select: none;  /* Chrome all / Safari all */
        -moz-user-select: none;     /* Firefox all */
        -ms-user-select: none;      /* IE 10+ */
        user-select: none;          /* Likely future */
    }

    .dt .frames .frame-default .title-bar{
        background-color: black;
        color: white;
        display: inline-block;
    }
    .dt .frames .frame-default .content{
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
        position: absolute;
        z-index: 1000;
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
    .dt .taskbar .item:hover,
    .dt .taskbar .item[focused]{
        background-color: rgba(255,255,255,.15);
    }
    .dt .taskbar .item.item-default{
        min-height: 50px;
        min-width: 50px;
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
        padding: 0 10px;
    }
    .dt .taskbar .item label[icon]{
        padding: 0 10px;
    }

    .dt .taskbar .item label[icon]:before{
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
        height: 100%;
    }

    .dt .shortcuts.shortcuts-default{
    }
    .dt .shortcuts .shortcut{

    }

    .dt .shortcuts .wrapper{
        padding: 10px;
        position: relative;
        z-index: 500;
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
