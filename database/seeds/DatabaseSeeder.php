<?php

use Illuminate\Database\Seeder;
use App\Film;
use App\User;
use App\Comment;
use App\Genre;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker\Factory::create();
        $filmCount = Film::count();

        if($filmCount == 0){
        	for($i = 0; $i < 3; $i++) {
		        
		        $film = new Film;
				$film->name = $faker->sentence;
				$film->slug = str_slug($faker->sentence, '_');
				$film->description = $faker->paragraph;
				$film->release_date = '2018-07-27';
				$film->rating = 3;
				$film->ticket_price = 50.50;
				$film->country = 'India';
				$film->photo = $faker->image('storage/app/public',400,300, null, false);
	            $film->save();

	            $genre = new Genre;
	            $genre->film_id = $film->id;
	            $genre->name = $faker->word;
	            $genre->save();

				$user = new User;
		        $user->name = $faker->name;
		        $user->email = $faker->email;
		        $user->password = bcrypt($faker->email);
		        $user->save();

		        for($j = 0; $j < 2; $j++) {
		        	$comment = new Comment;
		        	$comment->name = $faker->name;
		        	$comment->comment = $faker->sentence;
		        	$comment->film_id = $film->id;
		        	$comment->user_id = $user->id;
		        	$comment->save();
				}
		    }	
        }
	    
    }
}
