<?php

/**
 * The <b>Annotation</b> represents a group of annotaions as a complex array
 * 
 * @package    br.com.3sg.core.annotations
 * @subpackage Core
 * @author     Guilherme Oliveira Toccacelli <consu3sg@gmail.com>
 */
class Annotation {

    private array $map;

    public function __construct(array $map = []) {
        $this->map = $map;
    }

    /**
     * Returns all annotations as an array
     * @return type
     */
    public function toArray(): array {
        return $this->map;
    }

    /**
     * Returns the matching object in the annotation array
     * @param type $name
     * @return type
     */
    public function get(string $name) {
        return $this->map[$name];
    }

    /**
     * Tells if the annotation exists
     * @param type $annotation
     * @return type
     */
    public function contains(string $annotation): bool {
        return isset($this->map[$annotation]);
    }

}
