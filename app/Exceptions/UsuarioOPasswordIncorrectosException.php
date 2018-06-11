<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 20/04/18
 * Time: 11:35
 */

namespace App\Exceptions;


class UsuarioOPasswordIncorrectosException extends MiExceptionClass
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