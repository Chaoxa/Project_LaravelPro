<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminDropzonejs extends Controller
{
    function view()
    {
        return view('admin.dropzonejs.view');
    }

    function add()
    {
        // $filename = $_FILES['file']['name'];
        // $location = "public/uploads/" . $filename;
        // move_uploaded_file($_FILES["file"]["tmp_name"], $location);

        if (isset($_FILES["file"]["name"])) {

            // File name
            $filename = $_FILES['file']['name'];

            // Location
            $location = "public/uploads/" . $filename;

            // File size
            $filesize = $_FILES['file']['size'];

            // Maximum file size in bytes
            $max_size = 2000000; // 2MB

            if ($filesize > $max_size) {

                // Return response
                $response['status'] = 0;
                $response['msg'] = "Tệp vượt quá kích thước tệp tối đa là 2 MB.";
                echo json_encode($response);
                exit;
            }

            // Extension
            $extension = pathinfo($location, PATHINFO_EXTENSION);
            $extension = strtolower($extension);

            // Allowed file extensions 
            $acceptfile_ext = array("jpeg", "jpg", "png");

            // Check file extension 
            if (in_array($extension, $acceptfile_ext)) {

                // Upload file
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $location)) {

                    // Return response
                    $response['status'] = 1;
                    $response['msg'] = "Tải tài liệu thành công.";
                    echo json_encode($response);
                    exit;
                }
            } else {

                // Return response
                $response['status'] = 0;
                $response['msg'] = "Đuôi mở rộng tệp không hợp lệ.";
                echo json_encode($response);
                exit;
            }
        }
    }
}
