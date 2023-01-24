<?php

namespace App\Http\Controllers;

use App\Models\Letters;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KabidController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inLetterDetail($id)
    {
        return view('pages.admin.transactions.incoming.detail', [
            'letter' => Letters::findOrFail($id)
        ]);
    }

    public function outLetterDetail($id)
    {
        return view('pages.admin.transactions.outgoing.detail', [
            'letter' => Letters::findOrFail($id)
        ]);
    }

    /* Agenda */
    public function inAgendaIndex()
    {
        return view('pages.kabid.agenda.incoming.index', [
            'letters' => Letters::with('classification')->where('type', 'incoming')->orderBy('created_at', 'DESC')->paginate(5),
        ]);
    }

    public function inAgendaSearchDate(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'sortby' => 'required',
            // 'attachments' => 'required'
        ]);
        $startDate = Carbon::parse($request->from)->isoFormat('YYYY-MM-D');
        $endDate = Carbon::parse($request->to)->isoFormat('YYYY-MM-D');
        $keyword = $request->sortby;


        if ($keyword === "1") {
            $results = Letters::where('type', 'incoming')
                ->whereBetween('letter_date', [$startDate, $endDate])
                ->paginate(50);
        } else {
            $results = Letters::where('type', 'incoming')
                ->whereBetween('received_date', [$startDate, $endDate])
                ->paginate(50);
        }

        session()->flash('from', $startDate);
        session()->flash('to', $endDate);

        return view('pages.kabid.agenda.incoming.index', [
            'letters' => $results,
        ]);
    }

    public function inAgendaExport(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'sortby' => 'required',
            // 'attachments' => 'required'
        ]);
        $startDate = Carbon::parse($request->from)->isoFormat('YYYY-MM-D');
        $endDate = Carbon::parse($request->to)->isoFormat('YYYY-MM-D');
        $keyword = $request->sortby;

        if ($keyword === "1") {
            $results = Letters::where('type', 'incoming')
                ->whereBetween('letter_date', [$startDate, $endDate])
                ->get();
        } else {
            $results = Letters::where('type', 'incoming')
                ->whereBetween('received_date', [$startDate, $endDate])
                ->get();
        }


        return view('pages.reports.surat_masuk', [
            'letters' => $results,
        ]);
    }



    /* OUTGOING AGENDA */

    /* Agenda */
    public function outAgendaIndex()
    {
        return view('pages.kabid.agenda.outgoing.index', [
            'letters' => Letters::with('classification')->where('type', 'outgoing')->orderBy('created_at', 'DESC')->paginate(5),
        ]);
    }

    public function outAgendaSearchDate(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'sortby' => 'required',
            // 'attachments' => 'required'
        ]);
        $startDate = Carbon::parse($request->from)->isoFormat('YYYY-MM-D');
        $endDate = Carbon::parse($request->to)->isoFormat('YYYY-MM-D');
        $keyword = $request->sortby;


        $results = Letters::where('type', 'outgoing')
            ->whereBetween('letter_date', [$startDate, $endDate])
            ->paginate(50);


        session()->flash('from', $startDate);
        session()->flash('to', $endDate);

        return view('pages.kabid.agenda.outgoing.index', [
            'letters' => $results,
        ]);
    }

    public function outAgendaExport(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'sortby' => 'required',
            // 'attachments' => 'required'
        ]);
        $startDate = Carbon::parse($request->from)->isoFormat('YYYY-MM-D');
        $endDate = Carbon::parse($request->to)->isoFormat('YYYY-MM-D');
        $keyword = $request->sortby;


        $results = Letters::where('type', 'outgoing')
            ->whereBetween('letter_date', [$startDate, $endDate])
            ->get();


        return view('pages.reports.surat_keluar', [
            'letters' => $results,
        ]);
    }


    /* GALERY */
    /* GALLERY OUTGOING */
    public function outGalleryIndex()
    {
        return view('pages.kabid.gallery.outgoing.index', [
            'letters' => Letters::where('type', 'outgoing')->orderBy('letter_date', 'DESC')->paginate(12)
        ]);
    }

    /* GALLERY INCOMING */
    public function inGalleryIndex()
    {
        return view('pages.kabid.gallery.incoming.index', [
            'letters' => Letters::where('type', 'incoming')->orderBy('letter_date', 'DESC')->paginate(12)
        ]);
    }

    /* PROFILE */
    public function kabidProfile()
    {
        return view('pages.profile.index');
    }

    public function kabidUploadPicture(Request $request)
    {
        $id = $request->id;

        if (!$request->hasFile('picture')) {
            return redirect()->back()->with('error', 'Anda belum memilih foto');
        }

        $file = $request->file('picture');
        $extension = $file->getClientOriginalExtension();
        // if (!in_array($file, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
        $filename = time() . '-' . $file->getClientOriginalName();
        $filename = str_replace(' ', '-', $filename);
        $file->move('profile-picture', $filename);
        User::where('id', $id)->update(['profile_picture' => $filename]);

        return redirect()->route('kabid.profileIndex')->with('success', 'Berhasil Mengubah Foto Profil');
    }

    public function kabidDataUpdate($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ];

        try {
            User::where('id', $id)->update($data);
            return redirect()->route('kabid.profileIndex')->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            return redirect()->route('kabid.profileIndex')->with('error', 'Gagal Mengubah Data');
        }
    }

    public function kabidPasswordUpdate(Request $request)
    {
        $this->validate($request, [
            'password1' => 'required',
            'password2' => 'required',
        ]);
        $id = $request->id;
        $pass1 = $request->password1;
        $pass2 = $request->password2;
        try {
            if ($pass1 === $pass2) {
                $convPass = bcrypt($pass1);
                User::where('id', $id)->update(['password' => $convPass]);
                return redirect()->route('kabid.profileIndex')->with('success', 'Password Berhasil diubah');
            } else {
                return redirect()->route('kabid.profileIndex')->with('error', 'Password tidak sama');
            }
        } catch (\Throwable $exception) {
            return redirect()->route('kabid.profileIndex')->with('error', 'Gagal mengubah password');
        }
    }
}
