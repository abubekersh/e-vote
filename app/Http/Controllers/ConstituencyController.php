<?php

namespace App\Http\Controllers;

use App\Models\constituency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ConstituencyController extends Controller
{
    public function index()
    {
        return view('results.constituencies', ['constituencies' => constituency::orderBy('created_at')->paginate(10)]);
    }
    public function create()
    {
        return view('managment.constituencies', ['user' => Auth::user(), 'links' => ['timeline', 'polling-station', 'constituency', 'political-parties'], 'constituencies' => constituency::all()]);
    }
    public function store(Request $request)
    {
        // dd($request);
        // CSV Upload Mode
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
            $expected = ['name', 'region', 'woreda'];

            if (!$header || array_map('strtolower', $header) !== $expected) {
                return back()->withErrors(['csvfile' => 'CSV must have headers: name, region, woreda'])->withInput();
            }

            $validData = [];
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) !== 3) continue;

                $name = trim($row[0]);
                $region = trim($row[1]);
                $woreda = trim($row[2]);

                if (!$name || !$region || !$woreda) continue;

                $exists = DB::table('constituencies')
                    ->where('name', $name)
                    ->where('region', $region)
                    ->where('woreda', $woreda)
                    ->exists();

                if (!$exists) {
                    $validData[] = [
                        'name' => $name,
                        'region' => $region,
                        'woreda' => $woreda,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            fclose($file);

            if (empty($validData)) {
                return back()->withErrors(['csvfile' => 'All constituencies already exist or no valid data found.'])->withInput();
            }

            try {
                DB::table('constituencies')->insert($validData);
                return back()->with('success', count($validData) . ' unique constituencies uploaded.');
            } catch (\Exception $e) {
                Log::error('CSV Upload Error (Constituency): ' . $e->getMessage());
                return back()->withErrors(['csvfile' => 'Error occurred while saving data.'])->withInput();
            }
        }

        // Manual Entry Mode
        elseif ($request->anyFilled(['name', 'woreda', 'region'])) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'woreda' => 'required|string|max:255',
            ]);

            $exists = DB::table('constituencies')
                ->where('name', $validated['name'])
                ->where('region', $validated['region'])
                ->where('woreda', $validated['woreda'])
                ->exists();

            if ($exists) {
                return back()->withErrors(['name' => 'This constituency already exists.'])->withInput();
            }

            try {
                DB::table('constituencies')->insert([
                    'name' => $validated['name'],
                    'region' => $validated['region'],
                    'woreda' => $validated['woreda'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return back()->with('success', 'Constituency added successfully.');
            } catch (\Exception $e) {
                Log::error('Manual Add Error (Constituency): ' . $e->getMessage());
                return back()->withErrors(['name' => 'Something went wrong while adding the constituency.'])->withInput();
            }
        }

        // No valid input
        else {
            return back()->withErrors(['name' => 'Please enter data manually or upload a valid CSV file.'])->withInput();
        }
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'woreda' => 'required|string|max:255'
        ]);
        try {
            $c = constituency::find($request->id);
            $c->name =  $validated['name'];
            $c->region = $validated['region'];
            $c->woreda = $validated['woreda'];
            $c->save();
            return back()->with(['success' => 'polling station uodated successfully']);
        } catch (Exception $e) {
            return back()->with(['success' => 'some internal error occured']);
        }
    }
}
