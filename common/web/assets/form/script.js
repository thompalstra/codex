extend(HTMLFormElement).with({
    validate: function( event ){
        this.elements.validate();
        return this.checkValidity() ;
    },
});
extend(HTMLFormControlsCollection).with({
    validate: function( event ){
        this.forEach( function( el ){
            el.validate();
        } );
    }
});
extend(Element).with({
    validate: function( event ){

        var label = this.nextElementSibling;

        if( label != null && label.tagName.toLowerCase() == 'message' ){
            label.remove();
        }

        if( !this.checkValidity() ){

            this.attr('invalid', '');

            if( message = this.attr('title') ){
                this.setCustomValidity( message );
            }
            var messageElement = document.createElement('message');
            messageElement.innerHTML = this.validationMessage;
            messageElement.attr('co-type', 'form');

            this.parentNode.insertBefore(messageElement, this.nextSibling);

        } else {
            this.attr('invalid', null);
        }
    },
});

document.listen('input', 'form[co-validate="change"]', function( event ){
    if( this.validate() != true ){
        event.preventDefault();
    }
})
document.listen('submit', 'form[co-validate="submit"]', function( event ){
    if( this.validate() != true ){
        event.preventDefault();
    }
})
