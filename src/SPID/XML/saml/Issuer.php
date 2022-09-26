<?php

declare(strict_types=1);

namespace SPID\XML\saml;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\SAML2\Constants;
use SimpleSAML\SAML2\XML\saml\NameIDType;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SPID\Exception\ProtocolViolationException;

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
        parent::__construct($value, $NameQualifier, null, Constants::NAMEID_ENTITY);
    }


    /**
     * Convert XML into an Issuer
     *
     * @param \DOMElement $xml The XML element we should load
     *
     * @return \SPID\XML\saml\Issuer
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     * @throws \SPID\Exception\ProtocolViolationException
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'Issuer', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, Issuer::NS, InvalidDOMElementException::class);
        Assert::same(self::getAttribute($xml, 'Format'), Constants::NAMEID_ENTITY, ProtocolViolationException::class);

        return new static($xml->textContent, self::getAttribute($xml, 'NameQualifier'));
    }
}
