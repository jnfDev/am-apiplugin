<?php declare(strict_types=1);

namespace Am\APIPlugin\Exceptions;

use Exception;
use Throwable;

defined( 'ABSPATH' ) || exit;

class WpdbNotDefinedException extends Exception {

    public function __construct(
        string $message = "Wpdb is not defined", 
        int $code = 0, 
        Throwable $previous = null
    ) {
        parent::__construct( $message, $code, $previous );
    }
}
