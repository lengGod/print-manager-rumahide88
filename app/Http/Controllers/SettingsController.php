<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    use Spatie\DbDumper\Exceptions\DumpFailed;

// ... (rest of the imports)

// ... (inside the class)
    public function backupDatabase()
    {
        try {
            // Ensure the backup directory exists.
            $backupDirectory = 'backups';
            Storage::disk('local')->makeDirectory($backupDirectory);

            $fileName = 'rumahide88-backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
            $path = storage_path('app/' . $backupDirectory . '/' . $fileName);

            MySql::create()
                ->setDbName(config('database.connections.mysql.database'))
                ->setUserName(config('database.connections.mysql.username'))
                ->setPassword(config('database.connections.mysql.password'))
                ->setPort(config('database.connections.mysql.port'))
                ->dumpToFile($path);

            return response()->download($path)->deleteFileAfterSend(true);
        } catch (DumpFailed $e) {
            // Redirect back with an error message.
            return back()->with('error', 'Gagal membuat cadangan basis data: ' . $e->getMessage());
        }
    }
}
