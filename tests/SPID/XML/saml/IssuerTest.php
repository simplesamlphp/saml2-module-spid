<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SPID\XML\saml;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SAML2\Constants;
use SimpleSAML\SAML2\Type\SAMLStringValue;
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
            SAMLStringValue::fromString('urn:x-simplesamlphp:issuer'),
            SAMLStringValue::fromString('urn:x-simplesamlphp:namequalifier'),
        );

        $this->assertEquals('urn:x-simplesamlphp:issuer', $issuer->getContent()->getValue());
        $this->assertEquals('urn:x-simplesamlphp:namequalifier', $issuer->getNameQualifier()->getValue());
        $this->assertNull($issuer->getSPNameQualifier());
        $this->assertEquals(Constants::NAMEID_ENTITY, $issuer->getFormat()->getValue());
        $this->assertNull($issuer->getSPProvidedID());

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($issuer),
        );
    }
}
