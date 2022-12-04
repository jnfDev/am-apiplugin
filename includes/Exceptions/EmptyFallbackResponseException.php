<?php declare(strict_types=1);

namespace Am\APIPlugin\Exceptions;

use Exception;
use Throwable;

defined( 'ABSPATH' ) || exit;

class EmptyFallbackResponseException extends Exception {

    public function __construct(
        $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        $message = empty( $message ) ? esc_html__( 'Empty Fallback Response', 'am-apiplugin' ) : $message;
        parent::__construct( $message, $code, $previous );
    }

}