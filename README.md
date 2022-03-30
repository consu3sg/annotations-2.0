# annotations
If you want to create your own PHP Framework, this little package will be very useful.

Requires PHP >= 7.2

# annotations constants

You can define the constants in a simple PHP file as below

Constants Creation
	File Name: constants.php (import the this file before including library)
	
        <?php

        global $ANNOTATION_CONSTANTS;

        $ANNOTATION_CONSTANTS = [
            "HttpMethod" => [
                "POST" => "POST",
                "GET" => "GET",
            ],
            "MediaType" => [
                "APPLICATION_ATOM_XML" => "application/atom+xml",
                "APPLICATION_FORM_URLENCODED" => "application/x-www-form-urlencoded",
                "APPLICATION_JSON" => "application/json",
                "APPLICATION_OCTET_STREAM" => "application/octet-stream",
                "APPLICATION_SVG_XML" => "application/svg+xml",
                "APPLICATION_XHTML_XML" => "application/xhtml+xml",
                "APPLICATION_XML" => "application/xml",
                "CHARSET_PARAMETER" => "*",
                "MULTIPART_FORM_DATA" => "multipart/form-data",
                "TEXT_HTML" => "text/html",
                "TEXT_PLAIN" => "text/plain",
                "TEXT_XML" => "text/xml",
                "WILDCARD" => "*/*",
            ]
        ];


	
	
Usage

    /**
     * @Produces("Content-Type: application/json")
     * @RequestMapping({value: "/dashboard/{action}", method: HttpMethod.POST})
     */
    public function execute(string $action) {
        return $action;
    }
	
Note

	The constant HttpMethod.POST will be replaced with "POST" when the annotation is parsed