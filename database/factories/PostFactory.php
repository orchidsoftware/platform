<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Faker\Generator as Faker;
use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Core\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {

	$lang		=	App::getLocale();
	
	$user		=	User::inRandomOrder()->first()->id;
	
	//$type		= 	 $faker->randomElement(["page","demo"]);
	$type		= 	 $faker->randomElement(["demo"]);
	
	$status		= 	["publish"];
	
	$name		=	$faker->sentence($nbWords = 6, $variableNbWords = true);
	
	
	
/*
	{"en":{"name":"+5656565444","body":"<p>Demo Page Text<\/p>","body2":"Demo Mardown","picture":"\/storage\/2018\/01\/20\/8aecea9051df529eaeda9277f5ed842fb2e74d38.png","open":"2017-12-01 01:55:03","robot":"noindex","block":"javascript code branch","title":"Article SEO title","description":"Page Short description","keywords":"key1,key2 node,key3"},"ru":{"list":["123214","jkl;jlj","jhhjhjh","hjgjhg",null],"name":null,"body":null,"body2":null,"picture":null,"open":"2017-12-19 01:55:03","block":null,"title":null,"description":null,"keywords":null,"robot":"index"}}
	
	//$MenuTitle 	= 	$faker->unique()->word;
	
	//$RobotArr	= 	["answer","chapter","co-worker","colleague","contact",
					"details","edit","friend","question","archives","author",
					"bookmark","first","help","index","last","license","me",
					"next","nofollow","noreferrer","prefetch","prev","search",
					"sidebar","tag","up"];
*/					
    $post= [
        'user_id'	=> $user,
        'type'		=> $type,
        'status'	=> $faker->randomElement($status),
		'content' => [
            $lang => [
                'name'		=> $name,
                'title'		=> $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description'=> $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
                'body'		=> $faker->text,
                'body2'		=> $faker->text,
                'picture'	=> $faker->imageUrl($width = 640, $height = 480),
                'open'		=> $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)->format('Y-m-d H:i:s'),
                'robot'		=> $faker->randomElement(["noindex"]),
                'block'		=> $faker->text,
                'keywords'	=> implode(',', $faker->words($nb = 5, $asText = false)),
                'list'	=> $faker->words($nb = 5, $asText = false),
            ],
        ],
		'options' => [
            'locale' => [
				'en'	=> "true",
			],
		],
		'slug' => ($type=="page")?"demo-page":Str::slug($name),  //'slug' => "demo-page"
    ];
	//dd($post);
	return $post;
});