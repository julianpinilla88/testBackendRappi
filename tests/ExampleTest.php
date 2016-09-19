<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->submitForm('Iniciar', [
                'txtNumCaso'       => '2',
                'txtMatriz'      => '4 5',
            ])
            ->onPage('/matriz/store')
            ->assertRedirectedToRoute('/matriz');;
    }
}
