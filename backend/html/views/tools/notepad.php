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
<ul class='toolstrip top'>
    <li class='item item-default'>
        File
        <ul class='toolstrip'>
            <li class='item item-default' icon='create'>New</li>
            <li class='item item-default' icon='insert_drive_file' dt-frame-open dt-frame-url="/tools/browser?table=notepad&model=\">Open</li>
        </ul>
    </li>

</ul>
<div class='content'>
    <form class='form'>
        <input type="hidden" name="content"/>
        <div name="fake-content" contenteditable="true">
            hello
        </div>
    </form>
</div>
<script>
</script>
