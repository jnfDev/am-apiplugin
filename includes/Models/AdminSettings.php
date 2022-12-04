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
                'validation'   => function( $value ) {
                    if ( $value > 0 && $value <= 5 ) {
                        return;
                    }
                    
                    return sprintf(
                        /* translators: 1: <b> 2: </b> 3: invalid numrows given */
                        esc_html__('%1$sRows Number%2$s must be a valid number between 1 and 5, %3$s given', 'am-apiplugin'),
                        '<b>',
                        '</b>',
                        $value
                    );
                },
                'default'  => 5
            ],
            'humandate' => [ 
                'sanitize'   => function( $value ) {
                    return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
                },
                'default' => true
            ],
            'emails' => [
                'sanitize'   => function( $value ) {
                    return array_map( 'sanitize_email', $value );
                },
                'validation' => function( $value ) {
                    if ( ! ( count( $value ) <= 5 ) ) {
                        return sprintf(
                            /* translators: 1: <b> 2: </b> 3: how many emails were given */
                            esc_html__('%1$sEmails%2$s can contain between 0 and 5 email addresses (inclusive), %3$s given', 'am-apiplugin'),
                            '<b>',
                            '</b>',
                            count( $value )
                        );
                    }

                    if ( count( $value ) !== count( array_unique( $value ) ) ){
                        return sprintf(
                            /* translators: 1: <b> 2: </b> */
                            esc_html__('%1$sEmails%2$s can\'t contain duplicate values', 'am-apiplugin'),
                            '<b>',
                            '</b>',
                            $value
                        );
                    }

                    foreach ( $value as $email ) {
                        if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
                            return sprintf(
                                /* translators: 1: <b> 2: </b> 3: invalid email given */
                                esc_html__('%1$sEmails%2$s must contain valid emails, %3$s given', 'am-apiplugin'),
                                '<b>',
                                '</b>',
                                $email
                            );
                        }
                    }
                },
                'default' => [
                    get_option('admin_email')
                ]
            ]
        ];

        // Fetch settings from database
        $settings = get_option( self::OPTION_KEY, [] );

        foreach ( $this->settingsBlueprint as $key => $blueprint ) {
            $this->settings[ $key ] = isset( $settings[ $key ] ) ? $settings[ $key ] : $blueprint['default'];
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

        $validation = isset( $this->settingsBlueprint[ $name ]['validation'] ) ? $this->settingsBlueprint[ $name ]['validation'] : false;

        if ( $validation && $errorMessage = $validation( $value ) ) {
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