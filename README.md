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
		"HttpMethod.POST" => "\"POST\"",
		"HttpMethod.GET" => "\"GET\""
	];
	?>
	
	
Usage

    /**
     * @Produces(MediaType.APPLICATION_JSON)
     * @RequestMapping({value: "/dashboard/{action}", method: HttpMethod.POST})
     */
    public function execute(string $action) {
        return $action;
    }
	
Note

	The constant HttpMethod.POST will be replaced with "POST" when the annotation is parsed