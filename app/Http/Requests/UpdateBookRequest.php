<?php
/**
 * Created by PhpStorm.
 * User: ofid
 * Date: 03/01/19
 * Time: 17.24
 *
 * @author Khofidin <offiedz@gmail.com>
 */

namespace App\Http\Requests;


class UpdateBookRequest extends StoreBookRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['title'] = 'required|unique:books,title,' . $this->route('book');

        return $rules;
    }
}