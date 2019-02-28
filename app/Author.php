<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Author extends Model
{
    protected $fillable = ['name'];

    public function books() {
        return $this->hasMany('App\Book');
    }

    public static function boot() {
        parent::boot();

        self::deleting(function($author){
            // Cek apakah penulis punya buku
            if($author->books->count() > 0) {
                // Menyiapkan pesan error
                $html = "Penulis $author->name tidak bisa dihapus karena masih mempunyai buku";
                $html .= '<ul>';
                foreach ($author->books as $book) {
                    $html .= "<li>$book->title</li>";
                }
                $html .= '</ul>';

                Session::flash("flash_notification", [
                    'level' => "danger",
                    'message' => $html
                ]);

                // membatalkan proses hapus
                return false;
            }
        });
    }
}
