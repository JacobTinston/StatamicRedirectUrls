<?php

namespace Surgems\RedirectUrls\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Surgems\RedirectUrls\Controllers\RedirectController;

class ImportRedirectsController
{
    public function index()
    {
        return view('redirect-urls::csv-import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file']
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $location = 'redirect-urls/storage';

        $this->checkUploadedFileProperties($extension, $fileSize);
        $file->move($location, $filename);
        $filepath = public_path($location . "/" . $filename);

        $file = fopen($filepath, "r");
        $redirects_array = array();
        $i = 0;
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            if ($i == 0) {
                $i++;
                continue;
            }
                for ($c = 0; $c < $num; $c++) {
                $redirects_array[$i][] = $filedata[$c];
            }

            $i++;
        }
        fclose($file);

        $controller = new RedirectController();

        $controller->setArrayOfRedirects($redirects_array);

        return redirect('/cp/redirect-urls/dashboard');
    }

    protected function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extensions = array("csv", "xlsx");
        $maxFileSize = 2097152;

        if (in_array(strtolower($extension), $valid_extensions)) {
            if ($fileSize <= $maxFileSize) {
                //
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }
    }
}
