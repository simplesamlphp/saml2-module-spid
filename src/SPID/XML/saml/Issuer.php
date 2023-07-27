<?php

declare(strict_types=1);

namespace SimpleSAML\SPID\XML\saml;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SAML2\Constants as C;
use SimpleSAML\SAML2\XML\saml\NameIDType;
use SimpleSAML\SPID\Exception\ProtocolViolationException;
use SimpleSAML\XML\Exception\InvalidDOMElementException;

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
     * @param string $value
     * @param string $NameQualifier
     */
    public function __construct(
        string $value,
        string $NameQualifier
    ) {
        parent::__construct($value, $NameQualifier, null, C::NAMEID_ENTITY);
    }


    /**
     * Convert XML into an Issuer
     *
     * @param \DOMElement $xml The XML element we should load
     *
     * @return static
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     * @throws \SimpleSAML\SPID\Exception\ProtocolViolationException
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Issuer', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Issuer::NS, InvalidDOMElementException::class);

        $format = self::getAttribute($xml, 'Format');
        Assert::same($format, C::NAMEID_ENTITY, ProtocolViolationException::class);

        $nameQualifier = self::getAttribute($xml, 'NameQualifier');
        return new static($xml->textContent, $nameQualifier);
    }
}
