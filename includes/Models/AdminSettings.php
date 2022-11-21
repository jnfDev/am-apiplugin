<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use Am\APIPlugin\Singleton;
use Am\APIPlugin\Exceptions\InvalidSettingNameException;
use Am\APIPlugin\Exceptions\InvalidSettingValueTypeException;
use Am\APIPlugin\Exceptions\InvalidSettingValueException;
use Am\APIPlugin\Exceptions\UpdateSettingException;

class AdminSettings
{
    use Singleton;

    private const OPTION_KEY = 'test_project_option';

    /**
     * @var array
     */
    private $settings;

    /**
     * @var array
     */
    private $settingsBlueprint;

    protected function init(): void
    {
        $this->settingsBlueprint = [
            'numrows' => [
                'type'       => 'integer',
                'sanitize'   => function( $value ) {
                    return (int) $value;
                },
                'validate'   => function( $value ) {
                    return $value > 0 && $value <= 5;
                },
                'default'  => 5
            ],
            'humandate' => [ 
                'type'    => 'boolean',
                'sanitize'   => function( $value ) {
                    return (bool) $value;
                },
                'default' => true
            ],
            'emails' => [
                'type'       => 'array',
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

        if ( gettype( $value ) !== $this->settingsBlueprint[ $name ]['type'] ) {
            throw new InvalidSettingValueTypeException();
        }

        if ( isset( $this->settingsBlueprint[$name]['validate'] ) && 
             ! $this->settingsBlueprint[$name]['validate']($value) ) 
        {
            throw new InvalidSettingValueException();
        }

        if ( $this->settings[ $name ] === $value ) {
            return;
        }

        $this->settings[ $name ] = $this->settingsBlueprint[$name]['sanitize']($value);
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