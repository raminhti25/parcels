<?php

namespace Database\Seeders;

use App\Models\Biker;
use App\Models\Sender;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Sender::create([
            'first'     => 'ramin',
            'last'      => 'heshmati',
            'email'     => 'raminhti@gmail.com',
            'mobile'     => '+989361550458',
            'password'   => '124578',
        ]);

        Sender::create([
            'first'     => 'john',
            'last'      => 'doe',
            'email'     => 'sender1@localhost.com',
            'mobile'     => '+989361550458',
            'password'   => '124578',
        ]);

        Sender::create([
            'first'     => 'nathan',
            'last'      => 'drake',
            'email'     => 'sender2@localhost.com',
            'mobile'     => '+989361550458',
            'password'   => '124578',
        ]);

        Sender::create([
            'first'     => 'leon',
            'last'      => 'kennedy',
            'email'     => 'sender3@localhost.com',
            'mobile'     => '+989361550458',
            'password'   => '124578',
        ]);

        Sender::create([
            'first'     => 'leonardo',
            'last'      => 'DiCaprio',
            'email'     => 'sender4@localhost.com',
            'mobile'     => '+989361550458',
            'password'   => '124578',
        ]);

        Biker::create([
            'first'     => 'George',
            'last'      => 'Clooney',
            'email'     => 'biker1@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Jennifer',
            'last'      => 'Aniston',
            'email'     => 'biker2@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Robert',
            'last'      => 'Downey Jr',
            'email'     => 'biker3@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Scarlett',
            'last'      => 'Johansson',
            'email'     => 'biker4@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Natalie',
            'last'      => 'Portman',
            'email'     => 'biker5@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Chris',
            'last'      => 'Hemsworth',
            'email'     => 'biker6@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Jennifer',
            'last'      => 'Lawrence',
            'email'     => 'biker7@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Will',
            'last'      => 'Smith',
            'email'     => 'biker8@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Lindsay',
            'last'      => 'Lohan',
            'email'     => 'biker9@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);

        Biker::create([
            'first'     => 'Brad',
            'last'      => 'Pitt',
            'email'     => 'biker10@localhost.com',
            'mobile'    => '0987654321',
            'password'   => '124578'
        ]);
    }
}
