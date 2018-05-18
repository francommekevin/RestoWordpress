jQuery( document ).ready( function($) {
    $( '#register-user, #update-utilisateur' ).on( 'submit', function(e) {

        $( this ).find( 'input:required' ).each( function() {
            // On vérifie si les input requis sont remplis
            if ( $( this ).val().trim() == '' ) {
                e.preventDefault();
                $( this ).addClass( 'error' );
            }
        } );

        $( this ).find( 'input[type="email"]' ).each( function() {
            // Regex pour vérifier le champ email
            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if ( ! pattern.test( $( this ).val() ) ) {
                e.preventDefault();
                $( this ).addClass( 'error' );
            }
        } );

    } );

    // Toggle hidden password
    $( '#show-password' ).on( 'change', function() {
        if ( $( this ).is( ':checked' ) ) {
            $( '#pass-user' ).attr( 'type', 'text' );
        } else {
            $( '#pass-user' ).attr( 'type', 'password' );
        }
    } );
} );