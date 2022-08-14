<?php declare(strict_types=1);

namespace Am\APIPlugin\Interfaces;

interface RequestInterface
{
    /**
     * Get request.
     * 
     * @param string $url Request's URL. 
     * @param array $args Request's args.
     * 
     * @return array
     */
    public function get( string $url, array $args = [] ): array;

    /**
     * POST request
     * @param string $url Request's URL. 
     * @param array $args Request's args.
     * 
     * @return array
     */
    public function post( string $url, array $args = [] ): array;

    /**
     * PUT request
     * @param string $url Request's URL. 
     * @param array $args Request's args.
     * 
     * @return array
     */
    public function put( string $url, array $args = [] ): array;

    /**
     * PATCH request
     * @param string $url Request's URL. 
     * @param array $args Request's args.
     * 
     * @return array
     */
    public function patch( string $url, array $args = [] ): array;

    /**
     * DELETE request
     * @param string $url Request's URL. 
     * @param array $args Request's args.
     * 
     * @return array
     */
    public function delete( string $url, array $args = [] ): array;
}