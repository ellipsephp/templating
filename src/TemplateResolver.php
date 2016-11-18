<?php

namespace Pmall\Templating;

use Pmall\Formatting\FormatterInterface;

use Zend\Diactoros\Response\JsonResponse;

class ArrayFormatter implements FormatterInterface
{
    public function canFormat($something)
    {
        return is_array($something);
    }

    public function getFormattedResponseFrom($expected_format, $array)
    {
        if ($expected_format == 'application/json') {

            return new JsonResponse($array);

        }

        return $array;
    }
}
