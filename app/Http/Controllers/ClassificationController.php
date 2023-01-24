<?php

namespace App\Http\Controllers;

use App\Models\Classifications;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.classification.index', [
            'classifications' => Classifications::orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.classification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:classifications,code',
            'type' => 'required',
            'description' => 'required',
        ]);

        try {
            $data = [
                'code' => $request->code,
                'type' => $request->type,
                'description' => $request->description,
            ];

            Classifications::create($data);
            return redirect()
                ->route('admin.classificationIndex')
                ->with('success', 'Berhasil Menambahkan Data');
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.classificationIndex')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function show(Classifications $classifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.admin.classification.edit', [
            'classification' => Classifications::where('code', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        try {
            $data = [
                'code' => $request->code,
                'type' => $request->type,
                'description' => $request->description,
            ];

            Classifications::where('code', $id)->update($data);
            return redirect()
                ->route('admin.classificationIndex')
                ->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.classificationIndex')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Classifications::where('code', $id)->delete();
            return redirect()
                ->route('admin.classificationIndex')
                ->with('success', 'Berhasil Menghapus Data');
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.classificationIndex')
                ->with('error', $exception->getMessage());
        }
    }





    /* STAFF */

    public function staffIndex()
    {
        return view('pages.staff.classification.index', [
            'classifications' => Classifications::orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function staffCreate()
    {
        return view('pages.staff.classification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function staffStore(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:classifications,code',
            'type' => 'required',
            'description' => 'required',
        ]);

        try {
            $data = [
                'code' => $request->code,
                'type' => $request->type,
                'description' => $request->description,
            ];

            Classifications::create($data);
            return redirect()
                ->route('staff.classificationIndex')
                ->with('success', 'Berhasil Menambahkan Data');
        } catch (\Throwable $exception) {
            return redirect()
                ->route('staff.classificationIndex')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function staffEdit($id)
    {
        return view('pages.staff.classification.edit', [
            'classification' => Classifications::where('code', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function staffUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        try {
            $data = [
                'code' => $request->code,
                'type' => $request->type,
                'description' => $request->description,
            ];

            Classifications::where('code', $id)->update($data);
            return redirect()
                ->route('staff.classificationIndex')
                ->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            return redirect()
                ->route('staff.classificationIndex')
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classifications  $classifications
     * @return \Illuminate\Http\Response
     */
    public function staffDestroy($id)
    {
        try {
            Classifications::where('code', $id)->delete();
            return redirect()
                ->route('staff.classificationIndex')
                ->with('success', 'Berhasil Menghapus Data');
        } catch (\Throwable $exception) {
            return redirect()
                ->route('staff.classificationIndex')
                ->with('error', $exception->getMessage());
        }
    }
}
