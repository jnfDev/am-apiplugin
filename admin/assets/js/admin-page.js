jQuery(function($) {
    $.post( 
        AmAdminVars.url,
        {
            action: AmAdminVars.actions['update_setting'],
            name: 'emails',
            value: ["3"],
            wpnonce: AmAdminVars.nonce 
        },
        function( $data ) {
            console.log($data);
        }
    );

});