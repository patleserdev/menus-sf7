<?php

namespace App\Message;

final class MenusPDFMessage
{

    public function __construct(public readonly int $id, public readonly string $route)
    {


    }
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

//     private $name;

//     public function __construct(string $name)
//     {
//         $this->name = $name;
//     }

//    public function getName(): string
//    {
//        return $this->name;
//    }
}
