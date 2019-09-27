<?php namespace App\Exceptions;

class DataException extends \Exception
{
    public static function forRecordNotFound(string $type='Record')
    {
        return new self(lang('Exceptions.recordNotFound', [$type]), 404);
    }

    public static function forRecordsNotFound(string $type='Record', string $message = null)
    {
        $message = $message !== null
            ? $message
            : lang('Exceptions.recordsNotFound', [$type]);

        return new self($message, 404);
    }

    public static function forProblemSaving($error = null)
    {
        if (empty($error))
        {
            $error = lang('Exceptions.saveProblem');
        }

        return new self($error, 500);
    }
}
