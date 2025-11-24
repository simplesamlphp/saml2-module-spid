<?php

declare(strict_types=1);

namespace SimpleSAML\SPID\XML\saml;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SAML2\Constants as C;
use SimpleSAML\SAML2\Type\SAMLAnyURIValue;
use SimpleSAML\SAML2\Type\SAMLStringValue;
use SimpleSAML\SAML2\XML\saml\NameIDType;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;

/**
 * Class representing the saml:Issuer element compliant with SPID specification.
 *
 * @package simplesamlphp/saml2-module-spid
 */
final class Issuer extends NameIDType
{
    /**
     * Initialize a saml:Issuer conforming to SPID specification
     *
     * @param \SimpleSAML\SAML2\Type\SAMLStringValue $value
     * @param \SimpleSAML\SAML2\Type\SAMLStringValue $NameQualifier
     */
    public function __construct(
        SAMLStringValue $value,
        SAMLStringValue $NameQualifier,
    ) {
        parent::__construct($value, $NameQualifier, null, SAMLAnyURIValue::fromString(C::NAMEID_ENTITY));
    }


    /**
     * Convert XML into an Issuer
     *
     * @param \DOMElement $xml The XML element we should load
     *
     * @return static
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Issuer', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Issuer::NS, InvalidDOMElementException::class);

        $format = self::getAttribute($xml, 'Format', SAMLAnyURIValue::class);
        Assert::true($format->equals(C::NAMEID_ENTITY));

        return new static(
            SAMLStringValue::fromString($xml->textContent),
            self::getAttribute($xml, 'NameQualifier', SAMLStringValue::class),
        );
    }
}
