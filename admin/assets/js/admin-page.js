jQuery(function($) {
    $.post( 
        AmAdminVars.url,
        {
            action: AmAdminVars.action,
            wpnonce: AmAdminVars.nonce 
        },
        function( $data ) {
            console.log($data);
        }
    );

});