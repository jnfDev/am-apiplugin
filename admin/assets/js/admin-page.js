const AmAdminPage = {

    /**
     * @var object wp i18p handler 
     */
    i18n: {},

    /**
     * @var object.
     */
    adminVars: {},
    
    /**
     * @var string
     */
    context: '#am-admin-page',

    onTabChange: function(e) {
        const $tabItem   = jQuery(e.target);
        const $activeTab = jQuery($tabItem.attr('href'));
        
        // Reset active class
        $tabItem.siblings().removeClass('active');
        $activeTab.siblings().removeClass('active');

        // Add active class
        $tabItem.addClass('active');
        $activeTab.addClass('active');
    },

    resetAllData: function() {
        const { __ } = this.i18n;
        const { url: ajaxUrl, nonce, textdomain } = this.adminVars;

        jQuery.post(
            ajaxUrl,
            {
                action: 'am_reset_all_data',
                wpnonce: nonce,
            },
            function(resp) {
                const success = resp?.success || false;

                if (!success) {
                    alert(__('Something went wrong.', textdomain));
                    console.error('Failed AJAX request.');
                }

                alert(__('All data was successfully reset.', textdomain))
            }
        );
    },

    fetchChallenge: function() {
        const { __ } = this.i18n;
        const { url: ajaxUrl, nonce, textdomain } = this.adminVars;
        const challengeId = jQuery('#am-select-challenge').val();

        jQuery.post(
            ajaxUrl,
            {
                action: 'am_get_challenge_data',
                wpnonce: nonce,
                challenge_id: challengeId,
            },
            function({ data, success }) {
                const $challengeContent = jQuery('#challenge-content');

                // Reset content.
                $challengeContent.html('');

                if (!success || !data) {
                    alert(__('Something went wrong.', textdomain));
                    console.error('Wrong AJAX response.');
                }
    
                const { data: tableData } = data; 
                const rows = Object.values(tableData?.rows || {});

                rows.forEach(function(row){
                    const output = `
                        <div>${row.fname} ${row.lname}</div>
                        <div>
                            <p><b>${__(`ID:`, textdomain)}</b> ${row.id}</p>
                            <p><b>${__(`Email:`, textdomain)}</b> ${row.email}</p>
                            <p><b>${__(`Date:`, textdomain)}</b> ${row.date}</p>
                        </div>
                    `;

                    $challengeContent.append('<div class="row">' + output + '</div>')
                });
            }
        );
    },

    bindings: function() {
        this.onTabChange = this.onTabChange.bind(this);
        this.fetchChallenge = this.fetchChallenge.bind(this);
        this.resetAllData = this.resetAllData.bind(this);
    },

    init: function() {
        this.bindings();
        this.fetchChallenge();

        // Events
        jQuery('a.tab-item', this.context).click(this.onTabChange);
        jQuery('button.fetch-challenge', this.context).click(this.fetchChallenge);
        jQuery('button.reset-plugin', this.context).click(this.resetAllData);
    }
}; 

jQuery(function() {
    if (typeof wp === 'undefined' || typeof wp.i18n === 'undefined' ) {
        console.error('Missing wp/i18n object');
    }
    
    if (typeof adminVars !== 'object') {
        console.error('Missing AdminVars object');
    }
    AmAdminPage.i18n = wp.i18n;
    AmAdminPage.adminVars = adminVars;
    AmAdminPage.init();
});