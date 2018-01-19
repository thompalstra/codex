// document.find().all('.nav li[dropdown]')

document.listen('click', '.nav li[dropdown]', function( event ){
    // event.preventDefault();
    // event.stopPropagation();

    // console.log( this );

    if( this.attr('co-is-toggled') == '' ){

        this.attr('co-is-toggled', null);
    } else {
        this.attr('co-is-toggled', '');
    }
})
