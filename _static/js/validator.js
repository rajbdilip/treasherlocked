function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function Validator() {

	this.validateName = function( f ) {
		
		var field = $( '#' + f );
		var e_field = $('#e_' + f );
		
		if ( !field.length )
			return true;
			
		var name = field.val();
		$(field).val(ucwords(name));
		
		var name = new RegExp(/^[a-z][a-z\s]{3,100}$/i);
		
		if (!name.test(field.val())) {
			field.css('border-color', 'red');
			e_field.fadeIn();
			return false;
		} else {
			field.css('border', 'solid 1px rgba(0,0,0,0.15)');
			e_field.fadeOut();
			return true;
		}
	}
	
	this.validateInstitute = function( f ) {
		
		var field = $( '#' + f );
		var e_field = $('#e_' + f );
		
		if ( !field.length )
			return true;
			
		var name = field.val();
		$(field).val(ucwords(name));
		
		var name = new RegExp(/^[a-z][a-z\s]{9,100}$/i);
		
		if (!name.test(field.val())) {
			field.css('border-color', 'red');
			e_field.fadeIn();
			return false;
		} else {
			field.css('border', 'solid 1px rgba(0,0,0,0.15)');
			e_field.fadeOut();
			return true;
		}
	}
	
	this.validateLocation = function( f ) {
		
		var field = $( '#' + f );
		var e_field = $('#e_' + f );
		
		if ( !field.length )
			return true;
			
		var name = field.val();
		$(field).val(ucwords(name));
		
		var name = new RegExp(/^[a-z][a-z,\s]{5,100}$/i);
		
		if (!name.test(field.val())) {
			field.css('border-color', 'red');
			e_field.fadeIn();
			return false;
		} else {
			field.css('border', 'solid 1px rgba(0,0,0,0.15)');
			e_field.fadeOut();
			return true;
		}
	}
	
	this.validateEmail = function( f ) {
		var field = $( '#' + f );
		var e_field = $('#e_' + f );
		
		if ( !field.length )
			return true;
		
		var emailReg = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
	
		if ( !emailReg.test( field.val() ) || field.val() == '' ) {
			field.css('border-color','#ff0033');
			e_field.fadeIn();
			return false;
		} else {
			field.css('border','solid 1px rgba(0,0,0,0.15)');
			e_field.fadeOut();
			return true;	
		}
	}
	
	this.validateUsername = function( f ) {
		var field = $( '#' + f );
		var e_field = $('#e_' + f );
		
		if ( !field.length )
			return true;
		
		var username = new RegExp(/^[a-z0-9_!@#$%^&*]{3,25}$/i);
	
		if ( !username.test(field.val()) ) {
			field.css('border-color','#ff0033');
			e_field.html( '<span>Username</span> must be at least 3 characters long and can only contain alphanumeric characters and one of <span>!@#$%^&amp;*_</span>' );
			e_field.fadeIn();
			return false;
		} else {
			field.css('border','solid 1px rgba(0,0,0,0.15)');
			e_field.fadeOut();
			return true;
		}
	}
	
	this.validatePassword = function( f1, f2 ) {
		var field1 = $( '#' + f1 );
		var e_field1 = $('#e_' + f1 );
		var field2 = $( '#' + f2 );
		var e_field2 = $('#e_' + f2 );

		if ( field1.val().length < 6 ) {
			field1.css( 'border-color','#ff0033' );
			e_field1.fadeIn();
			return false;
		} else {
			field1.css( 'border','solid 1px rgba(0,0,0,0.15)' );
			e_field1.fadeOut();

			if ( field1.val() != field2.val() ) {
				field2.css( 'border-color','#ff0033' );
				e_field2.fadeIn();
				return false;
			} else {
				field2.css( 'border','solid 1px rgba(0,0,0,0.15)' );
				e_field2.fadeOut();
				return true;	
			}
		}
	}
}