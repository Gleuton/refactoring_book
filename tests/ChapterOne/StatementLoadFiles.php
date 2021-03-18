<?php

namespace Tests\ChapterOne;

class StatementLoadFiles
{
    public object $invoices;
    public object $plays;

    public function __construct()
    {
        $invoices_file = file_get_contents(
            __DIR__ . '/json/invoices.json'
        );
        $plays_file    = file_get_contents(
            __DIR__ . '/json/plays.json'
        );
        try {
            $this->invoices = json_decode(
                $invoices_file,
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            $this->plays = json_decode(
                $plays_file,
                false,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            echo $e->getMessage();
        }
    }
    
    
}
