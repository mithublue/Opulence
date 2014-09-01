<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Tests the type mapper class
 */
namespace RDev\Models\Databases\SQL\Providers;

class TypeMapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var TypeMapper The type mapper without a provider to use for tests */
    private $typeMapperWithNoProvider = null;
    /** @var TypeMapper The type mapper with a provider to use for tests */
    private $typeMapperWithProvider = null;
    /** @var Provider The provider to use for tests */
    private $provider = null;

    /**
     * Sets up the tests
     */
    public function setUp()
    {
        $this->typeMapperWithNoProvider = new TypeMapper();
        $this->provider = new Provider();
        $this->typeMapperWithProvider = new TypeMapper($this->provider);
    }

    /**
     * Tests converting from a null date returns null
     */
    public function testConvertingDateFromNullReturnsNull()
    {
        $this->assertNull($this->typeMapperWithNoProvider->fromSQLDate(null, $this->provider));
        $this->assertNull($this->typeMapperWithProvider->fromSQLDate(null));
    }

    /**
     * Tests converting from a false SQL boolean
     */
    public function testConvertingFromFalseSQLBoolean()
    {
        $sqlBoolean = $this->provider->getFalseBooleanFormat();
        $this->assertSame(false, $this->typeMapperWithNoProvider->fromSQLBoolean($sqlBoolean, $this->provider));
        $this->assertSame(false, $this->typeMapperWithProvider->fromSQLBoolean($sqlBoolean));
    }

    /**
     * Tests converting from an invalid SQL timestamp without time zone
     */
    public function testConvertingFromInvalidSQLTimestampWithoutTimeZone()
    {
        $exceptionsThrown = false;

        try
        {
            $this->typeMapperWithNoProvider->fromSQLTimestampWithoutTimeZone("not a real timestamp", $this->provider);
        }
        catch(\InvalidArgumentException $ex)
        {
            $exceptionsThrown = true;
        }

        try
        {
            $this->typeMapperWithProvider->fromSQLTimestampWithoutTimeZone("not a real timestamp");
        }
        catch(\InvalidArgumentException $ex)
        {
            $exceptionsThrown = $exceptionsThrown && true;
        }

        $this->assertTrue($exceptionsThrown);
    }

    /**
     * Tests converting from an SQL date
     */
    public function testConvertingFromSQLDate()
    {
        $phpDate = new \DateTime("now", new \DateTimeZone("UTC"));
        $sqlDate = $phpDate->format($this->provider->getDateFormat());
        $this->assertEquals($phpDate, $this->typeMapperWithNoProvider->fromSQLDate($sqlDate, $this->provider));
        $this->assertEquals($phpDate, $this->typeMapperWithProvider->fromSQLDate($sqlDate));
    }

    /**
     * Tests converting from an SQL time with time zone
     */
    public function testConvertingFromSQLTimeWithTimeZone()
    {
        /**
         * PHP threw a fit when the timezone was set to "UTC" because the date returned by the type mapper
         * was "+0" rather than "UTC", so they weren't equivalent
         */
        $phpTimeWithMicroseconds = new \DateTime("now", new \DateTimeZone("+0"));
        $sqlTimeWithMicroseconds = $phpTimeWithMicroseconds->format("H:i:s.uP");
        $this->assertEquals($phpTimeWithMicroseconds, $this->typeMapperWithNoProvider
            ->fromSQLTimestampWithTimeZone($sqlTimeWithMicroseconds, $this->provider));
        $this->assertEquals($phpTimeWithMicroseconds, $this->typeMapperWithProvider
            ->fromSQLTimestampWithTimeZone($sqlTimeWithMicroseconds));
        $phpTime = new \DateTime("now", new \DateTimeZone("+0"));
        $sqlTime = $phpTime->format($this->provider->getTimeWithTimeZoneFormat());
        $this->assertEquals($phpTime, $this->typeMapperWithNoProvider->fromSQLTimeWithTimeZone($sqlTime, $this->provider));
        $this->assertEquals($phpTime, $this->typeMapperWithProvider->fromSQLTimeWithTimeZone($sqlTime));
    }

    /**
     * Tests converting from an SQL time without time zone
     */
    public function testConvertingFromSQLTimeWithoutTimeZone()
    {
        $phpTimeWithMicroseconds = new \DateTime("now", new \DateTimeZone("UTC"));
        $sqlTimeWithMicroseconds = $phpTimeWithMicroseconds->format("H:i:s.u");
        $this->assertEquals($phpTimeWithMicroseconds, $this->typeMapperWithNoProvider
            ->fromSQLTimestampWithTimeZone($sqlTimeWithMicroseconds, $this->provider));
        $this->assertEquals($phpTimeWithMicroseconds, $this->typeMapperWithProvider
            ->fromSQLTimestampWithTimeZone($sqlTimeWithMicroseconds));
        $phpTime = new \DateTime("now", new \DateTimeZone("UTC"));
        $sqlTime = $phpTime->format($this->provider->getTimeWithoutTimeZoneFormat());
        $this->assertEquals($phpTime, $this->typeMapperWithNoProvider->fromSQLTimeWithoutTimeZone($sqlTime, $this->provider));
        $this->assertEquals($phpTime, $this->typeMapperWithProvider->fromSQLTimeWithoutTimeZone($sqlTime));
    }

    /**
     * Tests converting from an SQL timestamp with time zone
     */
    public function testConvertingFromSQLTimestampWithTimeZone()
    {
        /**
         * PHP threw a fit when the timezone was set to "UTC" because the date returned by the type mapper
         * was "+0" rather than "UTC", so they weren't equivalent
         */
        $phpTimestampWithMicroseconds = new \DateTime("now", new \DateTimeZone("+0"));
        $sqlTimestampWithMicroseconds = $phpTimestampWithMicroseconds->format("Y-m-d H:i:s.uP");
        $this->assertEquals($phpTimestampWithMicroseconds, $this->typeMapperWithNoProvider
            ->fromSQLTimestampWithTimeZone($sqlTimestampWithMicroseconds, $this->provider));
        $this->assertEquals($phpTimestampWithMicroseconds, $this->typeMapperWithProvider
            ->fromSQLTimestampWithTimeZone($sqlTimestampWithMicroseconds));
        $phpTimestamp = new \DateTime("now", new \DateTimeZone("+0"));
        $sqlTimestamp = $phpTimestamp->format($this->provider->getTimestampWithTimeZoneFormat());
        $this->assertEquals($phpTimestamp, $this->typeMapperWithNoProvider->fromSQLTimestampWithTimeZone($sqlTimestamp, $this->provider));
        $this->assertEquals($phpTimestamp, $this->typeMapperWithProvider->fromSQLTimestampWithTimeZone($sqlTimestamp));
    }

    /**
     * Tests converting from an SQL timestamp without time zone
     */
    public function testConvertingFromSQLTimestampWithoutTimeZone()
    {
        $phpTimestampWithMicroseconds = new \DateTime("now", new \DateTimeZone("UTC"));
        $sqlTimestampWithMicroseconds = $phpTimestampWithMicroseconds->format("Y-m-d H:i:s.u");
        $this->assertEquals($phpTimestampWithMicroseconds, $this->typeMapperWithNoProvider
            ->fromSQLTimestampWithTimeZone($sqlTimestampWithMicroseconds, $this->provider));
        $this->assertEquals($phpTimestampWithMicroseconds, $this->typeMapperWithProvider
            ->fromSQLTimestampWithTimeZone($sqlTimestampWithMicroseconds));
        $phpTimestamp = new \DateTime("now", new \DateTimeZone("UTC"));
        $sqlTimestamp = $phpTimestamp->format($this->provider->getTimestampWithoutTimeZoneFormat());
        $this->assertEquals($phpTimestamp, $this->typeMapperWithNoProvider
            ->fromSQLTimestampWithoutTimeZone($sqlTimestamp, $this->provider));
        $this->assertEquals($phpTimestamp, $this->typeMapperWithProvider
            ->fromSQLTimestampWithoutTimeZone($sqlTimestamp));
    }

    /**
     * Tests converting from a true SQL boolean
     */
    public function testConvertingFromTrueSQLBoolean()
    {
        $sqlBoolean = $this->provider->getTrueBooleanFormat();
        $this->assertSame(true, $this->typeMapperWithNoProvider->fromSQLBoolean($sqlBoolean, $this->provider));
        $this->assertSame(true, $this->typeMapperWithProvider->fromSQLBoolean($sqlBoolean));
    }

    /**
     * Tests converting from a null time with time zone returns null
     */
    public function testConvertingTimeWithTimeZoneFromNullReturnsNull()
    {
        $this->assertNull($this->typeMapperWithNoProvider->fromSQLTimeWithTimeZone(null, $this->provider));
        $this->assertNull($this->typeMapperWithProvider->fromSQLTimeWithTimeZone(null));
    }

    /**
     * Tests converting from a null time without time zone returns null
     */
    public function testConvertingTimeWithoutTimeZoneFromNullReturnsNull()
    {
        $this->assertNull($this->typeMapperWithNoProvider->fromSQLTimeWithoutTimeZone(null, $this->provider));
        $this->assertNull($this->typeMapperWithProvider->fromSQLTimeWithoutTimeZone(null));
    }

    /**
     * Tests converting from a null timestamp with timezone returns null
     */
    public function testConvertingTimestampWithTimeZoneFromNullReturnsNull()
    {
        $this->assertNull($this->typeMapperWithNoProvider->fromSQLTimestampWithTimeZone(null, $this->provider));
        $this->assertNull($this->typeMapperWithProvider->fromSQLTimestampWithTimeZone(null));
    }

    /**
     * Tests converting from a null timestamp without time zone returns null
     */
    public function testConvertingTimestampWithoutTimeZoneFromNullReturnsNull()
    {
        $this->assertNull($this->typeMapperWithNoProvider->fromSQLTimestampWithoutTimeZone(null, $this->provider));
        $this->assertNull($this->typeMapperWithProvider->fromSQLTimestampWithoutTimeZone(null));
    }

    /**
     * Tests converting to a false SQL boolean
     */
    public function testConvertingToFalseSQLBoolean()
    {
        $this->assertEquals($this->provider->getFalseBooleanFormat(), $this->typeMapperWithNoProvider->toSQLBoolean(false, $this->provider));
        $this->assertEquals($this->provider->getFalseBooleanFormat(), $this->typeMapperWithProvider->toSQLBoolean(false));
    }

    /**
     * Tests converting to an SQL date
     */
    public function testConvertingToSQLDate()
    {
        $date = new \DateTime("now", new \DateTimeZone("UTC"));
        $this->assertEquals($date->format($this->provider->getDateFormat()), $this->typeMapperWithNoProvider->toSQLDate($date, $this->provider));
        $this->assertEquals($date->format($this->provider->getDateFormat()), $this->typeMapperWithProvider->toSQLDate($date));
    }

    /**
     * Tests converting to an SQL time with time zone
     */
    public function testConvertingToSQLTimeWithTimeZone()
    {
        $time = new \DateTime("now", new \DateTimeZone("UTC"));
        $this->assertEquals($time->format($this->provider->getTimeWithTimeZoneFormat()),
            $this->typeMapperWithNoProvider->toSQLTimeWithTimeZone($time, $this->provider));
        $this->assertEquals($time->format($this->provider->getTimeWithTimeZoneFormat()),
            $this->typeMapperWithProvider->toSQLTimeWithTimeZone($time));
    }

    /**
     * Tests converting to an SQL time without time zone
     */
    public function testConvertingToSQLTimeWithoutTimeZone()
    {
        $time = new \DateTime("now", new \DateTimeZone("UTC"));
        $this->assertEquals($time->format($this->provider->getTimeWithoutTimeZoneFormat()),
            $this->typeMapperWithNoProvider->toSQLTimeWithoutTimeZone($time, $this->provider));
        $this->assertEquals($time->format($this->provider->getTimeWithoutTimeZoneFormat()),
            $this->typeMapperWithProvider->toSQLTimeWithoutTimeZone($time));
    }

    /**
     * Tests converting to an SQL timestamp with time zone
     */
    public function testConvertingToSQLTimestampWithTimeZone()
    {
        $timestamp = new \DateTime("now", new \DateTimeZone("UTC"));
        $this->assertEquals($timestamp->format($this->provider->getTimestampWithTimeZoneFormat()),
            $this->typeMapperWithNoProvider->toSQLTimestampWithTimeZone($timestamp, $this->provider));
        $this->assertEquals($timestamp->format($this->provider->getTimestampWithTimeZoneFormat()),
            $this->typeMapperWithProvider->toSQLTimestampWithTimeZone($timestamp));
    }

    /**
     * Tests converting to an SQL timestamp without time zone
     */
    public function testConvertingToSQLTimestampWithoutTimeZone()
    {
        $timestamp = new \DateTime("now", new \DateTimeZone("UTC"));
        $this->assertEquals($timestamp->format($this->provider->getTimestampWithoutTimeZoneFormat()),
            $this->typeMapperWithNoProvider->toSQLTimestampWithoutTimeZone($timestamp, $this->provider));
        $this->assertEquals($timestamp->format($this->provider->getTimestampWithoutTimeZoneFormat()),
            $this->typeMapperWithProvider->toSQLTimestampWithoutTimeZone($timestamp));
    }

    /**
     * Tests converting to a true SQL boolean
     */
    public function testConvertingToTrueSQLBoolean()
    {
        $this->assertEquals($this->provider->getTrueBooleanFormat(),
            $this->typeMapperWithNoProvider->toSQLBoolean(true, $this->provider));
        $this->assertEquals($this->provider->getTrueBooleanFormat(),
            $this->typeMapperWithProvider->toSQLBoolean(true));
    }

    /**
     * Tests not setting any providers
     */
    public function testNotSettingAnyProviders()
    {
        $this->setExpectedException("\\RuntimeException");
        $typeMapper = new TypeMapper();
        $typeMapper->toSQLBoolean(true);
    }

    /**
     * Tests setting the provider in the constructor
     */
    public function testSettingProviderInConstructor()
    {
        $typeMapper = new TypeMapper($this->provider);
        $this->assertSame($this->provider, $typeMapper->getProvider());
    }

    /**
     * Tests setting the provider in the setter
     */
    public function testSettingProviderInSetter()
    {
        $typeMapper = new TypeMapper();
        $typeMapper->setProvider($this->provider);
        $this->assertSame($this->provider, $typeMapper->getProvider());
    }
} 