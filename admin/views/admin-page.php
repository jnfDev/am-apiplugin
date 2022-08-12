<div id="am-admin-page">

    <header>
        <div class="logo">
            <img src="<?php echo esc_url( $assetUrl . '/img/am-logo-dark.svg' ) ?>" alt="am-logo">
            <h3 class="title">API-Based Plugin</h3>
        </div>
        <nav>
            <a class="tab-item active" href="#challenge-tab">
                <?php _e( 'Challenge', $this->plugin->textdomain ) ?>
            </a>
            <a class="tab-item" href="#reset-tab">
                <?php _e( 'Refresh', $this->plugin->textdomain ) ?>
            </a>
        </nav>
    </header>

    <div class="tab-content">
        <div class="tab active" id="challenge-tab">
            
            <div class="select-challenge-id">
                <label>Select Challenge</label>
                <select id="am-select-challenge">
                    <!-- TODO: Load it dynamicly -->
                    <option selected value="1">1</option>
                </select>
            </div>

            <!-- We're going to fill it out with AJAX -->
            <div id="challenge-content">
            </div>

            <button id="fetch-challenge">Refresh Data</button>

        </div>
        <div class="tab" id="reset-tab">
            refresh content
        </div>
    </div>

</div>