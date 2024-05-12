<?php

it('login success', function () {
    $credential = [
        'email' => 'kyawzinlat43021@gmail.com',
        'password' => '11111111'
    ];

    $response = $this->post('login',$credential);
    $this->assertAuthenticated();
});

it('has test page', function () {
    $response = $this->get(route('dashboard'));

    $this->assertStatus(200);
});
