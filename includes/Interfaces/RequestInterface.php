<?php declare(strict_types=1);

namespace Am\APIPlugin\Interfaces;

interface RequestInterface
{
    public function get( $url, $args = []);

    public function post( $url, $args = []);

    public function put( $url, $args = []);

    public function patch( $url, $args = []);

    public function delete( $url, $args = []);
}