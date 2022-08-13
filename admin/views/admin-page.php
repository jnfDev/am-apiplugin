<?php 
/**
 * 
 * @var string $assetUrl
 * @var string $textdomain
 * 
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
        <div class="tab active" id="challenge-tab">
            
            <div class="select-challenge-id">
                <label><?php _e( 'Select challenge:', $textdomain ); ?></label>
                <select id="am-select-challenge">
                    <!-- TODO: Load it dynamicly -->
                    <option selected value="1">1</option>
                </select>
            </div>

            <!-- We're going to fill it out with AJAX -->
            <div id="challenge-content">
            </div>

            <button class="fetch-challenge"><?php _e( 'Refresh Data', $textdomain ); ?></button>
        </div>

        <div class="tab" id="reset-tab">
            <p><?php _e( 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe exercitationem voluptatum cumque cupiditate necessitatibus perferendis aspernatur, beatae temporibus minima rerum culpa ex veritatis. Quos odit quia eum rerum, earum ipsam?', $textdomain ); ?></p>
            <button class="reset-plugin"><?php _e( 'Reset All Data Stored', $textdomain ); ?></button>
        </div>
    </div>
</div>