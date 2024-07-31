<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SPID\XML\saml;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SAML2\Constants;
use SimpleSAML\SPID\XML\saml\Issuer;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\SPID\XML\saml\IssuerTest
 */
#[Group('SPID')]
#[CoversClass(Issuer::class)]
class IssuerTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     * @return void
     */
    public static function setupBeforeClass(): void
    {
        self::$testedClass = Issuer::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/saml_Issuer.xml',
        );
    }


    /**
     * @return void
     */
    public function testMarshalling(): void
    {
        $issuer = new Issuer(
            'TheIssuerValue',
            'TheNameQualifier',
        );

        $this->assertEquals('TheIssuerValue', $issuer->getContent());
        $this->assertEquals('TheNameQualifier', $issuer->getNameQualifier());
        $this->assertNull($issuer->getSPNameQualifier());
        $this->assertEquals(Constants::NAMEID_ENTITY, $issuer->getFormat());
        $this->assertNull($issuer->getSPProvidedID());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuer),
        );
    }


    /**
     * @return void
     */
    public function testUnmarshalling(): void
    {
        $issuer = Issuer::fromXML(self::$xmlRepresentation->documentElement);

        $this->assertEquals('TheIssuerValue', $issuer->getContent());
        $this->assertEquals('TheNameQualifier', $issuer->getNameQualifier());
        $this->assertNull($issuer->getSPNameQualifier());
        $this->assertEquals(Constants::NAMEID_ENTITY, $issuer->getFormat());
        $this->assertNull($issuer->getSPProvidedID());
    }
}
