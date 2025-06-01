<?php

namespace App\Http\Controllers;

use App\Models\constituency;
use App\Models\pollingStation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PollingStationController extends Controller
{
    public function create()
    {
        return view('managment.polling-station', ['user' => Auth::user(), 'links' => ['timeline', 'polling-station', 'constituency', 'political-parties'], 'stations' => pollingStation::all()]);
    }
    public function store(Request $request)
    {
        // Check if CSV is uploaded
        if ($request->hasFile('csvfile')) {
            $validator = Validator::make($request->all(), [
                'csvfile' => 'required|file|mimes:csv,txt|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $path = $request->file('csvfile')->getRealPath();
            $file = fopen($path, 'r');

            $header = fgetcsv($file);
            $expected = ['pollingstation', 'constituency'];

            if (!$header || array_map('strtolower', $header) !== $expected) {
                return back()->withErrors(['csvfile' => 'CSV must have headers: pollingstation, constituency'])->withInput();
            }

            $validData = [];
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) !== 2) continue;

                $station = trim($row[0]);
                $constituency = trim($row[1]);

                if (!$station || !$constituency) continue;

                $constituency = DB::table('constituencies')
                    ->where('name', $constituency)
                    ->first();

                if (!$constituency) continue;

                // Check uniqueness
                $exists = DB::table('polling_stations')
                    ->where('name', $station)
                    ->where('constituency_id', $constituency->id)
                    ->exists();

                if (!$exists) {
                    $validData[] = [
                        'name' => $station,
                        'constituency_id' => $constituency->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            fclose($file);

            if (empty($validData)) {
                return back()->withErrors(['csvfile' => 'All rows already exist or data invalid.'])->withInput();
            }

            try {
                DB::table('polling_stations')->insert($validData);
                return back()->with('success', count($validData) . ' polling stations uploaded.');
            } catch (\Exception $e) {
                Log::error('CSV Upload Error (Polling Station): ' . $e->getMessage());
                return back()->withErrors(['csvfile' => 'Error while saving data.'])->withInput();
            }
        }

        // Check if user is attempting a manual entry
        elseif ($request->anyFilled(['pollingstation', 'constituency'])) {
            // Validate properly
            $validated = $request->validate([
                'pollingstation' => 'required|string|max:255',
                'constituency' => 'required|string|max:255',
            ]);
            $constituency = DB::table('constituencies')
                ->where('name', $validated['constituency'])
                ->first();
            if (!$constituency) {
                return back()->withErrors(['constituency' => 'This constituency name was not found.'])->withInput();
            }

            // Check uniqueness
            $exists = DB::table('polling_stations')
                ->where('name', $validated['pollingstation'])
                ->where('constituency_id', $constituency->id)
                ->exists();

            if ($exists) {
                return back()->withErrors(['pollingstation' => 'This polling station already exists for the selected constituency.'])->withInput();
            }

            try {
                DB::table('polling_stations')->insert([
                    'name' => $validated['pollingstation'],
                    'constituency_id' => $constituency->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return back()->with('success', 'Polling station added successfully.');
            } catch (\Exception $e) {
                Log::error('Manual Add Error (Polling Station): ' . $e->getMessage());
                return back()->withErrors(['pollingstation' => 'Something went wrong while saving data.'])->withInput();
            }
        }

        // If neither manual nor CSV attempt
        else {
            return back()->withErrors(['pollingstation' => 'Please enter polling station manually or upload CSV.'])->withInput();
        }
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'constituency' => 'required|string|max:255|exists:constituencies,name',
        ]);
        try {
            $ps = pollingStation::find($request->id);
            $ps->name =  $validated['name'];
            $ps->constituency_id = constituency::where('name', $validated['constituency'])->firstOrFail()->id;
            $ps->save();
            return back()->with(['success' => 'polling station uodated successfully']);
        } catch (Exception $e) {
            return back()->with(['success' => 'some internal error occured']);
        }
    }
}
