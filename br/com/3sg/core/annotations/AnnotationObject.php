<?php

require_once 'AnnotationParser.php';
require_once 'Annotation.php';

/**
 * The <b>AnnotationObject</b> reports 
 * information about an annotation from classes, methods or properties
 * 
 * @package    br.com.3sg.core.annotations
 * @subpackage Core
 * @author     Guilherme Oliveira Toccacelli <consu3sg@gmail.com>
 */
class AnnotationObject {

    private $reflection;

    /**
     * Contructs an AnnotationObject
     * @param type $target
     */
    public function __construct($target) {
        $this->reflection = is_object($target) ?
                new ReflectionObject($target) : new ReflectionClass($target);
    }

    /**
     * Returns an instance of Class Annotation 
     * @param string $methodName
     * @return Annotation
     * @throws Exception
     */
    function getMethodAnnotations(string $methodName): ?Annotation {
        if ($this->reflection->hasMethod($methodName)) {
            return AnnotationParser::parse($this->reflection->getMethod($methodName)->getDocComment());
        } else {
            throw new Exception("Method not found...");
        }
    }

    /**
     * Returns an instance of Class Annotation 
     * @param string $propertyName
     * @return Annotation
     * @throws Exception
     */
    function getPropertyAnnotations(string $propertyName): ?Annotation {
        if ($this->reflection->hasProperty($propertyName)) {
            return AnnotationParser::parse($this->reflection->getProperty($propertyName)->getDocComment());
        } else {
            throw new Exception("Property not found...");
        }
    }

    /**
     * Returns an instance of Class Annotation
     * @return Annotation
     */
    function getClassAnnotations(): ?Annotation {
        return AnnotationParser::parse($this->reflection->getDocComment());
    }

}
