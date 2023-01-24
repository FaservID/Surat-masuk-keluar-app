<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Classifications;
use App\Models\Letters;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class IncomingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inLetterIndex()
    {
        return view('pages.admin.transactions.incoming.index', [
            'letters' => Letters::with('classification')->where('type', 'incoming')->orderBy('created_at','DESC')->paginate(5),
        ]);
    }

    public function inLetterCreate()
    {
        return view('pages.admin.transactions.incoming.create', [
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
                ->route('admin.incomingTransactionIndex')
                ->with('success', 'Berhasil Menambahkan Data');
        } catch (\Throwable $exception) {
            Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('admin.incomingTransactionIndex')
                ->with('error', 'Gagal Menambahkan Data');
        }
    }

    public function inLetterDetail($id)
    {

        return view('pages.admin.transactions.incoming.detail', [
            'letter' => Letters::findOrFail($id)
        ]);
    }

    public function inLetterEdit($id)
    {
        return view('pages.admin.transactions.incoming.edit', [
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
                ->route('admin.incomingTransactionIndex')
                ->with('success', 'Berhasil Mengubah Data');
        } catch (\Throwable $exception) {
            Alert::error('Error!', $exception->getMessage());
            return redirect()
                ->route('admin.incomingTransactionIndex')
                ->with('error', 'Gagal Mengubah Data');
        }
    }

    public function inLetterDestroy($id){
        try {
            Letters::where('id', $id)->delete();
            // Alert::success('Sukses!', 'Berhasil menghapus Data');
            return redirect()
                ->route('admin.incomingTransactionIndex')
                ->with('success', 'Berhasil Menghapus Data');

        } catch (\Throwable $exception) {
            // alert::error('Error!', $exception->getMessage());
            return redirect()
            ->route('admin.incomingTransactionIndex')
            ->with('error', 'Gagal Menghapus Data');
        }
    }



    /* Agenda */
    public function inAgendaIndex()
    {
        return view('pages.admin.agenda.incoming.index', [
            'letters' => Letters::with('classification')->where('type','incoming')->orderBy('created_at','DESC')->paginate(5),
        ]);
    }

    public function inAgendaSearchDate(Request $request) {
        // $this->validate($request, [
        //     'from' => 'required',
        //     'to' => 'required',
        //     'sortby' => 'required',
        //     // 'attachments' => 'required'
        // ]);
        $startDate = Carbon::parse($request->from)->isoFormat('YYYY-MM-D');
        $endDate = Carbon::parse($request->to)->isoFormat('YYYY-MM-D');
        $keyword = $request->sortby;


        if($keyword === "1") {
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
        
        return view('pages.admin.agenda.incoming.index', [
            'letters' => $results,
        ]);
    }

    public function inAgendaExport(Request $request) {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'sortby' => 'required',
            // 'attachments' => 'required'
        ]);
        $startDate = Carbon::parse($request->from)->isoFormat('YYYY-MM-D');
        $endDate = Carbon::parse($request->to)->isoFormat('YYYY-MM-D');
        $keyword = $request->sortby;

        if($keyword === "1") {
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
    public function inGalleryIndex() {
        return view('pages.admin.gallery.incoming.index', [
            'letters' => Letters::where('type', 'incoming')->orderBy('letter_date', 'DESC')->paginate(12)
        ]);
    }
}
