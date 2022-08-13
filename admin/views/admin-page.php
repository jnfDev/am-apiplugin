<?php 
/**
 * All the view's variables.
 * @var string $assetUrl
 * @var string $textdomain
 * @var array $challengeIds
 */
?>

<div id="am-admin-page">
    <header>
        <div class="logo">
            <img src="<?php echo esc_url( $assetUrl . '/img/am-logo-dark.svg' ); ?>" alt="am-logo">
            <h3 class="title"><?php _e( 'API-Based Plugin', $textdomain ); ?></h3>
        </div>
        <nav>
            <a class="tab-item active" href="#challenge-tab">
                <?php _e( 'Challenge', $textdomain ); ?>
            </a>
            <a class="tab-item" href="#reset-tab">
                <?php _e( 'Reset', $textdomain ); ?>
            </a>
        </nav>
    </header>

    <div class="tab-content">

        <!-- Tab 1  -->
        <div class="tab active" id="challenge-tab">  
            <div class="select-challenge-id">
                <label><?php _e( 'Select challenge:', $textdomain ); ?></label>
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

            <button class="fetch-challenge"><?php _e( 'Refresh Data', $textdomain ); ?></button>
        </div>

        <!-- Tab 2  -->
        <div class="tab" id="reset-tab">
            <p><?php _e( 'Reset or delete all the data store by the plugin on the options table.', $textdomain ); ?></p>
            <p><?php _e( 'The next data will be delete:', $textdomain ); ?></p>
            <ul>
                <li>
                    <b><?php _e( 'Request Throttle transient:', $textdomain ) ?></b>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident, quod aliquam id amet tenetur asperiores assumenda hic libero temporibus maxime molestias minima atque necessitatibus.
                </li>
                <li>
                    <b><?php _e( 'Fallback Response transient:', $textdomain ) ?></b>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat corrupti dicta aliquid ipsum, consequatur voluptatem similique nesciunt!
                </li>
            </ul>
            <button class="reset-plugin"><?php _e( 'Reset All Data Stored', $textdomain ); ?></button>
        </div>

    </div>
</div>