<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 13/03/18
 * Time: 12:24
 */

namespace App\Exceptions;


class NoTienePermisoARutaException extends MiExceptionClass
{
    /**
     * @var string
     */
    protected $status = '403';
    /**
     * @return void
     */
    public function __construct()
    {
        $message = $this->build(func_get_args());

        parent::__construct($message);
    }
}