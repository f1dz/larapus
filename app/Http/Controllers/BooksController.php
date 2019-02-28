<?php

namespace App\Http\Controllers;

use App\Book;
use function compact;
use Illuminate\Http\Request;
use function round;
use function route;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
