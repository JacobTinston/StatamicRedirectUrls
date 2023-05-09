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
            if (! $data['From'] || ! $data['To'] || ! $data['Type']) {
                $skipped++;

                return;
            }

            try {
                if (! Redirect::query()->where('from', $data['From'])->first()) {
                    $redirect = Redirect::make()
                        ->from($data['From'])
                        ->to($data['To'])
                        ->type($data['Type'])
                        ->active(true);

                    $redirect->save();
                }
            } catch (\Exception $e) {
                $skipped++;

                return;
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
