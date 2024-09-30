# Bootstrap
- Bootstrap is frontend development toolkit you just include their css/js cdn links read their docs on how to you use and voila
- container => will put the element into a box instead of it taking the whole area
- card will take a card shape with square and => card-header, card-body classes
- table calss = prettier table
- btn btn-danger btn-success btn-ouline-danger (danger on hover)
# HTML
- <a target="_blank"> => will open in new tab
- if you are uploading an image you should add in the form enctype="multipart/form-data" => so that the browser don't do the default url-encoding which will corrupt the image and also will add the meta-data in the request, ...etc
# PHP
- file_get_contents(path), file_put_contents(path, data)
- jsond_decode($data, true) => true to return an assoc array, json_encode($data)
- array_merge($arr1, $arr2) => combine the 2 arrays overwriting arr1 if necessary
- unset($var), is_numeric()
- filter_var($var, FITLER_VALIDATE_...)
- move_uploaded_file(tmp, path)

// LFI
// assiging id error