<?php 
/**
 * All the view's variables.
 * @var string $assetUrl
 * @var array $challengeIds
 */
?>

<div id="am-admin-page">
    <header>
        <div class="logo">
            <img src="<?php echo esc_url( $assetUrl . '/img/am-logo-dark.svg' ); ?>" alt="am-logo">
            <h3 class="title"><?php esc_html_e( 'API-Based Plugin', 'am-apiplugin' ); ?></h3>
        </div>
        <nav>
            <a class="tab-item active" href="#challenge-tab">
                <?php esc_html_e( 'Challenge', 'am-apiplugin' ); ?>
            </a>
            <a class="tab-item" href="#reset-tab">
                <?php esc_html_e( 'Reset', 'am-apiplugin' ); ?>
            </a>
        </nav>
    </header>

    <div class="tab-content">

        <!-- Tab 1  -->
        <div class="tab active" id="challenge-tab">  
            <div class="select-challenge-id">
                <label><?php esc_html_e( 'Select challenge:', 'am-apiplugin' ); ?></label>
                <select id="am-select-challenge">
                    <?php foreach ( $challengeIds as $challengeId ): ?>
                    <option selected value="<?php echo esc_attr( $challengeId ); ?>">
                        <?php echo esc_attr( $challengeId ); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- We're going to fill it out with AJAX -->
            <div id="challenge-content"></div>

            <button class="fetch-challenge"><?php esc_html_e( 'Refresh Data', 'am-apiplugin' ); ?></button>
        </div>

        <!-- Tab 2  -->
        <div class="tab" id="reset-tab">
            <p><?php esc_html_e( 'Reset or delete all the data store by the plugin on the options table.', 'am-apiplugin' ); ?></p>
            <p><?php esc_html_e( 'The next data will be delete:', 'am-apiplugin' ); ?></p>
            <ul>
                <li>
                    <b><?php esc_html_e( 'Requests Throttling:', 'am-apiplugin' ) ?></b>
                    <?php esc_html_e( 'This is the mechanism used by the plugin to limit the number of requests in a certain time.', 'am-apiplugin' ); ?> 
                    <?php esc_html_e( 'This class implements transient to create a temporal flag, so data is stored on the options table.', 'am-apiplugin' ); ?>
                </li>
                <li>
                    <b><?php esc_html_e( 'Fallback Response:', 'am-apiplugin' ) ?></b>
                    <?php esc_html_e( 'This is the way the plugin ensures every request gets an answer even if the API Endpoint is "throttling".', 'am-apiplugin' ); ?>
                    <?php esc_html_e( 'This class implements transient to create a temporal variable, so data is stored on the options table.', 'am-apiplugin' ); ?>
                </li>
            </ul>
            <button class="reset-plugin"><?php esc_html_e( 'Reset All Data Stored', 'am-apiplugin' ); ?></button>
        </div>

    </div>
</div>