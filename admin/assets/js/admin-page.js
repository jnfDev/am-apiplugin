const AmAdminPage = {

    adminVars,
    
    context: 'am-admin-page',

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
        const challengeId = jQuery('#am-select-challenge').val();

        jQuery.post(
            this.adminVars.url,
            {
                action: this.adminVars.action,
                wpnonce: this.adminVars.nonce,
                challengeid: challengeId,
            },
            function({ data, success }) {

                const $challengeContent = jQuery('#challenge-content');

                $challengeContent.html('');

                if (!success || !data) {
                    // Print error
                }
    
                const { data: tableData } = data; 
                const rows = Object.values(tableData?.rows || {});

                rows.forEach(function(row){
                    const output = `
                        <div>${row.fname} ${row.lname}</div>
                        <div>
                            <p><b>ID:</b> ${row.id}</p>
                            <p><b>Email:</b> ${row.email}</p>
                            <p><b>Date:</b> ${row.date}</p>
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
        jQuery('.tab-item', this.context).click(this.onTabChange);
        jQuery('.fetch-challenge', this.context).click(this.fetchChallenge);
    }
}; 

jQuery(function() {
    if (typeof adminVars !== 'object') {
        console.error('Missing Am AdminVars object');
    }

    AmAdminPage.adminVars = adminVars;
    AmAdminPage.init();
});