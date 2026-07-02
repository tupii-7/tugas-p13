<?php

namespace App\Http\Controllers;

use App\Exports\AnggotaExport;
use App\Models\Anggota;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AnggotaController extends Controller
{
    /**
     * Display list of members with search, pagination and sorting
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Anggota::query();

        // Keyword search for nama, email, or telepon
        $keyword = $request->input('keyword', $request->input('search'));
        if (!empty($keyword)) {
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('telepon', 'like', "%{$keyword}%");
            });
        }

        // Filter by jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by pekerjaan
        if ($request->filled('pekerjaan')) {
            $query->where('pekerjaan', $request->input('pekerjaan'));
        }

        // Sorting
        $sortBy = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        
        if (in_array($sortBy, ['nama', 'email', 'created_at', 'status'])) {
            $query->orderBy($sortBy, $sortDir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $anggota = $query->paginate(15)->withQueryString();

        // Statistics
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'Nonaktif')->count();

        return view('perpustakaan.anggota.index', [
            'anggota' => $anggota,
            'totalAnggota' => $totalAnggota,
            'anggotaAktif' => $anggotaAktif,
            'anggotaNonaktif' => $anggotaNonaktif,
        ]);
    }

    protected function generateKodeAnggota(): string
    {
        $year = now()->format('Y');

        $lastKode = Anggota::where('kode_anggota', 'like', "AGT-{$year}-%")
            ->orderBy('kode_anggota', 'desc')
            ->value('kode_anggota');

        $nextNumber = 1;

        if ($lastKode && preg_match("/^AGT-{$year}-(\d+)$/", $lastKode, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        }

        return sprintf('AGT-%s-%04d', $year, $nextNumber);
    }

    public function create(): View
    {
        return view('perpustakaan.anggota.create', [
            'kodeAnggota' => $this->generateKodeAnggota(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => 'required|string|max:200',
            'email' => 'required|email|max:150|unique:anggota,email',
            'telepon' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:100',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|string|in:Aktif,Nonaktif',
        ]);

        $data['kode_anggota'] = $this->generateKodeAnggota();

        Anggota::create($data);

        return redirect('/anggota')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function export()
    {
        $fileName = 'anggota_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new AnggotaExport(), $fileName);
    }

    public function edit(Anggota $anggota): View
    {
        return view('perpustakaan.anggota.edit', [
            'anggota' => $anggota,
        ]);
    }

    public function update(Request $request, Anggota $anggota): RedirectResponse
    {
        $data = $request->validate([
            'kode_anggota' => [
                'required',
                'max:20',
                Rule::unique('anggota')->ignore($anggota->id),
            ],
            'nama' => 'required|string|max:200',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('anggota')->ignore($anggota->id),
            ],
            'telepon' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:100',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|string|in:Aktif,Nonaktif',
        ]);

        $anggota->update($data);

        return redirect('/anggota')->with('success', 'Anggota berhasil diperbarui.');
    }
}
