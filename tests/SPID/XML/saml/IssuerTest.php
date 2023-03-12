<?php

declare(strict_types=1);

namespace SPID\XML\saml;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SAML2\Constants;
use SimpleSAML\SAML2\Exception\InvalidArgumentException;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Class \SAML2\XML\saml\IssuerTest
 */
class IssuerTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     * @return void
     */
    public function setup(): void
    {
        $this->testedClass = Issuer::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 5) . '/resources/xml/saml_Issuer.xml'
        );
    }


    /**
     * @return void
     */
    public function testMarshalling(): void
    {
        $issuer = new Issuer(
            'TheIssuerValue',
            'TheNameQualifier'
        );

        $this->assertEquals('TheIssuerValue', $issuer->getContent());
        $this->assertEquals('TheNameQualifier', $issuer->getNameQualifier());
        $this->assertNull($issuer->getSPNameQualifier());
        $this->assertEquals(Constants::NAMEID_ENTITY, $issuer->getFormat());
        $this->assertNull($issuer->getSPProvidedID());

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($issuer)
        );
    }


    /**
     * @return void
     */
    public function testUnmarshalling(): void
    {
        $issuer = Issuer::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals('TheIssuerValue', $issuer->getContent());
        $this->assertEquals('TheNameQualifier', $issuer->getNameQualifier());
        $this->assertNull($issuer->getSPNameQualifier());
        $this->assertEquals(Constants::NAMEID_ENTITY, $issuer->getFormat());
        $this->assertNull($issuer->getSPProvidedID());
    }


    /**
     * @return void
     */
    public function testUnmarshallingInvalidAttr(): void
    {
        $element = $this->xmlRepresentation->documentElement;
        $element->setAttribute('SPProvidedID', 'TheSPProvidedID');
        $element->setAttribute('SPNameQualifier', 'TheSPNameQualifier');

        $issuer = Issuer::fromXML($element);

        $this->assertEquals('TheIssuerValue', $issuer->getContent());
        $this->assertEquals('TheNameQualifier', $issuer->getNameQualifier());
        $this->assertNull($issuer->getSPNameQualifier());
        $this->assertEquals(Constants::NAMEID_ENTITY, $issuer->getFormat());
        $this->assertNull($issuer->getSPProvidedID());
    }
}
