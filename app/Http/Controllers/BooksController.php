<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use function compact;
use const DIRECTORY_SEPARATOR;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use function public_path;
use function redirect;
use function route;
use function time;
use function view;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Html\Builder;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Builder $builder
     * @return void
     */
    public function index(Request $request, Builder $builder)
    {
        if($request->ajax()){
            $books = Book::with('author');
            return Datatables::of($books)
                ->addColumn('action', function($book){
                    return view('datatable._action', [
                        'model'             => $book,
                        'form_url'          => route('books.destroy', $book->id),
                        'edit_url'          => route('books.edit', $book->id),
                        'confirm_message'   => 'Yakin untuk menghapus ' . $book->name . '?'
                    ]);
                })->make(true);
        }

        $html = $builder
            ->addColumn(['data' => 'title', 'name' => 'title', 'title' => 'Judul'])
            ->addColumn(['data' => 'amount', 'name' => 'amount', 'title' => 'Jumlah'])
            ->addColumn(['data' => 'author.name', 'name' => 'author.name', 'title' => 'Penulis'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' => false]);

        return view('books.index')->with(compact('html'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("books.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->except('cover'));

        if($request->hasFile('cover')) {
            $uploaded_cover = $request->file('cover');
            $ext            = $uploaded_cover->getClientOriginalExtension();
            $filename       = md5(time()) . '.' . $ext;

            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $uploaded_cover->move($destinationPath, $filename);

            $book->cover = $filename;
            $book->save();
        }

        Session::flash('flash_notification', [
            'level' => 'success',
            'message' => "Berhasil menyimpan $book->title"
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        return view('books.edit')->with(compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBookRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::find($id);
        $book->update($request->all());

        if($request->hasFile('cover')) {
            $filename = null;
            $uploaded_cover = $request->file('cover');
            $ext = $uploaded_cover->getClientOriginalExtension();

            $filename = md5(time()). '.' . $ext;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';

            $uploaded_cover->move($destinationPath, $filename);

            if($book->cover) {
                $old_cover = $book->cover;
                $filePath = public_path() . DIRECTORY_SEPARATOR . '.' . $old_cover;

                try {
                    File::delete($filePath);
                } catch (FileNotFoundException $e) {

                }
             }

            $book->cover = $filename;
            $book->save();
        }

        Session::flash("flash_notification", [
            'level' => 'success',
            'message' => "Berhasil menyimpan buku $book->title"
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if($book->cover) {
            $old_cover = $book->cover;
            $filepath = public_path() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $old_cover;

            try {
                File::delete($filepath);
            } catch (FileNotFoundException $e) {
                // File sudah dihapus/tidak ada
            }
        }

        $book->delete();

        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Buku berhasil dihapus"
        ]);

        return redirect()->route('books.index');
    }
}
