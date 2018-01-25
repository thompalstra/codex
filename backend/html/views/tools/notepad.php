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
    <form class='form'>
        <input type="hidden" name="content"/>
        <div name="fake-content" contenteditable="true">
            hello
        </div>
    </form>
</div>
<script>
    this.values = [];

    this.element.find().one('.form').elements.forEach(function(el){
        this.values[ el.name ] = el.value;
    }.bind(this));
    
    this.element.find().one("[name='fake-content']").listen('keyup', function(e){
        var content = this.find().one("[name='content']");
        content.value = this.innerHTML;
    }.bind(this.element));
</script>
