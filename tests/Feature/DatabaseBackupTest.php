<?php


it('can create a backup', function () {
    $this->artisan('database:backup')
        ->expectsOutput('Backitup baby')
        ->assertExitCode(0);
})->group('only')->skip('dont know how yet');

// how to test an artisan command with pest php

// https://stackoverflow.com/questions/59410086/how-to-test-an-artisan-command-with-pest-php
