<?php

declare(strict_types=1);

namespace SimpleSAML\SPID\Exception;

use InvalidArgumentException;

/**
 * This exception may be raised when a violation of the SPID is detected
 *
 * @package simplesamlphp/saml2-module-spid
 */
class ProtocolViolationException extends InvalidArgumentException
{
}
