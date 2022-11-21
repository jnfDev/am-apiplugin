<?php declare(strict_types=1);

namespace Am\APIPlugin\Exceptions;

use Exception;
use Throwable;

defined( 'ABSPATH' ) || exit;

class InvalidSettingNameException extends Exception {

    public function __construct(
        $message = "Invalid Setting Name",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct( $message, $code, $previous );
    }

}