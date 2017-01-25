<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Input;
use MongoDB\BSON\Timestamp;
use Symfony\Component\Yaml\Tests\B;

class BooksController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $books = Book::all()->toArray();
        $bookarray = [];

        foreach ($books as $i => $book) {
            $bookobject = (array_merge($book, [
                '_links' => [
                    'self' => [ 'href' => 'http://localhost:8000/api/books/'.$book['id'] ],
                    'next' => [ 'href' => 'http://localhost:8000/api/books/'.($book['id'] +1) ],
                ]
            ]));
            $bookarray[$i] = $bookobject;
        }
        return response($bookarray, 200);

    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
    }


    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store(Request $request)
    {
        $book = new Book();
        $book->name = $request->name;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->language = $request->language;
        $book->created_at = time();
        $book->updated_at = time();
        $book->save();

        return response($book, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id)->toArray();

        //Create custom object
        return response(array_merge($book, [
            '_links' => [
                'self' => [ 'href' => 'http://localhost:8000/api/books/'.$id ],
                'next' => [ 'href' => 'http://localhost:8000/api/books/'.($id + 1) ]
            ]
        ]), 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit()
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->name = $request->name;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->language = $request->language;
        $book->created_at = time();
        $book->updated_at = time();
        $book->save();

        return response($book, 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response('Deleted.', 200);
    }

}

//De opdracht staat op de studentserver onder public.www/api. Database moet nog gezet worden op https://sql.hosted.hr.nl.
