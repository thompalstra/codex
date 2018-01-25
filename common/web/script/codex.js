window['codex'] = function( arg ){

}

window['extend'] = function(){
    var extend = {};
    extend.list = arguments;
    extend.with = function( arg ){
        for(var a in arg){
            for(b=0;b<this.list.length;b++){
                if(
                    this.list[b].hasOwnProperty('prototype') &&
                    this.list[b].prototype.hasOwnProperty('constructor') &&
                    this.list[b].prototype.constructor.hasOwnProperty('name') &&
                    this.list[b].prototype.constructor.name.length > 0
                ){
                    this.list[b].prototype[a] = arg[a];
                } else {
                    this.list[b][a] = arg[a];
                }
            }
        }
    }
    return extend;
}

window['require'] = function( path ){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', path, false);
    xhr.send();
    if( xhr.readyState == 4 ){
        if( xhr.status == 200 ){
            var exports = {};
            eval(xhr.response);
            return exports;
        }
    }
}

extend( codex ).with({
    title: function( str ){
        document.querySelectorAll('title').forEach( function( el ){
            el.innerHTML = str;
        } )
    },
    serialize: function( object ){
        var params = [];
        Object.walk( object, function( item, index ){
        	params.push( index + "=" + item );
        });
        return params.join('&');
    },
    ajax: function( params, success, error, data, async ){
        if( !params.hasOwnProperty('url') ){
            if( window.location.search.length > 1 ){
                params.url = location.href + window.location.search;
            } else {
                params.url = location.href;
            }
        }
        if( !params.hasOwnProperty('method') ){
            params.method = 'get';
        }
        if( !params.hasOwnProperty('responseType') ){
            params.responseType = '';
        }
        if( !params.hasOwnProperty('requestHeaders') ){
            params.requestHeaders = {};
        }
        if( typeof data == 'undefined' ){
            data = {};
        } else {
            if( params.method.toLowerCase() == 'get' ){
                params.url = params.url + "?" + io.serialize( data );
            } else if( params.method.toLowerCase() == 'post' ){
                data = io.serialize( data );
            }
        }

        if( params.method.toLowerCase() == 'post' ){
            params.requestHeaders['Content-Type'] = "application/x-www-form-urlencoded";
        }

        var xhr = new XMLHttpRequest();

        if( async === false ){
            xhr.open( params.method, params.url, false );
        } else {
            xhr.open( params.method, params.url );
        }

        for(var i in params.requestHeaders){
            xhr.setRequestHeader( i, params.requestHeaders[i] );
        }

        if( success === null || typeof success == 'undefined' ){
            success = function(){}
        } else if( typeof success !== 'function' ){
            throw new Error('Success callback MUST be of type function');
        }
        if( error === null || typeof error == 'undefined' ){
            error = function(){}
        } else if( typeof error !== 'function' ){
            throw new Error('Error callback MUST be of type function');
        }

        xhr.onreadystatechange = function( event ){
            if( this.readyState === 4 ){
                success.call( this, this.response );
            }
        }

        xhr.onerror = error;
        xhr.send( data );
    },
    get: function( params, success, error, data, async ){
        io.ajax( ( typeof params == 'string' ) ? {
            url: params,
            method: 'get',
            responseType: ''
        } : params, success, error, data, async );
    },
    post: function(  params, success, error, data, async ){
        io.ajax( ( typeof params == 'string' ) ? {
            url: params,
            method: 'post',
            responseType: ''
        } : params, success, error, data, async );
    }
});

codex.finder = CodexFinder = function( context ){
    this.context = context;
}
extend(codex.finder).with({
    one: function( query ){
        return this.context.querySelector( query );
    },
    all: function( query ){
        return this.context.querySelectorAll( query );
    },
    byId: function(query ){
        return this.context.getElementById( query );
    },
    byClass: function(query ){
        return this.context.getElementById( query );
    },
    byTag: function( query ){
        return this.context.getElementsByTagName( query );
    },
});

extend(Element, Document).with({
    find: function(){
        return new codex.finder( this );
    },
    addClass: function( a ){
        this.classList.add( a );
    },
    removeClass: function( a ){
        this.classList.remove( a );
    },
    hasClass: function( a ){
        return this.classList.contains( a );
    },
    attr: function( a, b ){
        if( b === null ){
            this.removeAttribute(a);
        } else if( typeof b == 'undefined' ){
            return this.getAttribute(a);
        } else {
            this.setAttribute(a, b);
        }
    },
    prop: function( a, b ){
        if( b === null ){
            delete this[a];
        } else if( typeof b == 'undefined' ){
            return this[a];
        } else {
            this[a] = b;
        }
    },
    toggleClass: function( a ){
        if( this.hasClass( a ) ){
            this.removeClass( a );
        } else {
            this.addClass( a );
        }
    },
    toggleAttr: function( a, b ){
        if( this.attr( a ) == b ){
            this.attr( a, null );
        } else {
            this.attr( a, b );
        }
    },
    toggleProp: function( a, b ){
        if( this.prop( a ) == b ){
            this.prop( a, null );
        } else {
            this.prop( a, b );
        }
    },
    listen: function( a, b, c, d ){
        var events = a.split(' ');
        for(var i in events){
            var eventType = events[i];
            if( typeof eventType === 'string' && typeof b === 'function' ){
                this.addEventListener( a, b, c );
            } else if( typeof b === 'string' && typeof c === 'function' ) {
                this.addEventListener( eventType, function( event ){

                    if( typeof event.target.matches === 'function' ){
                        if( event.target.matches( b ) ){
                            c.call( event.target, event );
                        } else if( ( closest = event.target.closest( b ) ) ){
                            c.call( closest, event );
                        }
                    }


                } );
            }
        }
    },
    dispatch: function( eventType, params ){
        if( typeof params == 'undefined' ){
            params = {
                cancelable: true,
                bubbles: true
            };
        }
        this.dispatchEvent( new CustomEvent( eventType, params ) );
    },
    load: function( url, success, error ){
        if( typeof success == 'undefined' ){
            success = function(){}
        }
        if( typeof success == 'undefined' ){
            error = function(){}
        }
        var xhr = new XMLHttpRequest();
        xhr.open( 'get', url );
        xhr.el = this;
        xhr.onreadystatechange = function( event ){
            if( this.readyState === 4 ){
                if( this.status === 200 ){
                    this.el.innerHTML = this.response;
                    success.call( this.el, this );
                } else {
                    error.call( this.el, this );
                }
            }
        }
        xhr.onerror = error;
        xhr.send();
    },
    css: function( a ){
        for(var i in a){
            this.style[i] = a[i];
        }
    }

});


extend(HTMLCollection, HTMLFormControlsCollection).with({
    forEach: function( callable ){
        for(i=0;i<this.length;i++){
            callable.call( window, this[i] );
        }
    }
})

document.listen('DOMContentLoaded', function(e){
    document.dispatch( 'loaded' );
} );
document.listen('click', '*', function( event ){
    if( event.target.attr('co-is-toggled') ){
        document.find().all('[co-is-toggled]').forEach( function( el ){
            el.attr('co-is-toggled', null);
        });
    }

});
