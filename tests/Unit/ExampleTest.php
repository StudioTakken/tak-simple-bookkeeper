<?php

// uses()->group('1');

it('can run an test');

it('is true', function () {
    expect(true)->toBeTrue();
})->group('1')
    // ->skip('Not implemented yet')
;
