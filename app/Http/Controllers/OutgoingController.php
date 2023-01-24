<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Classifications;
use App\Models\Letters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OutgoingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function outLetterIndex()
    {
        return view('pages.admin.transactions.outgoing.index', [
            'letters' => Letters::with('classification')->where('type', 'outgoing')->orderBy('created_at', 'DESC')->paginate(5),
        ]);
    }

    public function outLetterCreate()
    {
        return view('pages.admin.transactions.outgoing.create', [
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
                ->route('admin.outgoingTransactionIndex')
                ->with('success', 'Berhasil Menambahkan Data');
        } catch (\Throwable $exception) {
            // Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('admin.outgoingTransactionIndex')
                ->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function outLetterDetail($id)
    {

        return view('pages.admin.transactions.outgoing.detail', [
            'letter' => Letters::findOrFail($id)
        ]);
    }

    public function outLetterEdit($id)
    {
        return view('pages.admin.transactions.outgoing.edit', [
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
                ->route('admin.outgoingTransactionIndex')
                ->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('admin.outgoingTransactionIndex')
                ->with('error', 'Gagal Mengubah Data');
        }
    }

    public function outLetterDestroy($id)
    {
        try {
            Letters::where('id', $id)->delete();
            // Alert::success('Sukses!', 'Berhasil menghapus Data');
            return redirect()
                ->route('admin.outgoingTransactionIndex')
                ->with('success', 'Berhasil Menghapus Data');
        } catch (\Throwable $exception) {
            // alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('admin.outgoingTransactionIndex')
                ->with('error', 'Gagal Menghapus Data');
        }
    }

    /* Agenda */
    public function outAgendaIndex()
    {
        return view('pages.admin.agenda.outgoing.index', [
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

        return view('pages.admin.agenda.outgoing.index', [
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
        return view('pages.admin.gallery.outgoing.index', [
            'letters' => Letters::where('type', 'outgoing')->orderBy('letter_date', 'DESC')->paginate(12)
        ]);
    }
}
