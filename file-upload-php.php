<?php 

class File {

    /** Upload
     * Required values (
     *  $file           : Value of $_FILES['name']
     *  $name_file      : Name of saved file
     *  $target_path    : Route for saved file
     * )
     * 
     * Return values: Array(
     *  'success'       => false | true,
     *  'file_name'     => 'string_name.extension',
     *  'file_ext'      => '.extension';
     * )
     */

	public static function upload($file, $name_file, $target_path ){ ///  $_FILES['pdf']
        $response['success'] = false;

        if( $file['error'] != UPLOAD_ERR_NO_FILE){ 
            $path = $file['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $target_path = "static/img/facturas/".$orden_id."/"; // CARPETA
            if( !is_dir($target_path)){ mkdir($target_path); }
            // $name_file = $orden_id.'_'.$num_index.'.'.$ext;
            $target_path = $target_path . $name_file.'.'.$ext;	
            
            if(move_uploaded_file($file['tmp_name'], $target_path)) { 
                $response['success']    = true;
                $response['file_name']  = $name_file.'.'.$ext;
                $response['file_ext']   = $ext;
            } else{
                $response['error'] = "Unknown upload error"; 
                switch ($file['error']) { 
                    case UPLOAD_ERR_INI_SIZE: 
                        $response['error'] = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
                        break; 
                    case UPLOAD_ERR_FORM_SIZE: 
                        $response['error'] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
                        break; 
                    case UPLOAD_ERR_PARTIAL: 
                        $response['error'] = "The uploaded file was only partially uploaded"; 
                        break; 
                    case UPLOAD_ERR_NO_FILE: 
                        $response['error'] = "No file was uploaded"; 
                        break; 
                    case UPLOAD_ERR_NO_TMP_DIR: 
                        $response['error'] = "Missing a temporary folder"; 
                        break; 
                    case UPLOAD_ERR_CANT_WRITE: 
                        $response['error'] = "Failed to write file to disk"; 
                        break; 
                    case UPLOAD_ERR_EXTENSION: 
                        $response['error'] = "File upload stopped by extension"; 
                        break; 

                    default: 
                        $response['error'] = "Unknown upload error"; 
                        break; 
                }
            }
        } else { $response['error'] = "No file input."; }

        return $response;
    }
}