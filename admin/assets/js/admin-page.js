const AmAdminPage = {

    adminVars,
    
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

    fetchChallenge: function() {
        const { __ } = wp.i18n;
        const { url: ajaxUrl, action, nonce, textdomain } = this.adminVars;
        const challengeId = jQuery('#am-select-challenge').val();

        jQuery.post(
            ajaxUrl,
            {
                action: action,
                wpnonce: nonce,
                challengeid: challengeId,
            },
            function({ data, success }) {
                const $challengeContent = jQuery('#challenge-content');

                // Reset content.
                $challengeContent.html('');

                if (!success || !data) {
                    console.error('Wrong AJAX response.');
                    alert(__('Something went wrong.', textdomain));
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
    },

    init: function() {
        this.bindings();
        this.fetchChallenge();

        // Events
        jQuery('a.tab-item', this.context).click(this.onTabChange);
        jQuery('button.fetch-challenge', this.context).click(this.fetchChallenge);
    }
}; 

jQuery(function() {
    if (typeof adminVars !== 'object') {
        console.error('Missing Am AdminVars object');
    }

    AmAdminPage.adminVars = adminVars;
    AmAdminPage.init();
});