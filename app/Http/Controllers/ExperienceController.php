<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\WorkExperience;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\EducationExperience;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $experience = Experience::with(['educations', 'works'])->orderBy('id', 'DESC')->select('*');

            return DataTables::of($experience)
                ->addColumn('action', function ($experience) {
                    return view('datatable-modal._action', [
                        'row_id' => $experience->id,
                        'edit_url' => route('experience.edit', $experience->id),
                        'delete_url' => route('experience.destroy', $experience->id),
                    ]);
                })
                ->addColumn('educations', function ($experience) {
                    $educationHtml = '<ul>';
                    foreach ($experience->educations as $education) {
                        $educationHtml .= '<li>' . $education->nama_sekolah . ', ' . $education->jurusan . ' (' . $education->tahun_masuk . ' - ' . $education->tahun_lulus . ')</li>';
                    }
                    $educationHtml .= '</ul>';
                    return $educationHtml;
                })
                ->addColumn('work_experiences', function ($experience) {
                    $workHtml = '<ul>';
                    foreach ($experience->works as $work) {
                        $workHtml .= '<li>' . $work->perusahaan . ', ' . $work->jabatan . ' (' . $work->tahun . ')</li>';
                    }
                    $workHtml .= '</ul>';
                    return $workHtml;
                })
                ->addColumn('images', function ($experience) {
                    $images = "";
                    if ($experience->image) {
                        $images = "<div style='max-height: 350px; overflow: hidden;'>
                            <img src='" . asset("storage/{$experience->image}") . "' alt='{$experience->nama}' class='img img-fluid'>
                        </div>";
                    }

                    return $images;
                })
                ->editColumn('updated_at', function ($experience) {
                    return !empty($experience->updated_at) ? date("Y-m-d H:i:s", strtotime($experience->updated_at)) : "-";
                })
                ->rawColumns(['action', 'updated_at', 'images', 'educations', 'work_experiences'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('experience.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('experience.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|unique:experiences,nama',
                'no_ktp' => 'required|integer',
                'image' => 'required|image|max:2048'
            ]);

            DB::beginTransaction();

            $experience = new Experience();
            $experience->nama = $request->nama;
            $experience->alamat = $request->alamat;
            $experience->no_ktp = $request->no_ktp;
            if ($request->file('image')) {
                $experience->image = $request->file('image')->store('experience-images');
            }
            $experience->save();

            $result_education = [];
            if (count($request->nama_sekolah) > 0) {
                foreach ($request->nama_sekolah as $key => $val) {
                    $result_education[] = [
                        'experience_id' => $experience->id,
                        'nama_sekolah' => $val,
                        'jurusan' => !empty($request->jurusan[$key]) ? $request->jurusan[$key] : null,
                        'tahun_masuk' => !empty($request->tahun_masuk[$key]) ? $request->tahun_masuk[$key] : null,
                        'tahun_lulus' => !empty($request->tahun_lulus[$key]) ? $request->tahun_lulus[$key] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                EducationExperience::insert($result_education);
            }

            $result_work = [];
            if (count($request->perusahaan) > 0) {
                foreach ($request->perusahaan as $key2 => $val2) {
                    $result_work[] = [
                        'experience_id' => $experience->id,
                        'perusahaan' => $val2,
                        'jabatan' => !empty($request->jabatan[$key2]) ? $request->jabatan[$key2] : null,
                        'tahun' => !empty($request->tahun[$key2]) ? $request->tahun[$key2] : null,
                        'keterangan' => !empty($request->keterangan[$key2]) ? $request->keterangan[$key2] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                WorkExperience::insert($result_work);
            }
            DB::commit();
            return to_route('experience.index')->with('success', 'New Experience has been added!');
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $exp = Experience::with(['educations', 'works'])->where('id', $id)->first();
        return view('experience.edit', compact('exp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'string|unique:experiences,nama,' . $id,
                'no_ktp' => 'integer',
                'image' => 'image|max:2048'
            ]);

            DB::beginTransaction();

            $experience = Experience::find($id);
            $experience->nama = $request->nama;
            $experience->alamat = $request->alamat;
            $experience->no_ktp = $request->no_ktp;
            if ($request->file('image')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $experience->image = $request->file('image')->store('experience-images');
            }
            $experience->update();

            $result_education = [];
            if (count($request->nama_sekolah) > 0) {
                $experience->educations()->delete();
                foreach ($request->nama_sekolah as $key => $val) {
                    $result_education[] = [
                        'experience_id' => $experience->id,
                        'nama_sekolah' => $val,
                        'jurusan' => !empty($request->jurusan[$key]) ? $request->jurusan[$key] : null,
                        'tahun_masuk' => !empty($request->tahun_masuk[$key]) ? $request->tahun_masuk[$key] : null,
                        'tahun_lulus' => !empty($request->tahun_lulus[$key]) ? $request->tahun_lulus[$key] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                EducationExperience::insert($result_education);
            }

            $result_work = [];
            if (count($request->perusahaan) > 0) {
                $experience->works()->delete();
                foreach ($request->perusahaan as $key2 => $val2) {
                    $result_work[] = [
                        'experience_id' => $experience->id,
                        'perusahaan' => $val2,
                        'jabatan' => !empty($request->jabatan[$key2]) ? $request->jabatan[$key2] : null,
                        'tahun' => !empty($request->tahun[$key2]) ? $request->tahun[$key2] : null,
                        'keterangan' => !empty($request->keterangan[$key2]) ? $request->keterangan[$key2] : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                WorkExperience::insert($result_work);
            }
            DB::commit();
            return to_route('experience.index')->with('success', 'Experience has been updated!');
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        if ($experience->image) {
            Storage::delete($experience->image);
        }

        $experience->delete();

        return to_route('experience.index')->with('success', 'Experience has been deleted!');
    }
}