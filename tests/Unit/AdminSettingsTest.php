<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Am\APIPlugin\Models\AdminSettings;
use Am\APIPlugin\Exceptions\InvalidSettingNameException;
use Am\APIPlugin\Exceptions\InvalidSettingValueTypeException;
use Am\APIPlugin\Exceptions\InvalidSettingValueException;

final class AdminSettingsTest extends TestCase
{
    public function testRestorSettings()
    {
        /**
         * @var AdminSettings
         */
        $settings = AdminSettings::getInstance();

        $reflection        = new ReflectionClass( AdminSettings::class );
        $settingsOptionKey = $reflection->getConstants()['OPTION_KEY'];

        $reflectionObj     = new ReflectionObject( $settings );
        $reflSettingsBlueprint = $reflectionObj->getProperty('settingsBlueprint');
        $reflSettingsBlueprint->setAccessible(true);
         
        delete_option( $settingsOptionKey );
        $settings->restore();

        $_settings = get_option( $settingsOptionKey );
        foreach ( $reflSettingsBlueprint->getValue( $settings ) as $key => $blueprint ) {
            $this->assertEquals( $blueprint['default'], $_settings[ $key ] );
        }
    }

    public function testUpdateSettings()
    {
        /**
         * @var AdminSettings
         */
        $settings = AdminSettings::getInstance();

        $settings->restore();
        $settings->set('numrows', 1);
        $settings->set('emails', [ 'my@email.com' ] );
        $settings->set('humandate', false );

        $reflection        = new ReflectionClass( AdminSettings::class );
        $settingsOptionKey = $reflection->getConstants()['OPTION_KEY'];

        $_settings = get_option( $settingsOptionKey );

        $this->assertEquals( 1, $_settings['numrows'] );
        $this->assertEquals( [ 'my@email.com' ], $_settings['emails'] );
        $this->assertEquals( false, $_settings['humandate'] );
    }

    public function testGetSettings()
    {
        $settings = AdminSettings::getInstance();
        
        $settings->restore();
        $settings->set('numrows', 1);
        $settings->set('emails', [ 'my@email.com' ] );
        $settings->set('humandate', false );

        $numrows = $settings->get('numrows');
        $allSettings = $settings->get();

        $this->assertEquals( 1, $numrows );
        $this->assertEquals(
            [
                'numrows'   => 1,
                'emails'    => [ 'my@email.com' ],
                'humandate' => false
            ],
            $allSettings
        );

    }

    public function testThrowExceptionOnInvalidName()
    {
        $settings = AdminSettings::getInstance();
        
        $this->expectException( InvalidSettingNameException::class );
        $settings->set('numro___ws', 1);
    }

    public function testThrowExceptionOnInvalidValue()
    {
        $settings = AdminSettings::getInstance();
        
        /** Validate Types  */

        try {
            $settings->set('numrows', [ 'wrong-type' ]);
            throw new Exception();

        } catch ( InvalidSettingValueTypeException $e ) {
            $this->assertInstanceOf( InvalidSettingValueTypeException::class, $e );
        }

        try {
            $settings->set('emails', true);
            throw new Exception();

        } catch ( InvalidSettingValueTypeException $e ) {
            $this->assertInstanceOf( InvalidSettingValueTypeException::class, $e );
        }


        try {
            $settings->set('humandate', 1);
            throw new Exception();

        } catch ( InvalidSettingValueTypeException $e ) {
            $this->assertInstanceOf( InvalidSettingValueTypeException::class, $e );
        }


        /** Validate values */

        try {
            $settings->set('numrows', 10 );
            throw new Exception();

        } catch ( InvalidSettingValueException $e ) {
            $this->assertInstanceOf( InvalidSettingValueException::class, $e );
        }

        try {
            $settings->set('emails', [
                'my@email.com',
                'my@email.com',
                'my@email.com',
                'my@email.com',
                'my@email.com',
                'my@email.com',
            ] );

            throw new Exception();
            
        } catch ( InvalidSettingValueException $e ) {
            $this->assertInstanceOf( InvalidSettingValueException::class, $e );
        }


        try {
            $settings->set('emails', [
                'wrong__email',
            ] );

            throw new Exception();
            
        } catch ( InvalidSettingValueException $e ) {
            $this->assertInstanceOf( InvalidSettingValueException::class, $e );
        }
    }
}