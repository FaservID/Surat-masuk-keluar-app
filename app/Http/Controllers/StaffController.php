<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Classifications;
use App\Models\Letters;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inLetterIndex()
    {
        return view('pages.staff.transactions.incoming.index', [
            'letters' => Letters::with('classification')->where('type', 'incoming')->orderBy('created_at', 'DESC')->paginate(5),
        ]);
    }

    public function inLetterCreate()
    {
        return view('pages.staff.transactions.incoming.create', [
            'classifications' => Classifications::all()
        ]);
    }

    public function inLetterStore(Request $request)
    {
        $this->validate($request, [
            'reference_number' => 'required|unique:letters,reference_number',
            'agenda_number' => 'required',
            'from' => 'required',
            'letter_date' => 'required',
            'received_date' => 'required',
            'description' => 'required',
            'classification_code' => 'required',
            'attachments' => 'required|mimes:jpeg,pdf,jpg,png,docx,doc',
        ]);

        try {
            $data = [
                'reference_number' => $request->reference_number,
                'agenda_number' => $request->agenda_number,
                'from' => $request->from,
                'letter_date' => $request->letter_date,
                'received_date' => $request->received_date,
                'description' => $request->description,
                'note' => $request->note,
                'type' => "incoming",
                'classification_code' => $request->classification_code,
                'user_id' => Auth::user()->id
            ];
            $letter = Letters::create($data);

            if ($request->hasFile('attachments')) {
                // foreach ($request->attachments as $attachment) {
                $file = $request->file('attachments');
                $extension = $file->getClientOriginalExtension();
                // if (!in_array($file, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                $filename = time() . '-' . $file->getClientOriginalName();
                $filename = str_replace(' ', '-', $filename);
                $file->move('attachments', $filename);
                Attachments::create([
                    'filename' => $filename,
                    'extension' => $extension,
                    'user_id' => Auth::user()->id,
                    'letter_id' => $letter->id,
                ]);
                // }
            }
            // Alert::success('Sukses!', 'Berhasil Menambahkan Data');

            return redirect()
                ->route('staff.incomingTransactionIndex')
                ->with('success', 'Berhasil Menambahkan Data');
        } catch (\Throwable $exception) {
            // Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('staff.incomingTransactionIndex')
                ->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function inLetterDetail($id)
    {

        return view('pages.staff.transactions.incoming.detail', [
            'letter' => Letters::findOrFail($id)
        ]);
    }

    public function inLetterEdit($id)
    {
        $checkId = Letters::where('id', $id)->first();


        if ($checkId->user_id !== Auth::user()->id) {
            return redirect()->route('staff.incomingTransactionIndex')->with('error', 'Kamu tidak diizinkan mengubah data orang lain!');
        }

        return view('pages.staff.transactions.incoming.edit', [
            'letter' => Letters::findOrFail($id),
            'classifications' => Classifications::all()
        ]);
    }

    public function inLetterUpdate($id, Request $request)
    {
        $currentFile = Attachments::where('letter_id', $id)->first();
        $currArr = [
            'filename' => $currentFile->filename,
            'extension' => $currentFile->extension,
            'letter_id' => $currentFile->letter_id,
            'user_id' => $currentFile->user_id
        ];
        // dd($currArr);
        $newData = Letters::findOrFail($id);
        $this->validate($request, [
            'reference_number' => 'required',
            'agenda_number' => 'required',
            'from' => 'required',
            'letter_date' => 'required',
            'received_date' => 'required',
            'description' => 'required',
            'classification_code' => 'required',
            'attachments' => 'mimes:jpeg,pdf,jpg,png,docx,doc',
        ]);

        try {
            $data = [
                'reference_number' => $request->reference_number,
                'agenda_number' => $request->agenda_number,
                'from' => $request->from,
                'letter_date' => $request->letter_date,
                'received_date' => $request->received_date,
                'description' => $request->description,
                'note' => $request->note,
                'classification_code' => $request->classification_code,
            ];

            Letters::where('id', $id)->update($data);
            // $currentImage = $newData->attachments->filename;
            $checkImage = $request->hasFile('attachments');

            if (!$checkImage) {
                Attachments::where('letter_id', $id)->update($currArr);
            } else {
                $file = $request->file('attachments');
                $extension = $file->getClientOriginalExtension();
                // if (!in_array($file, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                $filename = time() . '-' . $file->getClientOriginalName();
                $filename = str_replace(' ', '-', $filename);
                $file->move('attachments', $filename);
                Attachments::where('letter_id', $id)->update([
                    'filename' => $filename,
                    'extension' => $extension,
                    'user_id' => $newData->user_id,
                    'letter_id' => $newData->id,
                ]);
            }
            // Alert::success('Sukses!', 'Berhasil Mengubah Data');
            // toast('Success Toast','success'); 
            return redirect()
                ->route('staff.incomingTransactionIndex')
                ->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            // Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('staff.incomingTransactionIndex')
                ->with('error', 'Gagal Mengubah Data');
        }
    }

    public function inLetterDestroy($id)
    {
        $checkId = Letters::where('id', $id)->first();

        try {
            if ($checkId->user_id !== Auth::user()->id) {
                return redirect()->route('staff.incomingTransactionIndex')->with('error', 'Kamu tidak memiliki Izin untuk menghapus data milik orang lain!');
            }

            Letters::where('id', $id)->delete();
            // Alert::success('Sukses!', 'Berhasil menghapus Data');
            return redirect()
                ->route('staff.incomingTransactionIndex')
                ->with('success', 'Berhasil Menghapus Data');
        } catch (\Throwable $exception) {
            // alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('staff.incomingTransactionIndex')
                ->with('error', $exception->getMessage());
        }
    }



    /* Agenda */
    public function inAgendaIndex()
    {
        return view('pages.staff.agenda.incoming.index', [
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

        return view('pages.staff.agenda.incoming.index', [
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


    /* GALLERY INCOMING */
    public function inGalleryIndex()
    {
        return view('pages.staff.gallery.incoming.index', [
            'letters' => Letters::where('type', 'incoming')->orderBy('letter_date', 'DESC')->paginate(12)
        ]);
    }


    public function outLetterIndex()
    {
        return view('pages.staff.transactions.outgoing.index', [
            'letters' => Letters::with('classification')->where('type', 'outgoing')->orderBy('created_at', 'DESC')->paginate(5),
        ]);
    }

    public function outLetterCreate()
    {
        return view('pages.staff.transactions.outgoing.create', [
            'classifications' => Classifications::all()
        ]);
    }

    public function outLetterStore(Request $request)
    {
        $this->validate($request, [
            'reference_number' => 'required|unique:letters,reference_number',
            'agenda_number' => 'required',
            'to' => 'required',
            'letter_date' => 'required',
            'description' => 'required',
            'classification_code' => 'required',
            'attachments' => 'required|mimes:jpeg,pdf,jpg,png,docx,doc',
        ]);

        try {
            $data = [
                'reference_number' => $request->reference_number,
                'agenda_number' => $request->agenda_number,
                'to' => $request->to,
                'letter_date' => $request->letter_date,
                'description' => $request->description,
                'note' => $request->note,
                'type' => "outgoing",
                'classification_code' => $request->classification_code,
                'user_id' => Auth::user()->id
            ];

            $letter = Letters::create($data);

            if ($request->hasFile('attachments')) {
                // foreach ($request->attachments as $attachment) {
                $file = $request->file('attachments');
                $extension = $file->getClientOriginalExtension();
                // if (!in_array($file, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                $filename = time() . '-' . $file->getClientOriginalName();
                $filename = str_replace(' ', '-', $filename);
                $file->move('attachments', $filename);
                Attachments::create([
                    'filename' => $filename,
                    'extension' => $extension,
                    'user_id' => Auth::user()->id,
                    'letter_id' => $letter->id,
                ]);
                // }
            }
            // Alert::success('Sukses!', 'Berhasil Menambahkan Data');

            return redirect()
                ->route('staff.outgoingTransactionIndex')
                ->with('success', 'Berhasil Menambahkan Data');
        } catch (\Throwable $exception) {
            // Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('staff.outgoingTransactionIndex')
                ->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function outLetterDetail($id)
    {

        return view('pages.staff.transactions.outgoing.detail', [
            'letter' => Letters::findOrFail($id)
        ]);
    }

    public function outLetterEdit($id)
    {
        $checkId = Letters::where('id', $id)->first();


        if ($checkId->user_id !== Auth::user()->id) {
            return redirect()->route('staff.outgoingTransactionIndex')->with('error', 'Kamu tidak diizinkan mengubah data orang lain!');
        }
        return view('pages.staff.transactions.outgoing.edit', [
            'letter' => Letters::findOrFail($id),
            'classifications' => Classifications::all()
        ]);
    }

    public function outLetterUpdate($id, Request $request)
    {
        $currentFile = Attachments::where('letter_id', $id)->first();
        $currArr = [
            'filename' => $currentFile->filename,
            'extension' => $currentFile->extension,
            'letter_id' => $currentFile->letter_id,
            'user_id' => $currentFile->user_id
        ];
        // dd($currArr);
        $newData = Letters::findOrFail($id);
        $this->validate($request, [
            'reference_number' => 'required',
            'agenda_number' => 'required',
            'to' => 'required',
            'letter_date' => 'required',
            'description' => 'required',
            'classification_code' => 'required',
            'attachments' => 'mimes:jpeg,pdf,jpg,png,docx,doc',
        ]);
        $checkId = Letters::where('id', $id)->first();

        try {

            $data = [
                'reference_number' => $request->reference_number,
                'agenda_number' => $request->agenda_number,
                'to' => $request->to,
                'letter_date' => $request->letter_date,
                'description' => $request->description,
                'note' => $request->note,
                'classification_code' => $request->classification_code,
            ];

            Letters::where('id', $id)->update($data);
            // $currentImage = $newData->attachments->filename;
            $checkImage = $request->hasFile('attachments');

            if (!$checkImage) {
                Attachments::where('letter_id', $id)->update($currArr);
            } else {
                $file = $request->file('attachments');
                $extension = $file->getClientOriginalExtension();
                // if (!in_array($file, ['png', 'jpg', 'jpeg', 'pdf'])) continue;
                $filename = time() . '-' . $file->getClientOriginalName();
                $filename = str_replace(' ', '-', $filename);
                $file->move('attachments', $filename);
                Attachments::where('letter_id', $id)->update([
                    'filename' => $filename,
                    'extension' => $extension,
                    'user_id' => $newData->user_id,
                    'letter_id' => $newData->id,
                ]);
            }
            // Alert::success('Sukses!', 'Berhasil Mengubah Data');
            // toast('Success Toast','success'); 
            return redirect()
                ->route('staff.outgoingTransactionIndex')
                ->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            // Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('staff.outgoingTransactionIndex')
                ->with('error', 'Gagal Mengubah Data');
        }
    }

    public function outLetterDestroy($id)
    {
        $checkId = Letters::where('id', $id)->first();

        try {
            if ($checkId->user_id !== Auth::user()->id) {
                return redirect()->route('staff.outgoingTransactionIndex')->with('error', 'Kamu tidak memiliki Izin untuk menghapus data milik orang lain!');
            }
            // Alert::success('Sukses!', 'Berhasil menghapus Data');
            return redirect()
                ->route('staff.outgoingTransactionIndex')
                ->with('success', 'Berhasil Menghapus Data');
        } catch (\Throwable $exception) {
            // alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('staff.outgoingTransactionIndex')
                ->with('error', 'Gagal Menghapus Data');
        }
    }

    /* Agenda */
    public function outAgendaIndex()
    {
        return view('pages.staff.agenda.outgoing.index', [
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

        return view('pages.staff.agenda.outgoing.index', [
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


    /* GALLERY OUTGOING */
    public function outGalleryIndex()
    {
        return view('pages.staff.gallery.outgoing.index', [
            'letters' => Letters::where('type', 'outgoing')->orderBy('letter_date', 'DESC')->paginate(12)
        ]);
    }


    /* PROFILE */
    public function staffProfile()
    {
        return view('pages.profile.index');
    }

    public function staffUploadPicture(Request $request)
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

        return redirect()->route('staff.profileIndex')->with('success', 'Berhasil Mengubah Foto Profil');
    }

    public function staffDataUpdate($id, Request $request)
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
            return redirect()->route('staff.profileIndex')->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            return redirect()->route('staff.profileIndex')->with('error', 'Gagal Mengubah Data');
        }
    }

    public function staffPasswordUpdate(Request $request)
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
                return redirect()->route('staff.profileIndex')->with('success', 'Password Berhasil diubah');
            } else {
                return redirect()->route('staff.profileIndex')->with('error', 'Password tidak sama');
            }
        } catch (\Throwable $exception) {
            return redirect()->route('staff.profileIndex')->with('error', 'Gagal mengubah password');
        }
    }
}
