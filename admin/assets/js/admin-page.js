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

    toggleLoading: function($elm) {
        if ($elm.hasClass('loading')){
            $elm.removeClass('loading');
            $elm.attr('disabled', false);
            return;
        }

        $elm.addClass('loading');
        $elm.attr('disabled', true);
    },

    resetAllData: function(e) {
        const $elm = jQuery(e.target);
        const { __ } = this.i18n;
        const { url: ajaxUrl, nonce, textdomain } = this.adminVars;

        this.toggleLoading($elm);

        jQuery.post(
            ajaxUrl,
            {
                action: 'am_reset_all_data',
                wpnonce: nonce,
            },
            (resp) => {
                const success = resp?.success || false;

                this.toggleLoading($elm);

                if (!success) {
                    alert(__('Something went wrong.', textdomain));
                    console.error('Failed AJAX request.');
                }

                alert(__('All data was successfully reset.', textdomain))
            }
        );
    },

    fetchChallenge: function(e) {
        const { __ } = this.i18n;
        const { url: ajaxUrl, nonce, textdomain } = this.adminVars;
        const challengeId = jQuery('#am-select-challenge').val();

        return new Promise((resolve) => {
            jQuery.post(
                ajaxUrl,
                {
                    action: 'am_get_challenge_data',
                    wpnonce: nonce,
                    challenge_id: challengeId,
                },
                ({ data, success }) => {
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
                        const id = row.id;
                        const email = row.email;
                        const date = (new Date(row.date)).toLocaleDateString();

                        const output = `
                            <div>${row.fname} ${row.lname}</div>
                            <div>
                                <p><b>${__(`ID:`, textdomain)}</b> ${id}</p>
                                <p><b>${__(`Email:`, textdomain)}</b> ${email}</p>
                                <p><b>${__(`Date:`, textdomain)}</b> ${date}</p>
                            </div>
                        `;
    
                        $challengeContent.append('<div class="row">' + output + '</div>')
                    });

                    resolve();
                }
            );
        });
    },

    bindings: function() {
        this.onTabChange = this.onTabChange.bind(this);
        this.fetchChallenge = this.fetchChallenge.bind(this);
        this.resetAllData = this.resetAllData.bind(this);
    },

    init: function() {
        const { __ } = this.i18n;
        const { textdomain } = this.adminVars;

        this.bindings();
        this.fetchChallenge();

        // Events
        jQuery('a.tab-item', this.context).click(this.onTabChange);
        jQuery('button.reset-plugin', this.context).click(this.resetAllData);
        jQuery('button.fetch-challenge', this.context).click((e) => {
            const $elm = jQuery(e.target);
            
            this.toggleLoading($elm);
            this.fetchChallenge().then(() => {
                this.toggleLoading($elm);
                alert(__('Data fetched.', textdomain))
            });
        });
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