<?php

declare(strict_types=1);

namespace SPID\XML\saml;

use PHPUnit\Framework\TestCase;
use SimpleSAML\SAML2\Constants;
use SimpleSAML\SAML2\Exception\InvalidArgumentException;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\Test\XML\SerializableXMLTestTrait;;

/**
 * Class \SAML2\XML\saml\IssuerTest
 */
class IssuerTest extends TestCase
{
    use SerializableXMLTestTrait;


    /**
     * @return void
     */
    public function setup(): void
    {
        $this->testedClass = Issuer::class;


        $samlNamespace = Issuer::NS;
        $nameidEntity = Constants::NAMEID_ENTITY;
        $this->xmlRepresentation = DOMDocumentFactory::fromString(<<<XML
<saml:Issuer
  xmlns:saml="{$samlNamespace}"
  NameQualifier="TheNameQualifier"
  Format="{$nameidEntity}">TheIssuerValue</saml:Issuer>
XML
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
