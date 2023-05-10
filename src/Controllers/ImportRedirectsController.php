<?php

namespace Surgems\RedirectUrls\Controllers;

use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use Surgems\RedirectUrls\Facades\Redirect;

class ImportRedirectsController
{
    public function index()
    {
        return view('redirect-urls::csv-import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);

        $file = $request->file('file');
        $delimiter = ',';

        $extension = with($file->extension(), fn ($ext) => $ext === 'txt' ? 'csv' : $ext);

        $reader = SimpleExcelReader::create($file->getRealPath(), $extension)
            ->useDelimiter($delimiter);

        $skipped = 0;
        $reader->getRows()->each(function (array $data) use (&$skipped) {
            $data = array_values($data);

            $from = isset($data[0]) ? rtrim(parse_url($data[0])['path'], '/') : '/';
            $to = isset($data[1]) ? rtrim(parse_url($data[1])['path'], '/') : '/';
            $type = isset($data[2]) ? intval($data[2]) : 301;
            $active = $data[3] ?? true;

            if ($from != '/' && ! Redirect::query()->where('from', $from)->first()) {
                try {
                    $redirect = Redirect::make()
                        ->from($from)
                        ->to($to)
                        ->type($type)
                        ->active($active);

                    $redirect->save();
                } catch (\Exception $e) {
                    return $skipped++;
                }
            } else {
                return $skipped++;
            }
        });

        $message = 'Redirects imported successfully.';

        if ($skipped > 0) {
            $message .= " {$skipped} rows skipped due to invalid data.";
        }

        session()->flash('success', $message);

        return redirect()->route('statamic.cp.redirect-urls.dashboard');
    }
}
