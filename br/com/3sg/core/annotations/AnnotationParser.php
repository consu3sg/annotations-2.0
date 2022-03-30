<?php

/**
 * The <b>AnnotationParser</b> has some useful functions which 
 * can be used with an instance of AnnotationObject
 * 
 * @package    br.com.3sg.core.annotations
 * @subpackage Core
 * @author     Guilherme Oliveira Toccacelli <consu3sg@gmail.com>
 */
abstract class AnnotationParser {

    /**
     * Parses a docComment to an instance of Annotation
     * @param type $docComment
     * @return \Annotation
     */
    public static function parse(string $docComment): Annotation {
        $text = AnnotationParser::uncomment($docComment);
        $evaluatedText = AnnotationParser::replaceConstants($text);
        $annotations = AnnotationParser::retrieveAnnotations($evaluatedText);
        $map = [];
        forEach ($annotations as $annotation) {
            $parameters = [];
            $hasParameters = preg_match('/(?<=' . $annotation . '[\(])[\w\W]*?(?=[\)])/', $evaluatedText, $parameters);
            if ($hasParameters) {
                $quotedJson = preg_replace("/([{,])(\s*)([A-Za-z0-9_\-]+?)\s*:/", "$1\"$3\":", $parameters[0]);
                $map[$annotation] = AnnotationParser::parseJson($quotedJson);
            } else {
                $map[$annotation] = [];
            }
        }
        return new Annotation($map);
    }

    /**
     * Function returns array with all annoted value
     * @param type $contents
     * @return array
     */
    private static function retrieveAnnotations(string $contents): array {
        $regex = '/@[A-Z]{1}[a-zA-Z][a-zA-Z0-9]*(?=(([^"]*"){2})*[^"]*$)/';
        $annotations = [];
        preg_match_all($regex, $contents, $annotations);
        return $annotations[0];
    }

    /**
     * Function replaces the constants in the given text
     * @param string $text
     * @return string replaced with constants values
     */
    private static function replaceConstants(string $text): string {
        global $ANNOTATION_CONSTANTS;
        if (isset($ANNOTATION_CONSTANTS) && !empty($ANNOTATION_CONSTANTS)) {
            foreach ($ANNOTATION_CONSTANTS as $class => $className) {
                foreach ($className as $attribute => $value) {
                    if (gettype($value) === 'string') {
                        $value = "\"$value\"";
                    }
                    $text = AnnotationParser::replaceOutsideQuotes("$class.$attribute", $value, $text);
                }
            }
        }
        return $text;
    }

    /**
     * Function replaces all occurrences of the search string with the replacement string outside of single or double quotes
     * @param string $replace
     * @param string $with
     * @param string $string
     * @return text replaced with given string
     */
    private static function replaceOutsideQuotes(string $replace, string $with, string $string): string {
        $result = '';
        $outside = preg_split('/("[^"]*"|\'[^\']*\')/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        while ($outside) {
            $result .= str_replace($replace, $with, array_shift($outside)) . array_shift($outside);
        }
        return $result;
    }

    /**
     * Method uncomments the document comments 
     * @param string $docComments
     * @return uncomment text
     */
    private static function uncomment(string $docComments): string {
        $text = preg_replace('/[\/\/]*(?=(([^"]*"){2})*[^"]*$)(?=(([^\']*\'){2})*[^\']*$)/', "", $docComments);
        return preg_replace('/[*]*(?=(([^"]*"){2})*[^"]*$)/', '', preg_replace('/[\/]*(?=(([^"]*"){2})*[^"]*$)(?=(([^\']*\'){2})*[^\']*$)/', '', trim($text)));
    }

    /**
     * Method validates json and converts it to JSON Object
     * @param string $value - value to decode as JSON
     * @return JSON Object
     * @throws Exception
     */
    private static function parseJson(string $value) {
        $json = json_decode($value);
        if (json_last_error()) {
            throw new Exception(json_last_error_msg());
        }
        return $json;
    }

}
