<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use Am\APIPlugin\Singleton;
use Am\APIPlugin\Exceptions\InvalidSettingNameException;
use Am\APIPlugin\Exceptions\InvalidSettingValueException;
use Am\APIPlugin\Exceptions\UpdateSettingException;

class AdminSettings
{
    use Singleton;

    private const OPTION_KEY = 'test_project_option';

    private array $settings;

    private array $settingsBlueprint;

    protected function init(): void
    {
        $this->settingsBlueprint = [
            'numrows' => [
                'sanitize'   => function( $value ) {
                    return (int) $value;
                },
                'validate'   => function( $value ) {
                    return $value > 0 && $value <= 5;
                },
                'error_message' => __( 'Numrows must be a valid number between 1 and 5', 'am-apiplugin' ),
                'default'  => 5
            ],
            'humandate' => [ 
                'sanitize'   => function( $value ) {
                    return (bool) $value;
                },
                'default' => true
            ],
            'emails' => [
                'sanitize'   => function( $value ) {
                    return array_map( 'sanitize_email', $value );
                },
                'validate' => function( $value ) {
                    if ( ! ( count( $value ) <= 5 ) ) {
                        return false;
                    }

                    foreach ( $value as $email ) {
                        if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
                            return false;
                        }
                    }

                    return true;
                },
                'error_message' => __( 'Emails must be a list of valid emails', 'am-apiplugin' ),
                'default' => [
                    get_option('admin_email')
                ]
            ]
        ];

        // Fetch settings from database
        $settings = get_option( self::OPTION_KEY, [] );

        foreach ( $this->settingsBlueprint as $key => $blueprint ) {
            $this->settings[ $key ] = ! empty( $settings[ $key ] ) ? $settings[ $key ] : $blueprint['default'] ;
        }
    }

    public function set( string $name, $value )
    {
        $name  = sanitize_key( $name );

        if ( ! in_array( $name, array_keys( $this->settingsBlueprint ) ) ) {
            throw new InvalidSettingNameException();
        }

        $sanitize = $this->settingsBlueprint[ $name ]['sanitize'];
        $value = $sanitize($value);

        if ( isset( $this->settingsBlueprint[ $name ]['validate'] ) && 
             ! $this->settingsBlueprint[ $name ]['validate']( $value ) 
        ) {
            $errorMessage = $this->settingsBlueprint[ $name ]['error_message'];
            throw new InvalidSettingValueException( $errorMessage );
        }

        if ( $this->settings[ $name ] === $value ) {
            return;
        }

        $this->settings[ $name ] = $value;
        if ( ! update_option( self::OPTION_KEY, $this->settings ) ) {
            throw new UpdateSettingException();
        }
    }

    public function get( string $name = null )
    {
        if ( ! is_null( $name ) && ! in_array( $name, array_keys( $this->settingsBlueprint ) ) ) {
            throw new InvalidSettingNameException();
        }

        if ( is_null( $name ) ) {
            return $this->settings;
        }

        return $this->settings[ $name ];
    }

    public function restore(): void
    {
        foreach ( $this->settingsBlueprint as $key => $blueprint ) {
            $this->set( $key, $blueprint['default'] );
        }
    }
}